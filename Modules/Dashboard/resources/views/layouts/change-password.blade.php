@extends('layouts.manage')
@section('title','Change Password')

@push('css-links')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
    <h3>Change Password</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('manage.dashboard') }}" class="text-decoration-none color-2f2f3b">Dashboard</a></li>
    <li class="breadcrumb-item active">Change Password</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                <div class="card height-equal">
                    <div class="card-body">
                        <form class="row g-3 needs-validation custom-input update-password-form" id="update-password-form" novalidate="" method="post" action="{{ route('manage.updatePassword') }}">
                            @csrf
                            <div class="col-12">
                                <label class="form-label" for="old_password">Old Password</label>
                                <input type="password" class="form-control " id="old_password" name="old_password" required="">
                                @component('components.ajax-error',['field'=>'old_password'])@endcomponent
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="new_password">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required="">
                                @component('components.ajax-error',['field'=>'new_password'])@endcomponent
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="new_password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required="">
                                @component('components.ajax-error',['field'=>'new_password_confirmation'])@endcomponent
                            </div>
                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary" name="changePasswordBtn">Change Password</button>
                            </div>
                        </form>
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
                            toastr.success(result.message)
                            setTimeout(()=>{
                                window.location.href = '{{ route("manage.dashboard") }}'
                            },3000)
                        } else {
                            toastr.error(result.message)
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
