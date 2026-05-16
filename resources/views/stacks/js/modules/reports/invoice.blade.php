<script type="text/javascript">
    let today = new Date();
    let oneDaysBefore = new Date();
    oneDaysBefore.setDate(today.getDate() - 1);
    
    let formatDate = (date) => date.toISOString().split('T')[0]; // Format YYYY-MM-DD

    let fromDate = sessionStorage.getItem('from_date') || new URLSearchParams(window.location.search).get('from_date') || formatDate(oneDaysBefore);
    let toDate = sessionStorage.getItem('to_date') || new URLSearchParams(window.location.search).get('to_date') || formatDate(today);
    
    $('#fromDate').val(fromDate);
    $('#toDate').val(toDate);
    
    sessionStorage.removeItem('from_date');
    sessionStorage.removeItem('to_date');
    
    
    $(function() {
        var table = $('.get-data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('manage.reports.invoice') }}",
                data: function(d) {
                    d.fromDate = $('#fromDate').val();
                    d.toDate = $('#toDate').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id',
                    title: 'Id'
                },
                {
                    data: 'invDate',
                    name: 'invDate'
                },
                {
                    data: 'invNo',
                    name: 'invNo'
                },
                {
                    data: 'plan',
                    name: 'plan'
                },
                {
                    data: 'fullname',
                    name: 'fullname'
                },
                {
                    data: 'mobile',
                    name: 'mobile',
                    searchable: true
                },
                {
                    data: 'city',
                    name: 'city',
                    searchable: true
                },
                {
                    data: 'state',
                    name: 'state',
                    searchable: true
                },
                {
                    data: 'totalAmount',
                    name: 'totalAmount'
                },
                {
                    data: 'action',
                    name: 'action',
                    title: 'Action',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [0, 'desc']
            ],
            dom: 'Blfrtip',
            buttons: ['excel', 'csv', 'pdf', 'print'],
            lengthMenu: [[100, 250, 500, 1000, -1], [100, 250, 500, 1000, "All"]],
            pageLength: 100,
        });
        $('#filterBtn').on('click', function() {
            console.log('From:', $('#fromDate').val(), 'To:', $('#toDate').val());
            table.ajax.reload(null, true);
        });
    });
    
    /* refund script */
    
    function openRefundModal(invId, invNo){
        $.ajax({
            url: "refund-process/" + invId + '/' + invNo,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.refundSection').html(result);
                $('#refundModal').modal('show');
            }
        });
    }
</script>