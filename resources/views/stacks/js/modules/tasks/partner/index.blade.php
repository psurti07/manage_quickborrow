<script>
    function openAddModal(){
        $.ajax({
            url: "{!! route('manage.partners.tasks.create') !!}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.addPartnerTasksModals').html(result);
                $('#addPartnerTasks').modal('show');
            }
        });
    }
</script>
