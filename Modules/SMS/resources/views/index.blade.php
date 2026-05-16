@extends('layouts.manage')
@section('title', 'Sms Templates')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
<style>
    #smstemplate-table_length{ margin-left: 50px; }
</style>
@endpush

@section('breadcrumb-title')
    <h3>SMS Template Lists</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">SMS Template Lists</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
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
@endpush
