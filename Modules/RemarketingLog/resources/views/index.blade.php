@extends('layouts.manage')
@section('title', 'Rematrketing Log')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')

@endpush

@section('breadcrumb-title')
    <h3>Remarketing Log</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Remarketing Log</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-3 position-relative">
                <label class="form-label">SMS:</label>
                <select class="form-select" name="parentid" id="parentid">
                    <option value="" selected>All</option>
                    <option value="11-SMS-Lead">Self Apply Lead SMS</option>
                    <option value="11-SMS-Customer">Self Apply Customer SMS</option>
                    <option value="12-SMS-Lead">Loan Agent Lead SMS</option>
                    <option value="11-SMS-Closed">Self Apply Customer Service Closed SMS</option>
                    <option value="11-Whatsapp-Lead">Self Apply Lead Whatsapp</option>
                    <option value="12-Whatsapp-Lead">Loan Agent Lead Whatsapp</option>
                </select>
            </div>
            <div class="col-md-2 position-relative">
                <label class="form-label">From Date</label>
                <input class="form-control" type="date" name="fromdate" id="fromdate" value="{{ date('Y-m-d',strtotime('-1 days')) }}">
            </div>
            <div class="col-md-2 position-relative">
                <label class="form-label">To Date</label>
                <input class="form-control" type="date" name="todate" id="todate" value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-2 position-relative">
                <button type="button" class="mt-4 btn btn-outline-primary" id="dateBtn">Show</button>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{ $dataTable->table() }}
                        <div class="text-right mt-3">
                            <strong>Total Messages:</strong> <span id="total-msgcount">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="showRemarketingModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        const table = $("#remarketinglog-table");
        table.on('preXhr.dt',function(e, settings, data){
            data.start_date = $("#fromdate").val();
            data.end_date = $("#todate").val();
            data.sms = $("#parentid").val();
        });
        $('#dateBtn').on('click',function () {
            table.DataTable().ajax.reload();
            return false;
        })
        
        // Handle response and show total msgcount
        table.on('xhr.dt', function (e, settings, json, xhr) {
            if (json.totalMsgCount !== undefined) {
                document.getElementById('total-msgcount').textContent = json.totalMsgCount;
            } else {
                document.getElementById('total-msgcount').textContent = '0';
            }
        });
        
        function openRemarketingModal(remarketingId){
            $.ajax({
            url: `https://manage.quikborrow.com/remarketing-log/details/${remarketingId}`,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.showRemarketingModals').html(result);
                $('#remarketingLogDetails').modal('show');
            }
        });
        }
    </script>
@endpush
