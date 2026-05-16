<script>
    function openAddModal(){
        $.ajax({
            url: "{!! route('manage.banks.create') !!}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.addBanksModals').html(result);
                $('#addBanks').modal('show');
            }
        });
    }

    function changeStatus(bank_id, status){
        $.ajax({
            url: '{!! route('manage.banks.statuschange') !!}',
            method: 'POST',
            data:  JSON.stringify({id: bank_id,status: status}),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                if (result.type === 'SUCCESS') {
                    toastr.success(result.message);
                    $('#banks-table').DataTable().ajax.reload();
                }
            }
        })
    }

    function destroy(bank_id){
        swal({
            title: "Are you sure?",
            text: "You want to delete this bank.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel","Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                var pic = $(this).data('photo')
                $.ajax({
                    url: '{!! route('manage.banks.delete')  !!}',
                    type: 'POST',
                    data:  JSON.stringify({id: bank_id,bank_image: pic}),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            $('#banks-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        });
    }

    function openEditModal(bank_id) {
        $.ajax({
            url: "banks-edit/" + bank_id,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addBanksModals').html(result);
                $('#editBanks').modal('show');
            }
        });
    }
</script>
