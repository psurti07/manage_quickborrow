@extends('layouts.manage')
@section('title', 'Account Message')

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
    <h3>Customer Account Message</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Account Message</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>SelfApply Important Updates</h5>
                    </div>
                    <form method="post" class="needs-validation account-message-selfapply-form" novalidate="" action="{{route('manage.account.message.selfapply.update')}}">
                        <div class="card-body">
                            <input type="hidden" value="self-apply" name="slug">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <textarea name="accountmessage_self_apply" rows="5" class="form-control" placeholder="Account Message" >{{ $sa }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-12">
                                <button class="btn btn-outline-primary" type="submit" data-bs-original-title="" title="" id="self-apply-btn">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Loan Agent Important Updates</h5>
                    </div>
                    <form method="post" class="needs-validation account-message-loanagent-form" novalidate="" action="{{route('manage.account.message.loanagent.update')}}">
                        <div class="card-body">
                            <input type="hidden" value="loan-agent" name="slug">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <textarea name="accountmessage_loan_agent" rows="5" class="form-control" placeholder="Account Message" >{{ $la }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-12">
                                <button class="btn btn-outline-primary" type="submit" data-bs-original-title="" title="" id="loan-agent-btn">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-src')
@endpush
@push('script-tag')
    @include('stacks.js.modules.siteoptions.accountmessage')
@endpush
