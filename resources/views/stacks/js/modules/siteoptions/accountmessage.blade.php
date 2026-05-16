<script>
        $(document).on('submit','.account-message-loanagent-form, .account-message-selfapply-form',function (event) {
            event.preventDefault();
            var form = $(this);
            var submitButton = form.find('button[type="submit"]'); // Get the submit button inside the form
            var data = new FormData(this);
            $.ajax({
                url: form.attr("action"),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                beforeSend: function(){
                    submitButton.data('original-text', submitButton.html()); // Store original text
                    submitButton.html('<span class="spinner-border spinner-border-sm"></span> Updating...').attr('disabled', true);
                },
                success: function (result) {
                    submitButton.attr('disabled', false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        window.location.reload()
                    } else {
                        toastr.error(result.message);
                        submitButton.html(submitButton.data('original-text')).attr('disabled', false);
                    }
                },
                error: function (error) {
                    let errors = error.responseJSON.errors;
                    let errorsHtml = '';
                    $.each(errors, function (key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    submitButton.html(submitButton.data('original-text')).attr('disabled', false);
                }
            });
        });

</script>
