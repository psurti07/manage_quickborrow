@extends('layouts.manage')
@section('title', 'Refund Policy')

@push('css-links')
@endpush
@push('style-css')
    <style>
        #cke_editor1{
            border:1px solid #e9e9ec!important;
        }
        #cke_1_contents{
            height:550px!important;
        }
    </style>
@endpush

@section('breadcrumb-title')
    <h3>Refund Policy</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Refund Policy</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12">
                <form method="post" class="needs-validation refund-policy-form" novalidate="" action="{{route('manage.refund-policy.update')}}">
                    <input type="hidden" value="refund-policy" name="slug">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <textarea name="refundpolicy" class="form-control" placeholder="Refund Policy" id="editor1">{{$data['content']}}</textarea>
                                @component('components.error',['field'=>'refundpolicy'])@endcomponent
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-outline-primary" id="refund-policy-btn" type="submit" data-bs-original-title="" title="">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-src')
    <script src="{{asset('assets/js/editor/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('assets/js/editor/ckeditor/adapters/jquery.js')}}"></script>
    <script src="{{asset('assets/js/editor/ckeditor/styles.js')}}"></script>
    <script src="{{asset('assets/js/editor/ckeditor/ckeditor.custom.js')}}"></script>
@endpush
@push('script-tag')
    @include('stacks.js.modules.pages.refundpolicy')
@endpush
