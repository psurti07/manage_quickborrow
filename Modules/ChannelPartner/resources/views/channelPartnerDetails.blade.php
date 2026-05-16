@extends('layouts.manage')
@section('title', 'Channel Partner Details')

@push('css-links')
@endpush
@push('style-css')
    <style>
        .swal-title{ font-weight:100!important;font-size:20px!important;}
        #passwordtext{font-size:18px;font-weight:bold}
    </style>
@endpush

@section('breadcrumb-title')
    <h3>Channel Partner Details</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item"><a href="{{ route('manage.channelpartner') }}">Partner Lists</a></li>
    <li class="breadcrumb-item active">Channel Partner Details</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            @if($partnerData->isActive == 0)
                <div class="col-md-12 col-xs-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <p><strong>Channel Partner account is not activated.</strong> You can activate user account from action panel.</p>
                    </div>
                </div>
            @endif
            <div class="col-md-12 col-xs-12">
                <ul class="nav nav-pills nav-success" id="pills-warning-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-warning-customerInfo-tab" data-bs-toggle="pill" href="#pills-warning-customerInfo" role="tab" aria-controls="pills-warning-customerInfo" aria-selected="true">
                            <i class="icofont icofont-business-man-alt-1"></i>Personal Info
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-warning-companyInfo-tab" data-bs-toggle="pill" href="#pills-warning-companyInfo" role="tab" aria-controls="pills-warning-companyInfo" aria-selected="true">
                            <i class="icofont icofont-bank-alt"></i>Company Info
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-warning-actions-tab" data-bs-toggle="pill" href="#pills-warning-actions" role="tab" aria-controls="pills-warning-actions" aria-selected="true">
                            <i class="icofont icofont-gear"></i>Actions
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="ver-pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-warning-customerInfo" role="tabpanel" aria-labelledby="pills-warning-customerInfo-tab">
                                <form action="{{ route('manage.channelpartner.personalinfo.update') }}" method="post" class="channelpartner-update-personal-form" id="channelpartner-update-personal-form">
                                    <input type="hidden" name="userid" value="{{ $partnerData->id }}">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="first_name">First Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $partnerData->first_name }}" placeholder="First Name"/>
                                            @component('components.ajax-error',['field'=>'first_name'])@endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            <label for="last_name">Last Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $partnerData->last_name }}" placeholder="Last Name"/>
                                            @component('components.ajax-error',['field'=>'last_name'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-4">
                                            <label for="email">Email<span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" id="email" value="{{ $partnerData->email }}" placeholder="Email" autocomplete="off"/>
                                            @component('components.ajax-error',['field'=>'email'])@endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            <label for="mobile">Mobile<span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control numeric-input" name="mobile" maxlength="10" minlength="10" id="mobile" value="{{ $partnerData->mobile }}" placeholder="Mobile"/>
                                            @component('components.ajax-error',['field'=>'mobile'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3 text-end">
                                        <button type="submit" class="btn btn-outline-primary customersBtn" id="customersBtn" name="customersBtn">Save</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-warning-companyInfo" role="tabpanel" aria-labelledby="pills-warning-companyInfo-tab">
                                <form action="{{ route('manage.channelpartner.companyinfo.update') }}" method="post" class="channelpartner-update-form" id="channelpartner-update-form">
                                    <input type="hidden" name="userid" value="{{ $partnerData->id }}">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <h6 class="fw-normal">Registration on: <b>{{ date('d-m-Y H:i', strtotime($partnerData->rec_date)) }}</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="fw-normal">Company Code: <b>{{ $partnerData->company_code }}</b></h6>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="company_name">Company Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="company_name" id="company_name" value="{{ $partnerData->company_name }}" placeholder="Company Name"/>
                                            @component('components.ajax-error',['field'=>'company_name'])@endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            <label for="phone">Company Mobile<span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control numeric-input" name="phone" maxlength="10" minlength="10" id="phone" value="{{ $partnerData->phone }}" placeholder="Company Mobile"/>
                                            @component('components.ajax-error',['field'=>'phone'])@endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            <label for="vat_gst_no">GST No<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="vat_gst_no" id="vat_gst_no" value="{{ $partnerData->vat_gst_no }}" placeholder="GST No"/>
                                            @component('components.ajax-error',['field'=>'vat_gst_no'])@endcomponent
                                        </div>
                                        <div class="col-md-3">
                                            <label for="city">City<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="city" id="city" value="{{ $partnerData->city }}" placeholder="City"/>
                                            @component('components.ajax-error',['field'=>'city'])@endcomponent
                                        </div>
                                        <div class="col-md-3">
                                            <label for="state">State<span class="text-danger">*</span></label>
                                            <select class="form-select" name="state" id="state">
                                                <option value="">Select State</option>
                                                {!! getStateOption($partnerData->state) !!}
                                            </select>
                                            @component('components.ajax-error',['field'=>'state'])@endcomponent
                                        </div>
                                        <div class="col-md-3">
                                            <label for="pincode">Pincode<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control numeric-input" name="pincode" id="pincode" value="{{ $partnerData->pincode }}" placeholder="Pincode" maxlength="6" minlength="6"/>
                                            @component('components.ajax-error',['field'=>'pincode'])@endcomponent
                                        </div>
                                        <div class="col-md-3">
                                            <label for="website">Website<span class="text-danger">*</span></label>
                                            <input type="url" class="form-control" name="website" id="website" value="{{ $partnerData->website }}" placeholder="Website"/>
                                            @component('components.ajax-error',['field'=>'website'])@endcomponent
                                        </div>
                                        <div class="col-md-8">
                                            <label for="address">Address<span class="text-danger">*</span></label>
                                            <textarea class="form-control" rows="5" name="address" id="address">{{ $partnerData->address }}</textarea>
                                            @component('components.ajax-error',['field'=>'address'])@endcomponent
                                        </div>
                                        <div class="col-md-12 mt-3 text-end">
                                            <button type="submit" class="btn btn-outline-primary customersBtn" id="companyBtn" name="customersBtn">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-warning-actions" role="tabpanel" aria-labelledby="pills-warning-actions-tab">
                                <form class="row g-3 needs-validation custom-input update-password-form" id="update-password-form" novalidate="" method="post" action="{{ route('manage.channelpartner.update.password') }}">
                                    <input type="hidden" value="{{ $partnerData->id }}" name="userid">
                                    <div class="col-md-4">
                                        <label class="form-label" for="new_password">New Password</label>
                                        <input type="password" class="form-control " id="new_password" name="new_password" required="" autocomplete="new-password">
                                        @component('components.ajax-error',['field'=>'new_password'])@endcomponent
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="retype_password">Retype Password</label>
                                        <input type="password" class="form-control" id="retype_password" name="retype_password" required="" autocomplete="retype-password">
                                        @component('components.ajax-error',['field'=>'retype_password'])@endcomponent
                                    </div>
                                    <div class="col-md-2" style="margin-top:45px">
                                        <span id="passwordtext"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" onclick="return generatepassword();" class="mt-4 btn btn-outline-light active txt-dark" name="generateBtn">Generate</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-outline-primary" name="changePswdBtn">Change Password</button>
                                    </div>
                                </form>
                                <div class="row text-center m-t-40 g-3">
                                    <hr/>
                                    @if($partnerData->isActive == 1)
                                        <div class="col-md-6 text-lg-end">
                                            <button class="btn btn-outline-primary accBtn" id="deactive-btn" onclick="deactivate({{ $partnerData->id }},0)">DEACTIVATE CHANNEL PARTNER ACCOUNT</button>
                                        </div>
                                        <div class="col-md-6 text-lg-start">
                                            <button class="btn btn-outline-danger" id="delete-btn" onclick="destroy({{ $partnerData->id }})">DELETE CHANNEL PARTNER</button>
                                        </div>
                                    @else
                                        <div class="col-md-6 text-center">
                                            <button class="btn btn-outline-success accBtn" id="activate-btn" onclick="deactivate({{ $partnerData->id }},1)">ACTIVATE CHANNEL PARTNER ACCOUNT</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-src')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush

@push('script-tag')
    <script>
        $('.channelpartner-update-personal-form').submit(function(){
            var status = document.activeElement.innerHTML;
            event.preventDefault();
            if (status) {
                $('.ajax-error').html('');
                var data = new FormData(this);
                $.ajax({
                    url: $(this).attr("action"),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $('#customersBtn').html('<span class="spinner-border spinner-border-sm"></span> Save');
                        $('#customersBtn').attr('disabled', true);
                    },
                    success: function (result) {
                        $(this).attr("disabled", false);
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            setTimeout(function(){
                                window.location.reload();
                            },2);
                        } else {
                            toastr.error(result.message);
                            $('#customersBtn').html('Save');
                            $('#customersBtn').attr('disabled', false);
                        }
                    },
                    error: function (error) {
                        $(this).attr("disabled", false);
                        let errors = error.responseJSON.errors, errorsHtml = '';
                        $.each(errors, function (key, value) {
                            errorsHtml = '<strong>' + value[0] + '</strong>';
                            $('.' + key).html(errorsHtml);
                        });
                        $('#customersBtn').html('Save');
                        $('#customersBtn').attr('disabled', false);
                    }
                });
            }
        });
        $('.channelpartner-update-form').submit(function(){
            var status = document.activeElement.innerHTML;
            event.preventDefault();
            if (status) {
                $('.ajax-error').html('');
                var data = new FormData(this);
                $.ajax({
                    url: $(this).attr("action"),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $('#companyBtn').html('<span class="spinner-border spinner-border-sm"></span> Save');
                        $('#companyBtn').attr('disabled', true);
                    },
                    success: function (result) {
                        $(this).attr("disabled", false);
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            setTimeout(function(){
                                window.location.reload();
                            },2);
                        } else {
                            toastr.error(result.message);
                            $('#companyBtn').html('Save');
                            $('#companyBtn').attr('disabled', false);
                        }
                    },
                    error: function (error) {
                        $(this).attr("disabled", false);
                        let errors = error.responseJSON.errors, errorsHtml = '';
                        $.each(errors, function (key, value) {
                            errorsHtml = '<strong>' + value[0] + '</strong>';
                            $('.' + key).html(errorsHtml);
                        });
                        $('#companyBtn').html('Save');
                        $('#companyBtn').attr('disabled', false);
                    }
                });
            }
        });
        function generatepassword() {
            newpass = Math.floor(100000 + Math.random() * 900000);
            document.getElementById('new_password').value = newpass;
            document.getElementById('retype_password').value = newpass;
            $('#passwordtext').html(newpass);
        }
        $('.update-password-form').submit(function (event) {
            var status = document.activeElement.innerHTML;
            event.preventDefault();
            if (status) {
                $('.ajax-error').html('');
                var data = new FormData(this);
                $.ajax({
                    url: $(this).attr("action"),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (result) {
                        $(this).attr("disabled", false);
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            $("#new_password").val('');
                            $("#retype_password").val('');
                        } else {
                            toastr.error(result.message);
                        }
                    },
                    error: function (error) {
                        $(this).attr("disabled", false);
                        let errors = error.responseJSON.errors, errorsHtml = '';
                        $.each(errors, function (key, value) {
                            errorsHtml = '<strong>' + value[0] + '</strong>';
                            $('.' + key).html(errorsHtml);
                        });
                    }
                });
            }
        });
        function deactivate(userid, status){
            var msg = 'You want to deactivate this account.'
            var txtx = 'DEACTIVATE CHANNEL PARTNER ACCOUNT';
            if(status == 1){
                msg = 'You want to activate this account.';
                txtx = 'ACTIVATE CHANNEL PARTNER ACCOUNT';
            }
            swal({
                title: "Are you sure?",
                text: `${msg}`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: ["No","Yes"],
            }).then((performYes) => {
                if (performYes) {
                    $.ajax({
                        url: `{{ route('manage.channelpartner.account.deactivate') }}`,
                        type: `POST`,
                        data: JSON.stringify({userid: userid, status: status}),
                        contentType: "application/json",
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        beforeSend: function() {
                            $('#accBtn').html(`<span class="spinner-border spinner-border-sm"></span> ${txtx} `);
                            $('#accBtn').attr('disabled', true);
                        },
                        success: function (result) {
                            if (result.type === 'SUCCESS') {
                                toastr.success(result.message);
                                window.location.reload();
                            } else {
                                toastr.error(result.message);
                            }
                        }
                    })
                }
            });
        }
        function destroy(userid){
            swal({
                text: "You don't need any more of this account",
                title: "Are you sure?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: ["No","Yes"],
            }).then((performYes) => {
                if(performYes){
                    $.ajax({
                        url: `{{ route('manage.channelpartner.account.delete') }}`,
                        type: `POST`,
                        data: JSON.stringify({userid: userid}),
                        contentType: "application/json",
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        beforeSend: function() {
                            $('#accBtn').html(`<span class="spinner-border spinner-border-sm"></span> DELETE STAFF `);
                            $('#accBtn').attr('disabled', true);
                        },
                        success:function(result){
                            if(result.type === 'SUCCESS'){
                                toastr.success(result.message);
                                window.location.href = `{{ route('manage.channelpartner') }}`;
                            } else {
                                toastr.error(result.message);
                            }
                        }
                    })
                }
            });
        }
    </script>
@endpush

