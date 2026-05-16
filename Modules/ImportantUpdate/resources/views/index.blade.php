@extends('layouts.manage')
@section('title', 'Important Updates')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
    <style>
        .swal-title{font-size:20px}
        #cke_descriptions{
            border:1px solid #e9e9ec!important;
        }
    </style>
@endpush

@section('breadcrumb-title')
    <h3> Site Important Updates</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Important Updates</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12 text-end">
                <a href="javascript:;" onclick="openAddModal()" class="btn btn-outline-secondary" id="add-updates-btn"><i class="fa fa-plus-square"></i>&nbsp;Add Updates</a>
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
    <div class="addImpUpdModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
    <script src="{{asset('assets/js/editor/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('assets/js/editor/ckeditor/adapters/jquery.js')}}"></script>
    <script src="{{asset('assets/js/editor/ckeditor/styles.js')}}"></script>
    <script src="{{asset('assets/js/editor/ckeditor/ckeditor.custom.js')}}"></script>
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        function openAddModal(){
            $.ajax({
                url: "{!! route('manage.important.update.create') !!}",
                type: 'GET',
                contentType: "application/json",
                beforeSend: function(){
                    $('#add-updates-btn').html('<span class="spinner-border spinner-border-sm"></span> Add Updates');
                    $('#add-updates-btn').attr('disabled', true);
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    $('.addImpUpdModals').html(result);
                    $('#addUpdates').modal('show');
                    $('#add-updates-btn').html('<i class="fa fa-plus-square"></i>&nbsp;Add Remarks');
                    $('#add-updates-btn').attr('disabled', false);
                }
            });
        }

        function destroy(updates_id){
            swal({
                title: "Are you sure?",
                text: "You want to delete this updates.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: ["Cancel","Confirm"],
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '{!! route('manage.important.update.delete')  !!}',
                        type: 'POST',
                        data:  JSON.stringify({id: updates_id}),
                        contentType: "application/json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            if (result.type === 'SUCCESS') {
                                toastr.success(result.message);
                                $('#importantupdate-table').DataTable().ajax.reload();
                            }
                        }
                    });
                }
            });
        }

        function openEditModal(updates_id) {
            $.ajax({
                url: "important-update-edit/" + updates_id,
                type: 'GET',
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    $('.addImpUpdModals').html(result);
                    $('#editUpdates').modal('show');
                }
            });
        }

        function changeStatus(iu_id,status){
            $.ajax({
                url: '{!! route('manage.important.update.statuschange') !!}',
                method: 'POST',
                data:  JSON.stringify({id: iu_id,status: status}),
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);

                        $('#importantupdate-table').DataTable().ajax.reload();
                    }
                }
            })
        }
    </script>

@endpush
