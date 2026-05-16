@extends('layouts.manage')
@section('title', 'Privacy Policy')

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
    <h3>Privacy Policy</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Privacy Policy</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12">
                <form method="post" class="needs-validation privacy-policy-form" novalidate="" action="{{ route('manage.privacy-policy.update') }}">
                    <input type="hidden" value="privacy-policy" name="slug">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <textarea name="privacypolicy" class="form-control" placeholder="Privacy Policy" id="editor1">{{$data['content']}}</textarea>
                                @component('components.error',['field'=>'privacypolicy'])@endcomponent
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-outline-primary" id="privacy-policy-btn" type="submit" data-bs-original-title="" title="">Update</button>
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
    @include('stacks.js.modules.pages.privacypolicy')
@endpush
