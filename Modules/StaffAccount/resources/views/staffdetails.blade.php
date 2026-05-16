@extends('layouts.manage')
@section('title', 'Staff Details')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
    <style>
        .swal-title{ font-weight:100!important;font-size:20px!important;}
        #passwordtext{font-size:18px;font-weight:bold}
    </style>
@endpush

@section('breadcrumb-title')
    <h3>Staff Details</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('manage.staff.account') }}">Staff Lists</a></li>
    <li class="breadcrumb-item active">Staff Details</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            @if($staffDetails->isActive == 0)
                <div class="col-md-12 col-xs-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <p><strong>Staff account is not activated.</strong> You can activate staff account from action panel.</p>
                    </div>
                </div>
            @endif
            <div class="col-md-12 col-xs-12">
                <ul class="nav nav-pills nav-success" id="pills-warning-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-warning-customerInfo-tab" data-bs-toggle="pill" href="#pills-warning-customerInfo" role="tab" aria-controls="pills-warning-customerInfo" aria-selected="true">
                            <i class="icofont icofont-business-man-alt-1"></i>Staff Info
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-warning-actions-tab" data-bs-toggle="pill" href="#pills-warning-actions" role="tab" aria-controls="pills-warning-actions" aria-selected="true">
                            <i class="icofont icofont-gear"></i>Actions
                        </a>
                    </li>
                    <!--<li class="nav-item">
                        <a class="nav-link" id="pills-warning-logs-tab" data-bs-toggle="pill" href="#pills-warning-logs" role="tab" aria-controls="pills-warning-logs" aria-selected="true">
                            <i class="icofont icofont-history"></i>Logs
                        </a>
                    </li>-->
                </ul>
            </div>
            <div class="col-md-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="ver-pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-warning-customerInfo" role="tabpanel" aria-labelledby="pills-warning-customerInfo-tab">
                                <form action="{{ route('manage.staff.account.update') }}" method="post" class="staff-update-form" id="staff-update-form">
                                    <input type="hidden" name="userid" value="{{ $staffDetails->id }}">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <h6 class="fw-normal">Registration on: <b>{{ date('d-m-Y H:i', strtotime($staffDetails->rec_date)) }}</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="fw-normal">Referal Code: <b>{{ $staffDetails->staff_code }}</b></h6>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="fullname">Staff Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="fullname" name="fullname" value="{{ $staffDetails->fullname }}">
                                            @component('components.ajax-error',['field'=>'fullname'])@endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            <label for="mobile">Mobile<span class="text-danger">*</span></label>
                                            <input type="tel" inputmode="numeric" class="numeric-input form-control" maxlength="10" minlength="10" id="mobile" name="mobile" value="{{ $staffDetails->mobile }}">
                                            @component('components.ajax-error',['field'=>'mobile'])@endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            <label for="emailid">Email<span class="text-danger">*</span></label>
                                            <input type="emailid" class="form-control" id="emailid" name="emailid" value="{{ $staffDetails->emailid }}">
                                            @component('components.ajax-error',['field'=>'emailid'])@endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            <label for="dob">DOB</label>
                                            <input type="date" class="form-control" id="dob" name="dob" value="{{ $staffDetails->dob }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="position">Position</label>
                                            <input type="text" class="form-control" id="position" name="position" value="{{ $staffDetails->position }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="role">Role</label>
                                            <select class="form-control form-select" name="role" id="role">
                                                <option value="">Select Role</option>
                                                <option value="1" {{ $staffDetails->role == 1 ? 'selected': '' }}>Office Staff</option>
                                                <option value="5" {{ $staffDetails->role == 5 ? 'selected': '' }}>Self Apply Staff</option>
                                                <option value="2" {{ $staffDetails->role == 2 ? 'selected': '' }}>Loan Agent Staff</option>
                                                <option value="3" {{ $staffDetails->role == 3 ? 'selected': '' }}>IT Staff</option>
                                                <option value="4" {{ $staffDetails->role == 4 ? 'selected': '' }}>Accounting</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-3 text-end">
                                            <button type="submit" class="btn btn-outline-primary customersBtn" id="customersBtn" name="customersBtn">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-warning-logs" role="tabpanel" aria-labelledby="pills-warning-logs-tab">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-border logs-list-table" id="logs-list-table">
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-warning-actions" role="tabpanel" aria-labelledby="pills-warning-actions-tab">
                                <form class="row g-3 needs-validation custom-input update-password-form" id="update-password-form" novalidate="" method="post" action="{{ route('manage.staff.account.update.password') }}">
                                    <input type="hidden" value="{{ $staffDetails->id }}" name="userid">
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
                                    @if($staffDetails->isActive == 1)
                                        <div class="col-md-6 text-lg-end">
                                            <button class="btn btn-outline-danger accBtn" id="deactive-btn" onclick="deactivate({{ $staffDetails->id }},0)">DEACTIVATE STAFF ACCOUNT</button>
                                        </div>
                                        <div class="col-md-6 text-lg-start">
                                            <button class="btn btn-outline-danger" id="delete-btn" onclick="destroy({{ $staffDetails->id }})">DELETE STAFF</button>
                                        </div>
                                    @else
                                        <div class="col-md-6 text-center">
                                            <button class="btn btn-outline-success accBtn" id="activate-btn" onclick="deactivate({{ $staffDetails->id }},1)">ACTIVATE STAFF ACCOUNT</button>
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
    @include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
    <script>
        $(".staff-update-form").submit(function(){
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
            var txtx = 'DEACTIVATE CUSTOMER ACCOUNT';
            if(status == 1){
                msg = 'You want to activate this account.';
                txtx = 'ACTIVATE CUSTOMER ACCOUNT';
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
                        url: `{{ route('manage.staff.account.deactivate') }}`,
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
                        url: `{{ route('manage.staff.account.delete') }}`,
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
                                window.location.href = `{{ route('manage.staff.account') }}`;
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
