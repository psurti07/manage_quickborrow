<script>
    function openAddModal(){
        $.ajax({
            url: "{!! route('manage.channelpartner.create') !!}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.addChannelPartnerModals').html(result);
                $('#addChannelPartner').modal('show');
            }
        });
    }
</script>
