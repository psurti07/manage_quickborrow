@extends('layouts.manage')
@section('title', config('remarks.name'))

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
    <style>
        .swal-title{font-size:20px}
    </style>
@endpush

@section('breadcrumb-title')
    <h3>{!! config('remarks.name') !!}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">{!! config('remarks.name') !!}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-6 col-lg-6 col-sm-6 text-start">
                <div class="row">
                    <div class="col-md-4 col-sm-6 position-relative">
                        <label class="form-label">Product:</label>
                        <select class="form-select" name="parentid" id="parentid">
                            <option value="" selected>All</option>
                            <option value="self-apply">Self Apply</option>
                            <option value="hire-agent">Loan Agent</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-6 position-relative">
                        <button type="button" class="mt-4 btn btn-outline-primary" id="dateBtn">Show</button>
                    </div>    
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-6 text-end">
                <div class="col-md-12 position-relative">
                    <a href="javascript:;" onclick="openAddModal()" class="btn btn-outline-secondary mt-4" id="add-remarks-btn"><i class="fa fa-plus-square"></i>&nbsp;Add Remarks</a>
                </div>
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
    <div class="addRemarksModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
    @include('stacks.js.modules.remarks.index')
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        const table = $("#remarks-table");
        table.on('preXhr.dt',function(e, settings, data){
            data.products = $("#parentid").val();
        });
        $('#dateBtn').on('click',function () {
            table.DataTable().ajax.reload();
            return false;
        })
    </script>
@endpush
