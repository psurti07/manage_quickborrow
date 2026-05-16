@extends('layouts.manage')
@section('title', 'Welcome Message')

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
    <h3>HomePage Welcome Message</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Welcome Message</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12">
                <form method="post" class="needs-validation welcome-message-form" novalidate="" action="{{route('manage.welcome-message.update')}}">
                    <input type="hidden" value="welcome-message" name="slug">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <textarea name="welcomemessage" class="form-control" placeholder="Welcome Message" id="editor1">{{$data['content']}}</textarea>
                                @component('components.error',['field'=>'welcomemessage'])@endcomponent
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="status" id="btnradio1" autocomplete="off" {{ $data['status'] == 1 ? 'checked=true':'' }} value="1">
                                <label class="btn btn-outline-info" for="btnradio1">Show</label>
                                <input type="radio" class="btn-check" name="status" id="btnradio2" autocomplete="off" {{ $data['status'] == 2 ? 'checked=true':'' }} value="2">
                                <label class="btn btn-outline-info" for="btnradio2">Hide</label>
                            </div>
                        </div>
                        <div class="col-4 mb-6">
                            <button class="btn btn-outline-primary" id="welcome-message-btn" type="submit" data-bs-original-title="" title="">Update</button>
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
    @include('stacks.js.modules.siteoptions.welcomemessage')
@endpush
