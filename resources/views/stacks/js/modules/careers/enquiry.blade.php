<script>
    function destroy(enquiry_id){
        swal({
            title: "Are you sure?",
            text: "You want to delete this enquiry.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel","Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: '{!! route('manage.careers.enquiry.delete')  !!}',
                    type: 'POST',
                    data:  JSON.stringify({id: enquiry_id}),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            $('#careerenquiry-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        });
    }
</script>
