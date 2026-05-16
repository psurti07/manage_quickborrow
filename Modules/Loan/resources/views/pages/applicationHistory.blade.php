@extends('layouts.manage')
@section('title', 'Loan Applications')

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
<h3>Loan Application List {!! getStatus($status)['data'] !!}</h3>
@endsection
@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
<li class="breadcrumb-item active">{!! getStatus($status)['txt'] !!}</li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row g-3">
        <div class="col-12 text-end d-inline align-content-end">
            <div class="row g-3">
                <input type="hidden" name="acc_type" id="acc_type" value="{{ Str::of(Route::currentRouteName())->explode('.')[1] }}">
                <div class="col-md-2 position-relative text-start">
                    <label class="form-label" for="fromDate">From Date</label>
                    <input class="form-control" id="fromDate" type="date" name="fromDate" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d',strtotime('-2 days')) }}">
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
                        <table class="table table-bordered loan-application-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Loan Type</th>
                                    <th>Loan Amount</th>
                                    <th>Customer</th>
                                    <th>Mobile</th>
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
@endsection

@push('script-src')
@include('stacks.js.manage.datatables')
@include('stacks.js.modules.loan.index')
@endpush
@push('script-tag')
@endpush