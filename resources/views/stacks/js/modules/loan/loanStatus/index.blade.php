<script>
    function deleteStatus(statusId, applicationId){
        swal({
            title: "Are you sure?",
            text: "You want to delete this status.",
            icon: "error",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel","Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: '{!! route('manage.selfapply.loan.application.details.status.delete')  !!}',
                    type: 'POST',
                    data:  JSON.stringify({statusId: statusId,applicationId: applicationId}),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            let url = '{{ route("manage.selfapply.loan.application.details", ["applicationId" => ":applicationId"]) }}';
                            url = url.replace(':applicationId', applicationId);
                            setTimeout(function () {
                                window.location.href = url;
                            }, 1000)
                        }
                    }
                });
            }
        });
    }

    function statusChecksum(statusId){
        if(statusId == 1) {
            document.getElementById("otherdetails").style.display = "block";
        }
        else {
            document.getElementById("otherdetails").style.display = "none";
        }
        $.ajax({
            url: '{!! route('manage.selfapply.loan.application.status.predefine.message')  !!}',
            type: 'POST',
            data:  JSON.stringify({statusId: statusId}),
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $("#predefinemessage").find('option').remove();
                document.getElementById("remarks").value = "";

                if(result.type === 'SUCCESS') {
                    $("#predefinemessage").append(result.data);
                }
            }
        });
    }

    function premessage(premessage) {
        document.getElementById("remarks").value = premessage;
    }

    $('.application-status-form').submit(function(){
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var data = new FormData(this);
            $.ajax({
                url: $(this).attr("action"),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function (result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        let applicationId = result.data;
                        let url = '{{ route("manage.selfapply.loan.application.details", ["applicationId" => ":applicationId"]) }}';
                        url = url.replace(':applicationId', applicationId);
                        setTimeout(function(){
                            window.location.href = url;
                        },2000)
                    } else {
                        toastr.error(result.message);
                    }
                },
                error: function (error) {
                    $(this).attr("disabled", false);
                    let errors = error.responseJSON.errors, errorsHtml = '';
                    $.each(errors, function (key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                }
            });
        }
    })

    function applicationStatus(statusId, appId){
        swal({
            title: "Are you sure?",
            text: "You want to change the application status.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel","Confirm"],
        }).then((willChange) => {
            if (willChange) {
                $.ajax({
                    url: '{!! route('manage.selfapply.loan.application.details.status')  !!}',
                    type: 'POST',
                    data: JSON.stringify({statusId: statusId, appId: appId}),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.type === 'SUCCESS') {
                            let url = '{{ route("manage.selfapply.loan.application.details", ["applicationId" => ":applicationId"]) }}';
                            url = url.replace(':applicationId', appId);
                            window.location.href = url;
                        } else {
                            toastr.error(result.message);
                        }
                    }
                });
            }
        });
    }
</script>
