@extends('layouts.manage')
@section('title', 'Referral Customers')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush
@push('style-css')
<style>
    #referralcustomer-table_length{ margin-left:20px;}
</style>
@endpush

@section('breadcrumb-title')
<h3>Referral Customers</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
<li class="breadcrumb-item active">Referral Customers</li>
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
@endsection

@push('script-src')
@include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
{{ $dataTable->scripts(attributes:['type' => 'module']) }}
<script>
    $(document).on('init.dt', '#referralcustomer-table', function() {
        let today = new Date();
        let twoDaysBefore = new Date();
        twoDaysBefore.setDate(today.getDate() - 2);

        let formatDate = (date) => date.toISOString().split('T')[0]; // Format YYYY-MM-DD

        let fromDate = sessionStorage.getItem('from_date') || new URLSearchParams(window.location.search).get('from_date') || formatDate(twoDaysBefore);
        let toDate = sessionStorage.getItem('to_date') || new URLSearchParams(window.location.search).get('to_date') || formatDate(today);
        
        // Set date input fields
        $('#fromdate').val(fromDate);
        $('#todate').val(toDate);
        
        let table = $("#referralcustomer-table").DataTable(); // Get existing DataTable instance

        table.on('preXhr.dt', function(e, settings, data) {
            data.start_date = $("#fromdate").val();
            data.end_date = $("#todate").val();
        });

        // Reload only if session storage had data
        if (sessionStorage.getItem('from_date') || sessionStorage.getItem('to_date') || sessionStorage.getItem('product')) {
            setTimeout(() => {
                table.ajax.reload(null, false);
            }, 500); // Delay reload slightly after full page load
        }

        // Remove session storage after setting values
        sessionStorage.removeItem('from_date');
        sessionStorage.removeItem('to_date');
        
        // Click event for manually refreshing the table
        $('#dateBtn').on('click', function() {
            table.ajax.reload(null, false);
            return false;
        });
    });
</script>
@endpush