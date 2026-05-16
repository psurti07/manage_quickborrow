<script>
    $(document).ready(function(){
        $('.privacy-policy-form').submit(function (event) {
            var status = document.activeElement.innerHTML;
            event.preventDefault();
            if (status) {
                $('.ajax-error').html('');
                var editor = CKEDITOR.instances['editor1'];
                editor.updateElement();
                var data = new FormData(this);
                data.append('privacypolicy', $('#editor1').val());
                $.ajax({
                    url: $(this).attr("action"),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $('#privacy-policy-btn').html('<span class="spinner-border spinner-border-sm"></span> Update');
                        $('#privacy-policy-btn').attr('disabled', true);
                    },
                    success: function (result) {
                        $(this).attr("disabled", false);
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            $("#content").val(result.data)
                            $('#privacy-policy-btn').html('Update');
                            $('#privacy-policy-btn').attr('disabled', false);
                        } else {
                            toastr.error(result.message);
                            $('#privacy-policy-btn').html('Update');
                        $('#privacy-policy-btn').attr('disabled', false);
                        }
                    },
                    error: function (error) {
                        $(this).attr("disabled", false);
                        let errors = error.responseJSON.errors, errorsHtml = '';
                        $.each(errors, function (key, value) {
                            errorsHtml = '<strong>' + value[0] + '</strong>';
                            $('.' + key).html(errorsHtml);
                        });
                        $('#privacy-policy-btn').html('Update');
                        $('#privacy-policy-btn').attr('disabled', false);
                    }
                });
            }
        });
    });
</script>
