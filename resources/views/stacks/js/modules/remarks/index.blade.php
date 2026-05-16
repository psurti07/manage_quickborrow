<script>
    function openAddModal(){
        $.ajax({
            url: "{!! route('manage.remarks.create') !!}",
            type: 'GET',
            contentType: "application/json",
            beforeSend: function(){
                $('#add-remarks-btn').html('<span class="spinner-border spinner-border-sm"></span> Add Remarks');
                $('#add-remarks-btn').attr('disabled', true);
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.addRemarksModals').html(result);
                $('#addRemarks').modal('show');
                $('#add-remarks-btn').html('<i class="fa fa-plus-square"></i>&nbsp;Add Remarks');
                $('#add-remarks-btn').attr('disabled', false);
            }
        });
    }

    function destroy(remarks_id){
        swal({
            title: "Are you sure?",
            text: "You want to delete this remark.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel","Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                var pic = $(this).data('photo')
                $.ajax({
                    url: '{!! route('manage.remarks.delete')  !!}',
                    type: 'POST',
                    data:  JSON.stringify({id: remarks_id}),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            $('#remarks-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        });
    }

    function openEditModal(bank_id) {
        $.ajax({
            url: "remarks-edit/" + bank_id,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addRemarksModals').html(result);
                $('#editRemarks').modal('show');
            }
        });
    }
</script>
