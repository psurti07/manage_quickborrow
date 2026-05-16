<script type="text/javascript">

    $(function(){
        var table = $('.tds-data-table').DataTable({
            responsive:true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('manage.reports.tds.data') }}",
                data: function (d) {
                    d.fromDate = $('#fromDate').val();
                    d.toDate = $('#toDate').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id', title: '#'},
                {data: 'fullname', name: 'fullname'},
                {data: 'mobile', name: 'mobile'},
                {data: 'email', name: 'email'},
                {data: 'order_amount', name: 'order_amount'},
                {data: 'payout_amount', name: 'payout_amount'},
                {data: 'payout_date', name: 'payout_date'},
                {data: 'gstno', name: 'gstno'},
                {data: 'panno', name: 'panno'},
                {data: 'aadharno', name: 'aadharno'},
                {data: 'city', name: 'city'},
                {data: 'state', name: 'state'},
            ],
            order: [[0, 'desc']],
            dom: 'Blfrtip',
            buttons: [ 'excel', 'csv', 'pdf', 'print' ],
            lengthMenu: [[100, 250, 500, 1000, -1], [100, 250, 500, 1000, "All"]],
            pageLength: 100,
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();
                // Calculate the sum of order_amount column
                var orderAmountTotal = api.column(4, {page: 'current'}).data().reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);
                // Calculate the sum of payout_amount column
                var payoutAmountTotal = api.column(5, {page: 'current'}).data().reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);

                // Update the footer
                $(api.column(4).footer()).html(orderAmountTotal.toFixed(2));
                $(api.column(5).footer()).html(payoutAmountTotal.toFixed(2));
            }
        });
        $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });
    });
</script>
