<script>

    function openAddModal(){
        $.ajax({
            url: "{!! route('manage.staff.account.create') !!}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend:function(){
                $('#addStaffBtn').html('<span class="spinner-border spinner-border-sm"></span> Add Accounts');
                $('#addStaffBtn').attr('disabled', true);
            },
            success: function (result) {
                $('.addAccountsModals').html(result);
                $('#addAccounts').modal('show');
                $('#addStaffBtn').html('<i class="fa fa-plus-square"></i>&nbsp;Add Accounts');
                $('#addStaffBtn').attr('disabled', false);
            }
        });
    }

    function changeStatus(staffID,status){
        $.ajax({
            url: '{!! route('manage.staff.account.statuschange') !!}',
            method: 'POST',
            data:  JSON.stringify({id: staffID,status: status}),
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                if (result.type === 'SUCCESS') {
                    toastr.success(result.message);
                    
                    $('#staffaccount-table').DataTable().ajax.reload();
                }
            }
        })
    }

</script>
