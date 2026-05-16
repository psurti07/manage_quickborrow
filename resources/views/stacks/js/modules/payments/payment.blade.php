<script type="text/javascript">
    var ajaxUrls = {
        'manage.razorpaylog': '{{ route("manage.razorpaylog") }}',
        'manage.paymentlog': '{{ route("manage.paymentlog") }}',
        'manage.subpaisalog': '{{ route("manage.subpaisalog") }}',
        'manage.cipherpaylog': '{{ route("manage.cipherpaylog") }}',
        'manage.vegaahlog': '{{ route("manage.vegaahlog") }}',
        'manage.zwitchlog': '{{ route("manage.zwitchlog") }}',
        'manage.lyralog': '{{ route("manage.lyralog") }}',
        'manage.paygiclog': '{{ route("manage.paygiclog") }}',
        'manage.airpaylog': '{{ route("manage.airpaylog") }}',
        'manage.zaakpaylog': '{{ route("manage.zaakpaylog") }}',
        'manage.cashfreelog': '{{ route("manage.cashfreelog") }}'
    };
    let today = new Date();
    let oneDaysBefore = new Date();
    oneDaysBefore.setDate(today.getDate() - 1);
    
    let formatDate = (date) => date.toISOString().split('T')[0]; // Format YYYY-MM-DD

    let fromDate = sessionStorage.getItem('from_date') || new URLSearchParams(window.location.search).get('from_date') || formatDate(oneDaysBefore);
    let toDate = sessionStorage.getItem('to_date') || new URLSearchParams(window.location.search).get('to_date') || formatDate(today);
    let status = sessionStorage.getItem('status') || new URLSearchParams(window.location.search).get('status') || 0;
    let entryfor = sessionStorage.getItem('entryfor') || new URLSearchParams(window.location.search).get('entryfor') || 0;

    $('#fromDate').val(fromDate);
    $('#toDate').val(toDate);
    $('#status').val(status);
    $('#entryfor').val(entryfor);

    sessionStorage.removeItem('from_date');
    sessionStorage.removeItem('to_date');
    sessionStorage.removeItem('status');
    sessionStorage.removeItem('entryfor');
    $(function() {
        var table = $('.get-data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: ajaxUrls[currentRouteName] || '{{ route("manage.paymentlog") }}',
                data: function(d) {
                    d.fromDate = $('#fromDate').val();
                    d.toDate = $('#toDate').val();
                    d.status = $('#status').val();
                    d.entryfor = $('#entryfor').val();
                }
            },
            columns: [
                // {
                //     data: 'id',
                //     name: 'id',
                //     title: 'Id'
                // },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    title: '#',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'rec_date',
                    name: 'rec_date',
                    title: 'Rec Date',
                    searchable: false,
                },
                {
                    data: 'entryfor',
                    name: 'entryfor',
                    title: 'Entry For'
                },
                {
                    data: 'fullname',
                    name: 'fullname',
                    title: 'Full Name'
                },
                {
                    data: 'mobile',
                    name: 'mobile',
                    title: 'Mobile'
                },
                {
                    data: 'email',
                    name: 'email',
                    title: 'email'
                },
                {
                    data: 'orderid',
                    name: 'orderid',
                    title: 'Order Id'
                },
                {
                    data: 'txnid',
                    name: 'txnid',
                    title: 'Txn Id'
                },
                {
                    data: 'orderamount',
                    name: 'orderamount',
                    title: 'Order Amount'
                },
                {
                    data: 'ordernote',
                    name: 'ordernote',
                    title: 'Order Note'
                },
                {
                    data: 'status',
                    name: 'status',
                    title: 'Status',
                    render: function(data, type, row) {
                        return data ? data : '-';
                    }
                },
            ],
            order: [
                [0, 'desc']
            ],
            dom: 'Blfrtip',
            buttons: ['excel', 'csv', 'pdf', 'print'],
            lengthMenu: [[100, 250, 500, 1000, -1], [100, 250, 500, 1000, "All"]],
            pageLength: 100
        });
        $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });
    });
</script>