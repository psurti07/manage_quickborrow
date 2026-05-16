@extends('auth.customerLayouts')

@section('title','Customer Login')

@push('style-tag')
    <style>
        .register-page-form .form-control { margin-bottom: 0px!important; }
        .reset-password-link{ margin-top: 20px!important; }
    </style>
@endpush

@section('content')
    <div id="login" class="bg--scroll login-section division">
        <div class="container">
            <div class="row justify-content-center">
                <!-- REGISTER PAGE WRAPPER -->
                <div class="col-lg-11">
                    <div class="register-page-wrapper r-16 bg--fixed">
                        <div class="row">
                            <!-- LOGIN PAGE TEXT -->
                            <div class="col-md-6">
                                <div class="register-page-txt color--white">
                                    <!-- Logo -->
                                    <img class="img-fluid" src="{{ asset('assets/images/logo/logo-w.png') }}" alt="logo-image">
                                    <!-- Title -->
                                    <h2 class="s-42 w-700">Welcome</h2>
                                    <h2 class="s-42 w-700">back to {{ env('APP_NAME') }}</h2>
                                    <!-- Text -->
                                    <p class="p-md mt-25">Integer congue sagittis and velna augue egestas magna
                                        suscipit purus aliquam
                                    </p>
                                    <br/><br/><br/><br/>
                                    <!-- Copyright -->
                                    <div class="register-page-copyright">
                                        <p class="p-sm">{{ date('Y') }} &copy; {{ env('COMPANY_NAME') }}. <span>All Rights Reserved.</span></p>
                                    </div>
                                </div>
                            </div>	<!-- END LOGIN PAGE TEXT -->
                            <!-- LOGIN FORM -->
                            <div class="col-md-6">
                                <div class="register-page-form">
                                    <form name="signinform" class="row sign-in-form auth-form g-3" action="{{ route('customer.authenticate') }}" method="post">
                                        <div class="col-md-12">
                                            <p class="p-sm input-header">Mobile Number</p>
                                            <input class="form-control numeric-input" type="tel" name="mobile" placeholder="Mobile Number" id="mobile" maxlength="10" minlength="10" autocomplete="off" inputmode="numeric">
                                            @component('components.ajax-error',['field'=>'mobile'])@endcomponent
                                        </div>
                                        <!-- Form Input -->
                                        <div class="col-md-12">
                                            <p class="p-sm input-header">Password</p>
                                            <div class="wrap-input">
                                                <span class="btn-show-pass ico-20"><span class="flaticon-visibility eye-pass"></span></span>
                                                <input class="form-control password" type="password" name="password" id="password" placeholder="* * * * * * * * *">
                                                @component('components.ajax-error',['field'=>'password'])@endcomponent
                                            </div>
                                        </div>
                                        <!-- Reset Password Link -->
                                        <div class="col-md-12">
                                            <div class="reset-password-link">
                                                <p class="p-sm"><a href="{{ route('customer.password.reset') }}" class="color--theme">Forgot your password?</a></p>
                                            </div>
                                        </div>
                                        <!-- Form Submit Button -->
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn--theme hover--theme submit">Log In</button>
                                        </div>
                                        <!-- Sign Up Link -->
                                        <div class="col-md-12">
                                            <p class="create-account text-center">
                                                Don't have an account? <a href="{{ route('front.selfapply') }}" class="color--theme">Sign up</a>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script-tag')
    <script>
        $('.auth-form').submit(function (event) {
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
                            window.location.href = result.redirect
                        } else {
                            toastr.error(result.message)
                            $("#password").val('');
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
    </script>
@endpush
