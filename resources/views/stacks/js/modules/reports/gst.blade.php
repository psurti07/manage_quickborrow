<script type="text/javascript">
    $(function(){
        var table = $('.get-data-table').DataTable({
            responsive:true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('manage.reports.gst.data') }}",
                data: function (d) {
                    d.fromDate = $('#fromDate').val();
                    d.toDate = $('#toDate').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id', title: '#'},
                {data: 'inv_date', name: 'inv_date'},
                {data: 'inv_no', name: 'inv_no'},
                {data: 'inv_price', name: 'inv_price'},
                {data: 'inv_cgst', name: 'inv_cgst'},
                {data: 'inv_sgst', name: 'inv_sgst'},
                {data: 'inv_igst', name: 'inv_igst'},
                {data: 'inv_grandtotal', name: 'inv_grandtotal'},
                {data: 'fullname', name: 'fullname'},
                {data: 'mobile', name: 'mobile'},
                {data: 'email', name: 'email'},
                {data: 'city', name: 'city'},
                {data: 'state', name: 'state'},
                {data: 'company_name', name: 'company_name'},
                {data: 'company_gst', name: 'company_gst'},
                {data: 'paymentid', name: 'paymentid'},
            ],
            order: [[0, 'desc']],
            dom: 'Blfrtip',
            lengthMenu: [[100, 250, 500, 1000, -1], [100, 250, 500, 1000, "All"]],
            buttons: [ 'excel', 'csv', 'pdf', 'print' ],
            pageLength: 100,
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();
                // Calculate the sum of ref_price column
                var priceTotal = api.column(3, {page: 'current'}).data().reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);
                // Calculate the sum of ref_cgst column
                var cgstTotal = api.column(4, {page: 'current'}).data().reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);
                // Calculate the sum of ref_sgst column
                var sgstTotal = api.column(5, {page: 'current'}).data().reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);
                // Calculate the sum of ref_igst column
                var igstTotal = api.column(6, {page: 'current'}).data().reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);
                // Calculate the sum of ref_grandtotal column
                var grandTotal = api.column(7, {page: 'current'}).data().reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);


                // Update the footer
                $(api.column(3).footer()).html(priceTotal.toFixed(2));
                $(api.column(4).footer()).html(cgstTotal.toFixed(2));
                $(api.column(5).footer()).html(sgstTotal.toFixed(2));
                $(api.column(6).footer()).html(igstTotal.toFixed(2));
                $(api.column(7).footer()).html(grandTotal.toFixed(2));
            }
        });
        $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });
    });
</script>
