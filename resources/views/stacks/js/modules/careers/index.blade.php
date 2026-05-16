<script>
    function openAddModal(){
        $.ajax({
            url: "{!! route('manage.career.create') !!}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.addCareersModals').html(result);
                $('#addCareers').modal('show');
            }
        });
    }

   function changeStatus(career_id, status){
        $.ajax({
            url: '{!! route('manage.careers.statuschange') !!}',
            method: 'POST',
            data:  JSON.stringify({id: career_id,status: status}),
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                if (result.type === 'SUCCESS') {
                    toastr.success(result.message);
                    $('#careers-table').DataTable().ajax.reload();
                }
            }
        })
    }

    function destroy(career_id){
       swal({
           title: "Are you sure?",
           text: "You want to delete this openings.",
           icon: "warning",
           buttons: true,
           dangerMode: true,
           buttons: ["Cancel","Confirm"],
       }).then((willDelete) => {
           if (willDelete) {
               $.ajax({
                   url: '{!! route('manage.careers.delete')  !!}',
                   type: 'POST',
                   data:  JSON.stringify({id: career_id}),
                   contentType: "application/json",
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                   success: function (result) {
                       if (result.type === 'SUCCESS') {
                           toastr.success(result.message);
                           $('#careers-table').DataTable().ajax.reload();
                       }
                   }
               });
           }
       });
   }

   function openEditModal(career_id) {
       $.ajax({
           url: "careers-edit/" + career_id,
           type: 'GET',
           contentType: "application/json",
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           success: function(result) {
               $('.addCareersModals').html(result);
               $('#editCareers').modal('show');
           }
       });
   }
</script>
