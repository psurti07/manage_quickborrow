<script type="text/javascript">
    $(function () {
        const currentUrl = window.location.href;
        const parts = currentUrl.split('/');
        const number = parts[parts.length - 1];
        var accType = $('#acc_type').val() === 'loanagent' ? 2 : 1;
        let url = '{{ route('manage.selfapply.loan.application.lists',['status'=>":status"]) }}';
        url = url.replace(':status', number);
        var table = $('.loan-application-table').DataTable({
            responsive:true,
            processing: true,
            serverSide: true,
            ajax: {
                url: url,
                data: function (d) {
                    d.fromDate = $('#fromDate').val();
                    d.toDate = $('#toDate').val(); 
                    d.accType = accType; 
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id', title: '#'},
                {data: 'date', name: 'date'},
                {data: 'loantype', name: 'loantype'},
                {data: 'loan_amount', name: 'loan_amount'},
                {data: 'fullname', name: 'fullname'},
                {data: 'mobile', name: 'mobile'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[0, 'desc']],
            dom: 'Blfrtip',
            buttons: [ 'excel', 'csv', 'pdf', 'print' ],
            lengthMenu: [[100, 250, 500, 1000, -1], [100, 250, 500, 1000, "All"]],
            pageLength: 100,
        });
        $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });
    });
</script>
