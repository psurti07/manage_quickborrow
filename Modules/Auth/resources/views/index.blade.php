@extends('layouts.auth')
@section('title','Administrations')

@push('css-links')
@endpush
@push('style-css')
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 p-0">
                <div class="login-card login-dark">
                    <div>
                        <div class="login-main">
                            <div>
                                <a class="logo text-center" href="javascript:;">
                                    <img class="img-fluid for-light" src="{{asset('assets/images/logo/logo.png')}}" alt="{{ env('APP_NAME') }}" width="150"/>
                                </a>
                            </div>
                            <form class="theme-form auth-form" action="{{ route('authenticate') }}" method="post">
                                <h5>Sign in to account</h5>
                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <input class="form-control" type="email" placeholder="Enter Email" name="emailid" id="emailid" value="{{ old('emailid') }}"/>
                                    @component('components.ajax-error',['field'=>'emailid'])@endcomponent
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <input class="form-control" type="password" name="password" placeholder="Enter Password" id="password"/>
                                    @component('components.ajax-error',['field'=>'password'])@endcomponent
                                </div>
                                <div class="form-group mt-3">
                                    <button class="btn btn-primary btn-block submit-btn" id="submit-btn" type="submit">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-src')
@endpush
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
                    beforeSend:function(){
                        $('#submit-btn').html('<span class="spinner-border spinner-border-sm"></span> Sign In');
                        $('#submit-btn').attr('disabled', true);
                    },
                    success: function (result) {
                        $(this).attr("disabled", false);
                        if (result.type === 'SUCCESS') {
                            window.location.href = result.redirect
                        } else {
                            toastr.error(result.message)
                            $("#password").val('');
                            $('#submit-btn').html('Sign In');
                            $('#submit-btn').attr('disabled', false);
                        }
                    },
                    error: function (error) {
                        $(this).attr("disabled", false);
                        let errors = error.responseJSON.errors, errorsHtml = '';
                        $.each(errors, function (key, value) {
                            errorsHtml = '<strong>' + value[0] + '</strong>';
                            $('.' + key).html(errorsHtml);
                        });
                        $('#submit-btn').html('Sign In');
                        $('#submit-btn').attr('disabled', false);
                    }
                });
            }
        });
    </script>
@endpush
