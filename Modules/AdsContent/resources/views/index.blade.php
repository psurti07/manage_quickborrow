@extends('layouts.manage')
@section('title', 'Advertisement')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
    <style>
        #cke_jobdesc {
            border: 1px solid #e9e9ec !important;
        }
    </style>
@endpush

@section('breadcrumb-title')
    <h3>Advertisement</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Advertisements</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12 text-end">
                <a href="javascript:;" onclick="openAddModal()" class="btn btn-outline-secondary"><i class="fa fa-plus-square"></i>&nbsp;Add Ads Content</a>
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
    <div class="addAdsModals"></div>
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
                url: "{!! route('manage.advertisement.create',['type'=>$type]) !!}",
                type: 'GET',
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    $('.addAdsModals').html(result);
                    $('#addAds').modal('show');
                }
            });
        }

        function destroy(career_id){
            swal({
                title: "Are you sure?",
                text: "You want to delete this ad content.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: ["Cancel","Confirm"],
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '{!! route('manage.advertisement.delete')  !!}',
                        type: 'POST',
                        data:  JSON.stringify({id: career_id}),
                        contentType: "application/json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            if (result.type === 'SUCCESS') {
                                toastr.success(result.message);
                                $('#advertisements-table').DataTable().ajax.reload();
                            }
                        }
                    });
                }
            });
        }
    </script>

@endpush
