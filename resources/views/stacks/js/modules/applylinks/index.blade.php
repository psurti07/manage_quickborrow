<script>
    function openAddModal(){
        $.ajax({
            url: "{!! route('manage.apply.links.create') !!}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.addLinksModals').html(result);
                $('#addLinks').modal('show');
            }
        });
    }

    function destroy(linksId){
        swal({
            title: "Are you sure?",
            text: "You want to delete this link.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel","Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: '{!! route('manage.apply.links.destroy')  !!}',
                    type: 'POST',
                    data:  JSON.stringify({id: linksId}),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            $('#applylinks-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        });
    }

    function openEditModal(ROIid){
        $.ajax({
            url: "apply-links-edit/" + ROIid,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addLinksModals').html(result);
                $('#editLinks').modal('show');
            }
        });
    }
</script>
