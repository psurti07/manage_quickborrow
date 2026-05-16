<script>
    function openCustomerDetails(userId){
        $.ajax({
            url: "{!! route('manage.selfapply.customer.details') !!}",
            method: 'POST',
            data:  JSON.stringify({userid: userId}),
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.userDetailsModals').html(result);
                $('#userDetails').modal('show');
            }
        });
    }
</script>
