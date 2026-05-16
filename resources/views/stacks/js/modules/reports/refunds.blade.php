<script type="text/javascript">

    $(function(){
        var table = $('.refund-data-table').DataTable({
            responsive:true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('manage.reports.refund.data') }}",
                data: function (d) {
                    d.fromDate = $('#fromDate').val();
                    d.toDate = $('#toDate').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id', title: '#'},
                {data: 'ref_date', name: 'ref_date'},
                {data: 'ref_number', name: 'ref_number'},
                {data: 'ref_price', name: 'ref_price'},
                {data: 'ref_cgst', name: 'ref_cgst'},
                {data: 'ref_sgst', name: 'ref_sgst'},
                {data: 'ref_igst', name: 'ref_igst'},
                {data: 'ref_grandtotal', name: 'ref_grandtotal'},
                {data: 'product', name: 'product'},
                {data: 'fullname', name: 'fullname'},
                {data: 'mobile', name: 'mobile'},
                {data: 'email', name: 'email'},
                {data: 'gstno', name: 'gstno'},
                {data: 'paymentid', name: 'paymentid'},
                {data: 'city', name: 'city'},
                {data: 'state', name: 'state'},
            ],
            order: [[0, 'desc']],
            dom: 'Blfrtip',
            lengthMenu: [[100, 250, 500, 1000, -1], [100, 250, 500, 1000, "All"]],
            pageLength: 100,
            buttons: [ 'excel', 'csv', 'pdf', 'print' ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();
                // Calculate the sum of ref_price column
                var refundPriceTotal = api.column(3, {page: 'current'}).data().reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);
                // Calculate the sum of ref_cgst column
                var refundCgstTotal = api.column(4, {page: 'current'}).data().reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);
                // Calculate the sum of ref_sgst column
                var refundSgstTotal = api.column(5, {page: 'current'}).data().reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);
                // Calculate the sum of ref_igst column
                var refundIgstTotal = api.column(6, {page: 'current'}).data().reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);
                // Calculate the sum of ref_grandtotal column
                var refundgrandTotal = api.column(7, {page: 'current'}).data().reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);


                // Update the footer
                $(api.column(3).footer()).html(refundPriceTotal.toFixed(2));
                $(api.column(4).footer()).html(refundCgstTotal.toFixed(2));
                $(api.column(5).footer()).html(refundSgstTotal.toFixed(2));
                $(api.column(6).footer()).html(refundIgstTotal.toFixed(2));
                $(api.column(7).footer()).html(refundgrandTotal.toFixed(2));
            }
        });
        $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });
    });
</script>
