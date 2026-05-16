<script>
    function openAddModal(){
        $.ajax({
            url: "{!! route('manage.roipackages.create') !!}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.addROIModals').html(result);
                $('#addROI').modal('show');
            }
        });
    }

    function destroy(ROIid){
        swal({
            title: "Are you sure?",
            text: "You want to delete this ROI.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel","Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: '{!! route('manage.roipackages.destroy')  !!}',
                    type: 'POST',
                    data:  JSON.stringify({id: ROIid}),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            $('#roipackages-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        });
    }

    function openEditModal(ROIid){
        $.ajax({
            url: "roipackages-edit/" + ROIid,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addROIModals').html(result);
                $('#editROI').modal('show');
            }
        });
    }
</script>
