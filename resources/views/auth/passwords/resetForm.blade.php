@extends('auth.customerLayouts')

@section('title','Reset Password')

@section('content')
    <section id="reset-password" class="bg--fixed reset-password-section division">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="login-page-logo">
                        <img class="img-fluid dark-theme-img" src="{{ asset('assets/images/logo/logo.png') }}" alt="{{ env('APP_NAME') }}">
                    </div>
                    <div class="reset-page-wrapper text-center">
                        <form method="post" class="row resetpasswordform reset-password-form r-10" action="{{ route('customer.password.reset.password.store') }}">
                            <div class="col-md-12">
                                <div class="reset-form-title">
                                    <h5 class="s-26 w-700">Reset your password?</h5>
                                    <p class="p-sm color--grey">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p class="p-sm input-header">New Password</p>
                                <div class="wrap-input">
                                    <span class="btn-show-pass ico-20"><span class="flaticon-visibility eye-pass"></span></span>
                                    <input class="form-control password" type="password" name="password" placeholder="* * * * * * * * *">
                                    @component('components.ajax-error',['field'=>'password'])@endcomponent
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p class="p-sm input-header">ReType Password</p>
                                <div class="wrap-input">
                                    <span class="btn-show-pass ico-20"><span class="flaticon-visibility eye-pass"></span></span>
                                    <input class="form-control password" type="password" name="password_confirmation" placeholder="* * * * * * * * *">
                                    @component('components.ajax-error',['field'=>'password_confirmation'])@endcomponent
                                </div>
                            </div>
                            <input type="hidden" value="{{ \Illuminate\Support\Facades\Session::get('mobile') }}" name="mobile"/>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn--theme hover--theme submit" id="checkmodal">Update Password</button>
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
@endsection

@push('script-tag')
    <script>
        $(document).ready(function(){
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
                            $('#checkmodal').html('<span class="spinner-border spinner-border-sm"></span> Update Password');
                            $('#checkmodal').attr('disabled', true);
                        },
                        success: function (result) {
                            $(this).attr("disabled", false);
                            if (result.type === 'SUCCESS') {
                                {{--let seconds = 3;--}}
                                {{--let countdown = setInterval(function() {--}}
                                {{--    toastr.success(`Password updated successfully.Wait redirecting in ${seconds} second${seconds !== 1 ? 's' : ''}...`, null, { timeOut: 1000 });--}}
                                {{--    seconds--;--}}
                                {{--    if (seconds < 1) {--}}
                                {{--        clearInterval(countdown);--}}
                                {{--        window.location.href = `{{ route('customer.login') }}`;--}}
                                {{--    }--}}
                                {{--}, 1000);--}}
                                toastr.success(`Password updated successfully.Wait redirecting in 2 seconds`);
                                setTimeout(function(){
                                    window.location.href = `{{ route('customer.login') }}`
                                },2000);
                            } else {
                                toastr.error(result.message);
                                $('#checkmodal').html('Update Password');
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
                            $('#checkmodal').html('Update Password');
                            $('#checkmodal').attr('disabled', false);
                        }
                    });
                }
            })
        })
    </script>
@endpush
