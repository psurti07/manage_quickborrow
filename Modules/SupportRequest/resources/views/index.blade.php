@extends('layouts.manage')
@section('title', 'Support Request')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
    <style>
        .swal-title{font-size:20px}
        #supportrequest-table_length{ margin-left:50px; }
    </style>
@endpush

@section('breadcrumb-title')
    <h3>Support Request</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Support Request</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-2 position-relative">
                <label class="form-label">From Date</label>
                <input class="form-control" type="date" name="fromdate" id="fromdate" value="{{ date('Y-m-d',strtotime('-2 days')) }}">
            </div>
            <div class="col-md-2 position-relative">
                <label class="form-label">To Date</label>
                <input class="form-control" type="date" name="todate" id="todate" value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-2 position-relative">
                <label class="form-label">User Type</label>
                <select class="form-select" name="usertype" id="usertype">
                    <option value="">All</option>
                    <option value="2">Guest User</option>
                    <option value="1">Self Apply User</option>
                    <option value="3">Loan Agent User</option>
                </select>
            </div>
            <div class="col-md-2 position-relative">
                <label class="form-label">Issue Type</label>
                <select class="form-select" name="issueType" id="issueType">
                    <option value="">All</option>
                    <option value="Service Problem">Service Problem</option>
                    <option value="Payment Issue">Payment Issue</option>
                    <option value="Technical Problem">Technical Problem</option>
                    <option value="Eligibility or Pre-approval Query">Eligibility or Pre-approval Query</option>
                    <option value="GST Return Query">GST Return Query</option>
                    <option value="Double Payment">Double Payment</option>
                    <option value="Refund Request">Refund Request</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="col-md-2 position-relative">
                <button type="button" class="mt-4 btn btn-outline-primary" id="dateBtn">Show</button>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="supportModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
    @include('stacks.js.modules.support.index')
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        const table = $("#supportrequest-table");
        table.on('preXhr.dt',function(e, settings, data){
            data.start_date = $("#fromdate").val();
            data.end_date = $("#todate").val();
            data.usertype = $("#usertype").val();
            data.issueType = $("#issueType").val();
        });
        $('#dateBtn').on('click',function () {
            table.DataTable().ajax.reload();
            return false;
        })
    </script>
@endpush
