<script>
    function openAddModal(){
        $.ajax({
            url: "{!! route('manage.staff.tasks.create') !!}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.addStaffTasksModals').html(result);
                $('#addStaffTasks').modal('show');
            }
        });
    }

    function statusChange(id, status){
        $.ajax({
            url: '{!! route('manage.staff.tasks.statuschange') !!}',
            method: 'POST',
            data:  JSON.stringify({id: id,status: status}),
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                if (result.type === 'SUCCESS') {
                    toastr.success(result.message);
                    $('#inhouse-table').DataTable().ajax.reload();
                }
            }
        })
    }

    function details(id){
        alert(id);
    }
</script>
