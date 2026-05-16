<script>
    function showDetailsModal(id){
        var baseUrl = "{{ route('manage.channelpartner.leads.details', ['id' => '__id__']) }}";
        let url = baseUrl.replace('__id__', id);

        $.ajax({
            url:  `${url}`,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.showChannelPartnerLeadsModals').html(result);
                $('#leadDetails').modal('show');
            }
        });
    }
</script>
