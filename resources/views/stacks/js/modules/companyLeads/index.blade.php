<script type="text/javascript">
    let today = new Date();
    let twoDaysBefore = new Date();
    twoDaysBefore.setDate(today.getDate() - 2);
    
    let formatDate = (date) => date.toISOString().split('T')[0]; // Format YYYY-MM-DD

    let fromDate = sessionStorage.getItem('from_date') || new URLSearchParams(window.location.search).get('from_date') || formatDate(twoDaysBefore);
    let toDate = sessionStorage.getItem('to_date') || new URLSearchParams(window.location.search).get('to_date') || formatDate(today);
    let loantype =  sessionStorage.getItem('loantype') ?? new URLSearchParams(window.location.search).get('loantype') ?? '0';
    
    $('#fromDate').val(fromDate);
    $('#toDate').val(toDate);
    $('#loantype').val(loantype);

    sessionStorage.removeItem('from_date');
    sessionStorage.removeItem('to_date');
    sessionStorage.removeItem('loantype');
    
    $(function () {
        var table = $('.company-leads-table').DataTable({
            responsive:true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('manage.selfapply.company.leads') }}",
                data: function (d) {
                    d.fromDate = $('#fromDate').val();
                    d.toDate = $('#toDate').val();
                    d.loantype = $('#loantype').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id', title: '#'},
                {data: 'date', name: 'date'},
                {data: 'fullname', name: 'fullname'},
                {data: 'mobile', name: 'mobile'},
                {data: 'email', name: 'email'},
                {data: 'city', name: 'city'},
                {data: 'state', name: 'State'},
                {data: 'loan_type', name: 'loan_type'},
                {data: 'loan_amount', name: 'loan_amount'},
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

    function openInfoModal(infoId){
        $.ajax({
            url: "{!! route('manage.selfapply.company.leads.info') !!}",
            type: 'POST',
            data:  JSON.stringify({infoId: infoId}),
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.showInfoModals').html(result);
                $('#infoModals').modal('show');
            }
        });
    }

    $(document).ready(function(){
        if(sessionStorage.getItem('infoId')!==null){
            openInfoModal(sessionStorage.getItem('infoId'));
            sessionStorage.removeItem('infoId');
        }
    })
</script>
