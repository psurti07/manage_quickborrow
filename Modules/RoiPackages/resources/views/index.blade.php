@extends('layouts.manage')
@section('title', 'ROI Packages')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
    <style>
        .swal-title{font-size:20px}
    </style>
@endpush

@section('breadcrumb-title')
    <h3>ROI Packages</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">ROI Packages</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12 text-end">
                <a href="javascript:;" onclick="openAddModal()" class="btn btn-outline-secondary"><i class="fa fa-plus-square"></i>&nbsp;Add ROI Packages</a>
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
    <div class="addROIModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
    @include('stacks.js.modules.roi.index')
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
