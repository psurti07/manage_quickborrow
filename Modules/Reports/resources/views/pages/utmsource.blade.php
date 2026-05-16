@extends('layouts.manage')
@section('title', 'UTM Source')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
    <style>
        .swal-title{font-size:20px}
    </style>
@endpush

@section('breadcrumb-title')
    <h3>UTM Source Report</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">UTM Source Report</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-2 position-relative">
                <label class="form-label">From Date</label>
                <input class="form-control" type="date" name="fromdate" id="fromdate" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-2 position-relative">
                <label class="form-label">To Date</label>
                <input class="form-control" type="date" name="todate" id="todate" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-2 position-relative">
                <label class="form-label">Source</label>
                <select class="form-select" name="source" id="source">
                    <option value="">All</option>
                    <option value="google">Google</option>
                    <option value="taboola">Taboola</option>
                    <option value="meta">Facebook</option>
                    <option value="web">Web</option>
                </select>
            </div>
            <div class="col-md-2 position-relative">
                <button type="button" class="mt-4 btn btn-outline-primary" id="filterBtn">Show</button>
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
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        const table = $("#utmsource-table");
        table.on('preXhr.dt',function(e, settings, data){
            data.start_date = $("#fromdate").val();
            data.end_date = $("#todate").val();
            data.utmsource = $("#source").val();
        });
        $('#filterBtn').on('click',function () {
            table.DataTable().ajax.reload();
            return false;
        })
    </script>
@endpush
