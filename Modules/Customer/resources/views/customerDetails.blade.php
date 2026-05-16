@extends('layouts.manage')
@section('title', 'Customers Details')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
    <style>
        .swal-title {
            font-weight: 100 !important;
            font-size: 20px !important;
        }
    </style>
@endpush

@section('breadcrumb-title')
    <h3>Self Apply Customer Details</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Customers Details</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            @if($customerInfo->isActive == 0)
            <div class="col-md-12 col-xs-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <p><strong>Customer account is not activated.</strong> You can activate user account from action panel.</p>
                </div>
            </div>
            @endif
            <div class="col-md-12 col-xs-12">
                <ul class="nav nav-pills nav-success" id="pills-warning-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-warning-customerInfo-tab" data-bs-toggle="pill" href="#pills-warning-customerInfo" role="tab" aria-controls="pills-warning-customerInfo" aria-selected="true">
                            <i class="icofont icofont-business-man-alt-1"></i>Customer Info
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-warning-membershipCard-tab" data-bs-toggle="pill" href="#pills-warning-membershipCard" role="tab" aria-controls="pills-warning-membershipCard" aria-selected="true">
                            <i class="icofont icofont-credit-card"></i>Plan History
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-warning-applicationList-tab" data-bs-toggle="pill" href="#pills-warning-applicationList" role="tab" aria-controls="pills-warning-applicationList" aria-selected="true">
                            <i class="icofont icofont-file-document"></i>Application List
                        </a>
                    </li>
                    @if(false)
                    <li class="nav-item">
                        <a class="nav-link" id="pills-warning-sourceentry-tab" data-bs-toggle="pill" href="#pills-warning-sourceentry" role="tab" aria-controls="pills-warning-sourceentry" aria-selected="true">
                            <i class="icofont icofont-space-shuttle"></i>Source Entry
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-warning-referral-tab" data-bs-toggle="pill" href="#pills-warning-referral" role="tab" aria-controls="pills-warning-referral" aria-selected="true">
                            <i class="icofont icofont-share"></i>&nbsp;Referral Customer List
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" id="pills-warning-assignAgent-tab" data-bs-toggle="pill" href="#pills-warning-assignAgent" role="tab" aria-controls="pills-warning-assignAgent" aria-selected="true">
                            <i class="icofont icofont-support"></i>&nbsp;Assign Loan Agent
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-warning-actions-tab" data-bs-toggle="pill" href="#pills-warning-actions" role="tab" aria-controls="pills-warning-actions" aria-selected="true">
                            <i class="icofont icofont-gear"></i>Actions
                        </a>
                    </li>
                </ul>
            </div>
            @if($message!=NULL)
            <div class="alert alert-secondary dark" role="alert">
                <p>{{ $message }}</p>
            </div>
            @endif
            <div class="col-md-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="ver-pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-warning-customerInfo" role="tabpanel" aria-labelledby="pills-warning-customerInfo-tab">
                                <form action="{{ route('manage.selfapply.customers.update') }}" method="post" class="customer-update-form" id="customer-update-form">
                                    <input type="hidden" name="userid" value="{{ $customerInfo->id }}">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <h6 class="fw-normal">Registration on: <b>{{ date('d-m-Y H:i', strtotime($customerInfo->rec_date)) }}</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="fw-normal">Referal Code: <b>{{ $customerInfo->refcode }}</b></h6>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="first_name">First Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $customerInfo->first_name }}">
                                            @component('components.ajax-error',['field'=>'first_name'])@endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            <label for="last_name">Last Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $customerInfo->last_name }}">
                                            @component('components.ajax-error',['field'=>'last_name'])@endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            <label for="mobile">Mobile<span class="text-danger">*</span></label>
                                            <input type="tel" disabled inputmode="numeric" class="numeric-input form-control" maxlength="10" minlength="10" id="mobile" name="mobile" value="{{ $customerInfo->mobile }}">
                                            @component('components.ajax-error',['field'=>'mobile'])@endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            <label for="email">Email<span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $customerInfo->email }}">
                                            @component('components.ajax-error',['field'=>'email'])@endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            <label for="dob">DOB<span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="dob" name="dob" value="{{ $customerInfo->dob }}">
                                            @component('components.ajax-error',['field'=>'dob'])@endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            <label for="pancard">PAN Card<span class="text-danger">*</span></label>
                                            <input type="text" disabled class="form-control" id="pancard" name="pancard" value="{{ $customerInfo->pancard }}" maxlength="10" minlength="10">
                                            @component('components.ajax-error',['field'=>'pancard'])@endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            <label for="city">Pincode<span class="text-danger">*</span></label>
                                            <input type="text" class="numeric-input form-control" id="pincode" name="pincode" value="{{ $customerInfo->pincode }}" maxlength="6" minlength="6">
                                            @component('components.ajax-error',['field'=>'pincode'])@endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            <label for="city">City<span class="text-danger">*</span></label>
                                            <input type="text" class="numeric-input form-control" id="city" readonly name="city" value="{{ $customerInfo->city }}">
                                            @component('components.ajax-error',['field'=>'city'])@endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            <label for="state">State<span class="text-danger">*</span></label>
                                            <input name="state" id="state" class="form-control mb-0" readonly style="font-size:16px!important;" value="{{ $customerInfo->state }}">
                                        </div>
                                        <span class="text-danger pincode-msg"></span>
                                        <div class="col-md-12 mt-3 text-end">
                                            <button type="submit" class="btn btn-outline-primary customersBtn" id="customersBtn" name="customersBtn">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-warning-membershipCard" role="tabpanel" aria-labelledby="pills-warning-membershipCard-tab">
                                <div class="row">
                                    @if($membershipOrder != null)
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered plan-table" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Purchase Date</th>
                                                            <th>Expiry Date</th>
                                                            <th>Plan</th>
                                                            <th>Card No.</th>
                                                            <th>Amount</th>
                                                            <th>Invoice</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($membershipOrder as $mo)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{ date('d-m-Y',strtotime($mo->registration_date)) }}</td>
                                                            <td>{{ date('d-m-Y',strtotime($mo->expiry_date)) }}</td>
                                                            <td>{{ $customerInfo->acc_type == 1 ? 'SelfApply' : 'Loan Agent' }}</td>
                                                            <td>{{ $mo->card_number }}</td>
                                                            <td>{{ formatePriceIndia($mo->amount) }}</td>
                                                            <td>
                                                                <a href="{{ route('manage.selfapply.customers.invoice', ['cardId' => $mo->id, 'userId' => $customerInfo->id]) }}" target="_blank" class="">
                                                                    <i class="icon icon-files"></i>&nbsp;Download Invoice
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                            <p>No Data Available</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="pills-warning-applicationList" role="tabpanel" aria-labelledby="pills-warning-applicationList-tab">
                                <div class="row">
                                    <div class="col-12 text-end mb-3">
                                        <a href="{{ route('manage.selfapply.loan.applications.details',['userId'=>$customerInfo->id]) }}" class="btn btn-outline-info" data-bs-original-title="" title=""><i class="fa fa-file-text"></i>&nbsp;Application Details</a>
                                        <a href="{{ route('manage.selfapply.loan.application.download.report',['userid'=>$customerInfo->id,'appid'=>$loanApp[0]['id']]) }}" class="btn btn-outline-primary" data-bs-original-title="" title=""><i class="fa fa-download"></i>&nbsp;Download Report</a>
                                    </div>
                                    @foreach($loanApp as $loan)
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <p><b>Loan Details :</b></p>
                                                    <dl class="row">
                                                        <dd class="col-md-4">Loan Date</dd>
                                                        <dt class="col-md-8">{{ date('d/m/Y', strtotime($loan->rec_date)) }}</dt>
                                                    </dl>
                                                    <hr>
                                                    <dl class="row">
                                                        <dd class="col-md-4">Loan Type</dd>
                                                        <dt class="col-md-8">{{ $loan->loan_type==1 ? 'Personal Loan' : 'Business Loan' }}</dt>
                                                    </dl>
                                                    <hr>
                                                    <dl class="row">
                                                        <dd class="col-md-4">Loan Amount</dd>
                                                        <dt class="col-md-8">{{ formatePriceIndia($loan->loan_amount) }}</dt>
                                                    </dl>
                                                    <hr>
                                                    <dl class="row">
                                                        <dd class="col-md-4">Loan Purpose :</dd>
                                                        <dt class="col-md-8">{{ $loan->loan_purpose }}</dt>
                                                    </dl>
                                                    <hr>
                                                    <dl class="row">
                                                        <dd class="col-md-4">Income :</dd>
                                                        <dt class="col-md-8">{{ formatePriceIndia($loan->monthly_income) }}</dt>
                                                    </dl>
                                                    <hr>
                                                    <dl class="row">
                                                        <dd class="col-md-4">Current EMI :</dd>
                                                        <dt class="col-md-8">{{ $loan->currentemi }}</dt>
                                                    </dl>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="col-xl-6 col-sm-12">
                                        <div class="card">
                                            <div class="card-header card-no-border">
                                                <div class="header-top">
                                                    <h5>Approved Offers</h5>
                                                </div>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="recent-table table-responsive currency-table">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th class="f-light">Bank Logo</th>
                                                                <th class="f-light">Bank Name</th>
                                                                <th class="f-light">Loan Amount</th>
                                                                <th class="f-light">Max Tenure<br/><small>(Best Rates)</small></th>
                                                                <th class="f-light text-center">Details</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if($offers)
                                                                @foreach($offers as $offer)
                                                                <tr>
                                                                    <td>         
                                                                        <img src="{{ asset('upload/banks/'.$offer->bank_image) }}" width="80">
                                                                    </td>
                                                                    <td>
                                                                        <div>
                                                                            <h6 class="f-14 mb-0 f-w-400">{{ $offer->bank_name }}</h6>
                                                                        </div>
                                                                    </td>
                                                                    <td>₹{{ formatePriceIndia($offer->loanAmount) }}</td>
                                                                    <td>{{ $offer->tenures }} Months<br/><small>({{ $offer->roi }}%)</small></td>
                                                                    <td class="text-center">
                                                                        <a href="javascript:;" onclick="openCountsModal({{ $offer->apply_id }}, {{ $customerInfo->id }}, {{ $offer->bankid }})" id="appInfo" class="appInfo-ClickCounts" data-bs-original-title="" title="">
                                                                            <span class="icon-info-alt"></span>
                                                                        </a>
                                                                    </td>
                                                                    
                                                                </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="4"><p class=text-center>Currently not any offers.</p></tr>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-warning-sourceentry" role="tabpanel" aria-labelledby="pills-warning-sourceentry-tab">
                                <div class="row">
                                    @if($sourceDetails != null)
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered plan-table" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Source</th>
                                                            <th>Campaign</th>
                                                            <th>Medium</th>
                                                            <th>Source ID</th>
                                                            <th>Referral</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($sourceDetails as $source)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{ $source->utm_source ?? '-' }}</td>
                                                            <td>{{ $source->utm_campaign ?? '-' }}</td>
                                                            <td>{{ $source->utm_medium ?? '-' }}</td>
                                                            <td>{{ $source->source_id ?? '-' }}</td>
                                                            <td>{{ $source->utm_referral ?? '-' }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                            <p>No Data Available</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-warning-referral" role="tabpanel" aria-labelledby="pills-warning-referral-tab">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-border referral-list-table" id="referral-list-table">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Fullname</th>
                                                    <th>Mobile</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($referralUsers as $user)
                                                    <tr>
                                                        <td>{{ date('d-m-Y H:i:s') }}</td>
                                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                        <td>{{ $user->mobile }}</td>
                                                        <td>{{ $user->email }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="pills-warning-assignAgent" role="tabpanel" aria-labelledby="pills-warning-assignAgent-tab">
                                <form class="row g-3 needs-validation custom-input assign-agent-form" id="assign-agent-form" novalidate="" method="post" action="{{ route('manage.selfapply.customers.assign.agent') }}">
                                    <input type="hidden" value="{{ $customerInfo->id }}" name="userid">
                                    <div class="col-md-4">
                                        <label for="agentList">Choose Agent</label>
                                        <select class="form-select" name="staffid" id="staffid">
                                            <option value="">Select Agent</option>
                                            @foreach($agentList as $al)
                                                <option value="{{ $al->id }}" {{ $al->id == $customerInfo->staff_id ? 'selected' : '' }}><small>{{ $al->fullname }}</small></option>
                                            @endforeach
                                        </select>
                                        @component('components.ajax-error',['field'=>'staffid'])@endcomponent
                                    </div>
                                    <div class="col-md-3 mt-5">
                                        <button type="submit" class="btn btn-outline-primary" name="assignAgentBtn">Assign Agent</button>
                                    </div>
                                </form>
                                <hr/>
                                @if(isset($agentData))
                                <div class="col-md-4">
                                    <label for="agentList"><b>Agent Details</b></label>
                                    <div class="flex-space flex-wrap align-items-center">
                                        <p> <strong>Agent Name: </strong>{{ $agentData->fullname }}<br><strong>Agent Email: </strong> {{ $agentData->emailid }}<br><strong>Contact Number: </strong>(+91) {{ substr($agentData->mobile,0,5).' '.substr($agentData->mobile, 5) }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <div class="tab-pane fade" id="pills-warning-actions" role="tabpanel" aria-labelledby="pills-warning-actions-tab">
                                <form class="row g-3 needs-validation custom-input update-password-form" id="update-password-form" novalidate="" method="post" action="{{ route('manage.selfapply.customers.update.password') }}">
                                    <input type="hidden" value="{{ $customerInfo->id }}" name="userid">
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
                                    <div class="col-md-2">
                                        <label for="">&nbsp;</label>
                                        <h4 id="passwordtext" class=""></h4>
                                    </div>

                                    <div class="col-md-2">
                                        <button type="button" onclick="return generatepassword();" class="mt-4 btn btn-outline-light active txt-dark" name="generateBtn">Generate</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-outline-primary" name="changePswdBtn" id="changePswdBtn">Change Password</button>
                                    </div>
                                </form>
                                <div class="row text-center m-t-40 g-3">
                                    <hr/>
                                    @if($customerInfo->isActive == 1)
                                    <div class="col-md-6 text-lg-end">
                                        <button class="btn btn-outline-primary accBtn" id="deactive-btn" onclick="deactivate({{ $customerInfo->id }},0)">DEACTIVATE CUSTOMER ACCOUNT</button>
                                    </div>
                                    <div class="col-md-6 text-lg-start">
                                        <button class="btn btn-outline-danger" id="delete-btn" onclick="destroy({{ $customerInfo->id }})">DELETE CUSTOMER</button>
                                    </div>
                                    @else
                                    <div class="col-md-6 text-center">
                                        <button class="btn btn-outline-success accBtn" id="activate-btn" onclick="deactivate({{ $customerInfo->id }},1)">ACTIVATE CUSTOMER ACCOUNT</button>
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
    <div class="clickCountsModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
    <script>
        $(".referral-list-table").DataTable({});
        $(".plan-table").DataTable({});
        $(".customer-update-form").submit(function(){
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
        })
        function generatepassword() {
            newpass = Math.floor(100000 + Math.random() * 900000);
            document.getElementById('new_password').value = newpass;
            document.getElementById('retype_password').value = newpass;
            $('#passwordtext').html(newpass);
        }
        $('.update-password-form').submit(function(event) {
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
                    beforeSend: function() {
                        $('#changePswdBtn').html('<span class="spinner-border spinner-border-sm"></span> Change Password ');
                        $('#changePswdBtn').attr('disabled', true);
                    },
                    success: function(result) {
                        $(this).attr("disabled", false);
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            $("#new_password").val('');
                            $("#retype_password").val('');
                            $('#changePswdBtn').html('Change Password ');
                            $('#changePswdBtn').attr('disabled', false);
                        } else {
                            toastr.error(result.message);
                            $('#changePswdBtn').html('Change Password ');
                            $('#changePswdBtn').attr('disabled', false);
                        }
                    },
                    error: function(error) {
                        $(this).attr("disabled", false);
                        let errors = error.responseJSON.errors,
                            errorsHtml = '';
                        $.each(errors, function(key, value) {
                            errorsHtml = '<strong>' + value[0] + '</strong>';
                            $('.' + key).html(errorsHtml);
                        });
                        $('#changePswdBtn').html('Change Password ');
                        $('#changePswdBtn').attr('disabled', false);
                    }
                });
            }
        });
        $('.assign-agent-form').submit(function(event) {
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
                    success: function(result) {
                        $(this).attr("disabled", false);
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            setTimeout(function() {
                                window.location.reload();
                            }, 2);
                        } else {
                            toastr.error(result.message);
                        }
                    },
                    error: function(error) {
                        $(this).attr("disabled", false);
                        let errors = error.responseJSON.errors,
                            errorsHtml = '';
                        $.each(errors, function(key, value) {
                            errorsHtml = '<strong>' + value[0] + '</strong>';
                            $('.' + key).html(errorsHtml);
                        });
                    }
                });
            }
        })

        function deactivate(userid, status) {
            var msg = 'You want to deactivate this account.'
            var txtx = 'DEACTIVATE CUSTOMER ACCOUNT';
            if (status == 1) {
                msg = 'You want to activate this account.';
                txtx = 'ACTIVATE CUSTOMER ACCOUNT';
            }
            swal({
                title: "Are you sure?",
                text: `${msg}`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: ["No", "Yes"],
            }).then((performYes) => {
                if (performYes) {
                    $.ajax({
                        url: `{{ route('manage.selfapply.customers.deactivate.account') }}`,
                        type: `POST`,
                        data: JSON.stringify({
                            userid: userid,
                            status: status
                        }),
                        contentType: "application/json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                            $('#accBtn').html(`<span class="spinner-border spinner-border-sm"></span> ${txtx} `);
                            $('#accBtn').attr('disabled', true);
                        },
                        success: function(result) {
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

        function destroy(userid) {
            swal({
                text: "You don't need any more of this account",
                title: "Are you sure?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: ["No", "Yes"],
            }).then((performYes) => {
                if (performYes) {
                    $.ajax({
                        url: `{{ route('manage.selfapply.customers.delete.account') }}`,
                        type: `POST`,
                        data: JSON.stringify({
                            userid: userid
                        }),
                        contentType: "application/json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                            $('#accBtn').html(`<span class="spinner-border spinner-border-sm"></span> DELETE CUSTOMER `);
                            $('#accBtn').attr('disabled', true);
                        },
                        success: function(result) {
                            if (result.type === 'SUCCESS') {
                                toastr.success(result.message);
                                window.location.href = `{{ route('manage.selfapply.users') }}`;
                            } else {
                                toastr.error(result.message);
                            }
                        }
                    })
                }
            });
        }

        $('#pincode').on('input', function() {
            var pincode = $(this).val();

            // Only make request if pincode is of 6 digits
            if (pincode.length === 6) {
                $('#loader').show(); // Show loader
                $.ajax({
                    url: `{{ route('manage.postal.details') }}`, // Route to the Laravel controller
                    type: 'POST',
                    data: {
                        pincode: pincode
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Pass CSRF token
                    },
                    beforeSend: function(xhr) {
                        $(".pincode-msg").text('we are fetching cities and state'); // Example: Show a loading indicator
                    },
                    success: function(response) {
                        $('#loader').hide(); // Hide loader
                        if (response.status === 'success') {
                            $(".pincode-msg").text('')
                            // Populate District and State fields
                            $('#city').val(response.district);
                            $('#state').val(response.state);
                        } else {
                            $(".pincode-msg").text('');
                            alert(response.message);
                            $('#district').val('');
                            $('#state').val('');
                        }
                    },
                    error: function() {
                        $('#loader').hide();
                        $(".pincode-msg").text('') // Hide loader on error
                        alert('An error occurred while fetching the details.');
                    }
                });
            } else {
                // Clear the fields if pincode length is not 6 digits
                $('#city').val('');
                $('#state').val('');
            }
        });
        
        /* click counts scripts start */
        function openCountsModal(applyId, userId, bankId){
            $.ajax({
                url: "{!! route('manage.selfapply.customers.offers.click.count') !!}",
                type: 'POST',
                data:  JSON.stringify({applyId: applyId, userId: userId, bankId: bankId}),
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    $('.clickCountsModals').html(result);
                    $('#clickCountsModal').modal('show');
                }
            });
        }
        /* click counts scripts ends */
        
    </script>
@endpush