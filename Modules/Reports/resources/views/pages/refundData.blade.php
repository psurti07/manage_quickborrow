@extends('layouts.manage')
@section('title', 'Refund Data Report')

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
    <h3>Refund Data</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Refund Data</li>
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
                            <table class="table table-bordered refund-data-table" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Refund Date</th>
                                    <th>Refund #</th>
                                    <th>Net Amount</th>
                                    <th>CGST</th>
                                    <th>SGST</th>
                                    <th>IGST</th>
                                    <th>Total Amount</th>
                                    <th>Product</th>
                                    <th>Fullname</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>GST No</th>
                                    <th>Payment Id</th>
                                    <th>City</th>
                                    <th>State</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th colspan="3">Total Amount:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
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
    @include('stacks.js.modules.reports.refunds')
@endpush
@push('script-tag')
@endpush
