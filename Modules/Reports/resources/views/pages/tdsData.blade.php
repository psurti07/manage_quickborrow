@extends('layouts.manage')
@section('title', 'TDS Report')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
<style>
    #DataTables_Table_0_length{
        margin-left:50px;
    }
</style>
@endpush

@section('breadcrumb-title')
    <h3>TDS Data</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">TDS Data</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12 text-end d-inline align-content-end">
                <div class="row g-3">
                    <div class="col-md-2 position-relative text-start">
                        <label class="form-label" for="fromDate">From Date</label>
                        <input class="form-control" id="fromDate" type="date" name="fromDate" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d',strtotime('-1 days')) }}">
                    </div>
                    <div class="col-md-2 position-relative text-start">
                        <label class="form-label" for="toDate">To Date</label>
                        <input class="form-control" id="toDate" type="date" name="toDate" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-2 position-relative text-start">
                        <button type="button" class="mt-4 btn btn-outline-primary" id="filterBtn">Show</button>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered tds-data-table" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Fullname</th>
                                    <th>Mobile</th>
                                    <th>Email Id</th>
                                    <th>Order Amount</th>
                                    <th>Pay Amount</th>
                                    <th>Payout Date</th>
                                    <th>GST No</th>
                                    <th>PAN no</th>
                                    <th>Aadhaar Card no</th>
                                    <th>City</th>
                                    <th>State</th>
                                </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total Amount:</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
    @include('stacks.js.modules.reports.tds')
@endpush
@push('script-tag')
@endpush
