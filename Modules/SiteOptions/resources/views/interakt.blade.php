@extends('layouts.manage')
@section('title', 'Interakt Settings')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')

@endpush

@section('breadcrumb-title')
    <h3>Interakt Settings</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Interakt Settings</li>
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
    <div class="interaktModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        function openinteraktSettingsModal(id){
            $.ajax({
            url: `https://manage.quikborrow.com/interakt-settings/edit/${id}`,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.interaktModals').html(result);
                $('#interaktModal').modal('show');
            }
        });
        }
    </script>
@endpush
