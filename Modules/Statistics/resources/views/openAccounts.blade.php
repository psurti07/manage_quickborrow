@extends('layouts.manage')
@section('title', 'Opend Accounts')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush
@push('style-css')
<style>
    #openaccounts-table_length{
        margin-left:50px;
    }
</style>
@endpush

@section('breadcrumb-title')
<h3>Opened Account Customers - {{ ucwords(str_ireplace('-',' ', $type)) }}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
<li class="breadcrumb-item active">Opened Accouts</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3">
        <div class="col-md-2 position-relative">
            <label class="form-label">Days</label>
            <select class="form-select" name="days" id="days">
                <option value="" selected>Select Days</option>
                @if($type == 'self-apply')
                <option value="7">7 Days Above</option>
                @endif
                <option value="21">21 Days Above</option>
                <option value="41">41 Days Above</option>
                <option value="61">61 Days Above</option>
                <option value="91">91 Days Above</option>
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
@endsection

@push('script-src')
@include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
{{ $dataTable->scripts(attributes:['type' => 'module']) }}
<script>
    const table = $("#openaccounts-table");
        table.on('preXhr.dt',function(e, settings, data){
            data.days = $("#days").val();
        });
        $('#dateBtn').on('click',function () {
            table.DataTable().ajax.reload();
            return false;
        })
</script>
@endpush