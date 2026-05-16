@extends('layouts.manage')
@section('title', 'Whatsapp Settings')

@push('css-links')
@endpush
@push('style-css')
<style>
    .custom-rounded {
        border-radius: 10px;
    }
</style>
@endpush

@section('breadcrumb-title')
<h3>Whatsapp Settings</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
<li class="breadcrumb-item active">Whatsapp Settings</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Self Apply Whatsapp Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <form method="post" action="{{ route('manage.whatsapp.settings.update') }}" class="sa-whatsapp-remarketing-settings" id="sa-whatsapp-remarketing-settings">

                                <input type="hidden" name="slug" value="sa-wp-remarketing">
                                <div class="form-group">
                                    <label for="sa-wp-remarketing">Whatsapp Remarketing<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control" id="sa-wp-remarketing" name="sa-wp-remarketing" type="text" value="{{ $options[0]['content'] }}">
                                        <button class="btn btn-outline-secondary" data-bs-original-text="sa-wp-remarketing-btn" id="sa-wp-remarketing-btn" type="submit">Update</button>
                                    </div>
                                    @component('components.ajax-error',['field'=>'sa-wp-remarketing'])@endcomponent
                                </div>
                            </form>
                            <form method="post" action="{{ route('manage.whatsapp.settings.update') }}" class="sa-whatsapp-getoffer-settings" id="sa-whatsapp-getoffer-settings">

                                <input type="hidden" name="slug" value="sa-wp-getoffer">
                                <div class="form-group">
                                    <label for="sa-wp-getoffer">Whatsapp Get Offer<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control" id="sa-wp-getoffer" name="sa-wp-getoffer" type="text" value="{{ $options[1]['content'] }}">
                                        <button class="btn btn-outline-secondary" id="sa-wp-getoffer-btn" type="submit">Update</button>
                                    </div>
                                    @component('components.ajax-error',['field'=>'sa-wp-getoffer'])@endcomponent
                                </div>
                            </form>
                            <form method="post" action="{{ route('manage.whatsapp.settings.update') }}" class="sa-whatsapp-payment-success-settings" id="sa-whatsapp-payment-success-settings">

                                <input type="hidden" name="slug" value="sa-wp-payment-success">
                                <div class="form-group">
                                    <label for="sa-wp-payment-success">Whatsapp Payment Success<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control" id="sa-wp-payment-success" name="sa-wp-payment-success" type="text" value="{{ $options[2]['content'] }}">
                                        <button class="btn btn-outline-secondary" id="sa-wp-payment-success-btn" type="submit">Update</button>
                                    </div>
                                    @component('components.ajax-error',['field'=>'sa-wp-payment-success'])@endcomponent
                                </div>
                            </form>
                            <form method="post" action="{{ route('manage.whatsapp.settings.update') }}" class="sa-whatsapp-username-password-settings" id="sa-whatsapp-username-password-settings">

                                <input type="hidden" name="slug" value="sa-wp-username-password">
                                <div class="form-group">
                                    <label for="sa-wp-username-password">Whatsapp Username Password<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control" id="sa-wp-username-password" name="sa-wp-username-password" type="text" value="{{ $options[3]['content'] }}">
                                        <button class="btn btn-outline-secondary" id="sa-wp-username-password-btn" type="submit">Update</button>
                                    </div>
                                    @component('components.ajax-error',['field'=>'sa-wp-username-password'])@endcomponent
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Loan Agent Whatsapp Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <form method="post" action="{{ route('manage.whatsapp.settings.update') }}" class="la-whatsapp-remarketing-settings" id="la-whatsapp-remarketing-settings">

                                <input type="hidden" name="slug" value="la-wp-remarketing">
                                <div class="form-group">
                                    <label for="la-wp-remarketing">Whatsapp Remarketing<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control" id="la-wp-remarketing" name="la-wp-remarketing" type="text"value="{{ $options[4]['content'] }}">
                                        <button class="btn btn-outline-secondary" id="la-wp-remarketing-btn" type="submit">Update</button>
                                    </div>
                                    @component('components.ajax-error',['field'=>'la-wp-remarketing'])@endcomponent
                                </div>
                            </form>
                            <form method="post" action="{{ route('manage.whatsapp.settings.update') }}" class="la-whatsapp-getoffer-settings" id="la-whatsapp-getoffer-settings">

                                <input type="hidden" name="slug" value="la-wp-getoffer">
                                <div class="form-group">
                                    <label for="la-wp-getoffer">Whatsapp Get Offer<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control" id="la-wp-getoffer" name="la-wp-getoffer" type="text" value="{{ $options[5]['content'] }}">
                                        <button class="btn btn-outline-secondary" id="la-wp-getoffer-btn" type="submit">Update</button>
                                    </div>
                                    @component('components.ajax-error',['field'=>'la-wp-getoffer'])@endcomponent
                                </div>
                            </form>
                            <form method="post" action="{{ route('manage.whatsapp.settings.update') }}" class="la-whatsapp-payment-success-settings" id="la-whatsapp-payment-success-settings">

                                <input type="hidden" name="slug" value="la-wp-payment-success">
                                <div class="form-group">
                                    <label for="la-wp-payment-success">Whatsapp Payment Success<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control" id="la-wp-payment-success" name="la-wp-payment-success" type="text" value="{{ $options[6]['content'] }}">
                                        <button class="btn btn-outline-secondary" id="la-wp-payment-success-btn" type="submit">Update</button>
                                    </div>
                                    @component('components.ajax-error',['field'=>'la-wp-payment-success'])@endcomponent
                                </div>
                            </form>
                            <form method="post" action="{{ route('manage.whatsapp.settings.update') }}" class="la-whatsapp-username-password-settings" id="la-whatsapp-username-password-settings">

                                <input type="hidden" name="slug" value="la-wp-username-password">
                                <div class="form-group">
                                    <label for="la-wp-username-password">Whatsapp Username Password<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control" id="la-wp-username-password" name="la-wp-username-password" type="text" value="{{ $options[7]['content'] }}">
                                        <button class="btn btn-outline-secondary" id="la-wp-username-password-btn" type="submit">Update</button>
                                    </div>
                                    @component('components.ajax-error',['field'=>'la-wp-username-password'])@endcomponent
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
    $(document).on('submit', '#sa-whatsapp-remarketing-settings, #sa-whatsapp-getoffer-settings, #sa-whatsapp-payment-success-settings, #sa-whatsapp-username-password-settings, #la-whatsapp-remarketing-settings, #la-whatsapp-getoffer-settings, #la-whatsapp-payment-success-settings, #la-whatsapp-username-password-settings', function (event) {
        event.preventDefault();

        var form = $(this);
        var submitButton = form.find('button[type="submit"]'); // Get the submit button inside the form

        var data = new FormData(this);

        $.ajax({
            url: form.attr("action"),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            beforeSend: function () {
                submitButton.data('original-text', submitButton.html()); // Store original text
                submitButton.html('<span class="spinner-border spinner-border-sm"></span> Updating...').attr('disabled', true);
            },
            success: function (result) {
                submitButton.attr('disabled', false);
                if (result.type === 'SUCCESS') {
                    toastr.success(result.message);
                    window.location.reload();
                } else {
                    toastr.error(result.message);
                    submitButton.html(submitButton.data('original-text')).attr('disabled', false);
                }
            },
            error: function (error) {
                let errors = error.responseJSON.errors;
                let errorsHtml = '';
                $.each(errors, function (key, value) {
                    errorsHtml = '<strong>' + value[0] + '</strong>';
                    $('.' + key).html(errorsHtml);
                });

                submitButton.html(submitButton.data('original-text')).attr('disabled', false);
            }
        });
    });



</script>
@endpush
