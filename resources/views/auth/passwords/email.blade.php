@extends('auth.customerLayouts')

@section('title','Forget Password')

@section('content')
    <section id="reset-password" class="bg--fixed reset-password-section division">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="login-page-logo">
                        <img class="img-fluid dark-theme-img" src="{{ asset('assets/images/logo/logo.png') }}" alt="{{ env('APP_NAME') }}">
                    </div>
                    <div class="reset-page-wrapper text-center">
                        <form method="post" class="row resetpasswordform reset-password-form r-10" action="{{ route('customer.password.mobile') }}">
                            <div class="col-md-12">
                                <div class="reset-form-title">
                                    <h5 class="s-26 w-700">Forgot your password?</h5>
                                    <p class="p-sm color--grey">Enter your mobile number, if an account exists we‘ll
                                        send you a otp to reset your password.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <input class="form-control numeric-input mb-0" type="text" name="mobile" placeholder="Enter mobile number" maxlength="10" minlength="10" inputmode="numeric">
                                @component('components.ajax-error',['field'=>'mobile'])@endcomponent
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn--theme hover--theme submit" id="checkmodal">Reset My Password</button>
                            </div>
                            <div class="col-md-12">
                                <div class="form-data text-center">
                                    <span>Already have an account? <a href="{{ route('customer.login') }}">Sign In</a></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- OTP modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content p-30 border-radius-10">
                <form action="{{ route('customer.password.verifyOtp') }}" method="post" class="request-form save-form-2 needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="row color--black">
                            <p class="s-24">OTP Verification</p>
                            <p class="s-16">Enter the 6 digit OTP received on your mobile <br/>
                                <span class="text-success w-600">+91 <span class="text-success w-600" id="mobileNumber"></span> </span>
                            </p>
                            <div class="otp-form">
                                <div class="otp-container">
                                    <input type="text" class="otp-input" pattern="\d" maxlength="1">
                                    <input type="text" class="otp-input" pattern="\d" maxlength="1" disabled>
                                    <input type="text" class="otp-input" pattern="\d" maxlength="1" disabled>
                                    <input type="text" class="otp-input" pattern="\d" maxlength="1" disabled>
                                    <input type="text" class="otp-input" pattern="\d" maxlength="1" disabled>
                                    <input type="text" class="otp-input" pattern="\d" maxlength="1" disabled>
                                </div>
                            </div>
                            <span class="mt-2 s-12 text-success" id="msg">
                            <input type="hidden" id="mobileNumber1" name="mobile" readonly>
                            <input type="hidden" id="verificationCode" name="otp" readonly>
                            <span class="text-danger f-w-400" id="invalidOtp" style="font-size:14px"></span>
                            @component('components.ajax-error',['field'=>'otp'])@endcomponent
                        </div>
                    </div>
                    <button type="submit" id="otpBtn" class="btn btn--theme hover--theme submit mt-3">Verify &amp; Proceed</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-tag')
    <script>
        $(document).ready(function(){
            $('.numeric-input').on('keydown', function(event) {
                if (!(event.key === 'Backspace' || event.key === 'Delete' || (event.key >= '0' && event.key <= '9'))) {
                    event.preventDefault();
                }
            });
            $('.resetpasswordform').submit(function(){
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
                            $('#checkmodal').html('<span class="spinner-border spinner-border-sm"></span> Reset My Password');
                            $('#checkmodal').attr('disabled', true);
                        },
                        success: function (result) {
                            $(this).attr("disabled", false);
                            if (result.type === 'SUCCESS') {
                                $("#mobileNumber").text(result.data);
                                $("#mobileNumber1").val(result.data);
                                $("#exampleModal").modal('show',{backdrop: 'static', keyboard: false});
                            } else {
                                toastr.error(result.message);
                                $('#checkmodal').html('Reset My Password');
                                $('#checkmodal').attr('disabled', false);
                            }
                        },
                        error: function (error) {
                            $(this).attr("disabled", false);
                            let errors = error.responseJSON.errors, errorsHtml = '';
                            $.each(errors, function (key, value) {
                                errorsHtml = '<strong>' + value[0] + '</strong>';
                                $('.' + key).html(errorsHtml);
                            });
                            $('#checkmodal').html('Reset My Password');
                            $('#checkmodal').attr('disabled', false);
                        }
                    });
                }
            });
            $('.save-form-2').submit(function (event) {
                $("#invalidOtp").text('');
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
                            $('#otpBtn').html('<span class="spinner-border spinner-border-sm"></span> Validating...');
                            $('#otpBtn').attr('disabled', true);
                        },
                        success: function (result) {
                            $(this).attr("disabled", false);
                            if (result.type === 'SUCCESS') {
                                // let seconds = 3;
                                // let countdown = setInterval(function() {
                                //     seconds--;
                                //     if (seconds < 1) {
                                //         clearInterval(countdown);
                                //
                                //     }
                                // }, 1000);
                                toastr.success(`OTP verified successfully. Redirecting in 2 seconds`);
                                setTimeout(function(){
                                    window.location.href = `{{ route('customer.password.reset.password') }}`;
                                },2000)
                            } else {
                                $("#invalidOtp").text(result.message);
                                $('#otpBtn').html('Verify &amp; Proceed');
                                $('#otpBtn').attr('disabled', false);
                            }
                        },
                        error: function (error) {
                            $(this).attr("disabled", false);
                            let errors = error.responseJSON.errors, errorsHtml = '';
                            $.each(errors, function (key, value) {
                                errorsHtml = '<strong>' + value[0] + '</strong>';
                                $('.' + key).html(errorsHtml);
                            });
                            $('#otpBtn').html('Verify &amp; Proceed');
                            $('#otpBtn').attr('disabled', false);
                        }
                    });
                }
            });
        });
    </script>
@endpush
