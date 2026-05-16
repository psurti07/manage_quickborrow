@extends('layouts.manage')
@section('title', 'Users')

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
    <h3>Self Apply Users</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12 text-end d-inline align-content-end">
                <div class="row g-3">
                    <div class="col-md-2 position-relative text-start">
                        <label class="form-label" for="fromDate">From Date</label>
                        <input class="form-control" id="fromDate" type="date" name="fromDate" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d',strtotime('-10 days')) }}">
                    </div>
                    <div class="col-md-2 position-relative text-start">
                        <label class="form-label" for="toDate">To Date</label>
                        <input class="form-control" id="toDate" type="date" name="toDate" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-2 position-relative text-start">
                        <label class="form-label" for="loantype">Loan Type</label>
                        <select class="form-control form-select" name="loantype" id="loantype">
                            <option value="0" selected>All</option>
                            <option value="1">Personal Loan</option>
                            <option value="2">Business Loan</option>
                        </select>
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
                            <table class="table table-bordered company-leads-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Date</th>
                                        <th>Full Name</th>
                                        <th>Mobile</th>
                                        <th>Email Id</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Loan Type</th>
                                        <th>Loan Amount (₹)</th>
                                        <th class="text-center">Details</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="showInfoModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
    @include('stacks.js.modules.companyLeads.index')
@endpush
@push('script-tag')
@endpush
