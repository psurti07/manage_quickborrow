@extends('layouts.manage')
@section('title', 'Payment Log')

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
<h3 id="breadcrumb-items">{{ str_replace('-',' ',$routeTable) }}</h3>
@endsection


@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
<li class="breadcrumb-item active" id="breadcrumb-title">{{ str_replace('-',' ',$routeTable) }}</li>
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
                <input type="hidden" value="0" name="entryfor" id="entryfor">
                <div class="col-md-2 position-relative text-start">
                    <label class="form-label" for="status">&nbsp;</label>
                    <select class="form-select" name="status" id="status">
                        <option value="0" selected>All</option>
                        <option value="1">Paid</option>
                        <option value="2">UnPaid</option>
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
                        <table class="table table-bordered get-data-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Entry For</th>
                                    <th>Full Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Order Id</th>
                                    <th>Txn Id</th>
                                    <th>Order Amount</th>
                                    <th>Order Note</th>
                                    <th>Status</th>
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
@include('stacks.js.modules.payments.payment')
@endpush
@push('script-tag')
<script>
    var currentRouteName = '{{ Route::currentRouteName() }}';
</script>
@endpush