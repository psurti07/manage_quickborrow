@extends('layouts.manage')
@section('title', 'SMS Settings')

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
<h3>SMS Settings</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
<li class="breadcrumb-item active">SMS Settings</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">SMS Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <form method="post" action="{{ route('manage.sms.settings.update') }}" class="sa-sms-senderid-settings" id="sa-sms-senderid-settings">
                                <input type="hidden" name="slug" value="sa-senderid">
                                <div class="form-group">
                                    <label for="sa-senderid">Self Apply Sender ID - Remarketing<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control" id="sa-senderid" name="sa-senderid" type="text" value="{{ $options[0]['content'] }}">
                                        <button class="btn btn-outline-secondary" data-bs-original-text="sa-senderid-btn" id="sa-senderid-btn" type="submit">Update</button>
                                    </div>
                                    @component('components.ajax-error',['field'=>'sa-senderid'])@endcomponent
                                </div>
                            </form>
                            <form method="post" action="{{ route('manage.sms.settings.update') }}" class="sa-sms-senderid-otp-settings" id="sa-sms-senderid-otp-settings">
                                <input type="hidden" name="slug" value="sa-senderid-otp">
                                <div class="form-group">
                                    <label for="sa-senderid-otp">Self Apply Sender ID - OTP<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control" id="sa-senderid-otp" name="sa-senderid-otp" type="text" value="{{ $options[3]['content'] }}">
                                        <button class="btn btn-outline-secondary" data-bs-original-text="sa-senderid-otp-btn" id="sa-senderid-otp-btn" type="submit">Update</button>
                                    </div>
                                    @component('components.ajax-error',['field'=>'sa-senderid-otp'])@endcomponent
                                </div>
                            </form>
                            <form method="post" action="{{ route('manage.sms.settings.update') }}" class="la-sms-senderid-settings" id="la-sms-senderid-settings">
                                <input type="hidden" name="slug" value="la-senderid">
                                <div class="form-group">
                                    <label for="la-senderid">Loan Agent Sender ID - Remarketing<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control" id="la-senderid" name="la-senderid" type="text" value="{{ $options[1]['content'] }}">
                                        <button class="btn btn-outline-secondary" data-bs-original-text="la-senderid-btn" id="la-senderid-btn" type="submit">Update</button>
                                    </div>
                                    @component('components.ajax-error',['field'=>'la-senderid'])@endcomponent
                                </div>
                            </form>
                            <form method="post" action="{{ route('manage.sms.settings.update') }}" class="la-sms-senderid-otp-settings" id="la-sms-senderid-otp-settings">
                                <input type="hidden" name="slug" value="la-senderid-otp">
                                <div class="form-group">
                                    <label for="la-senderid-otp">Loan Agent Sender ID - OTP<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control" id="la-senderid-otp" name="la-senderid-otp" type="text" value="{{ $options[4]['content'] }}">
                                        <button class="btn btn-outline-secondary" data-bs-original-text="la-senderid-otp-btn" id="la-senderid-otp-btn" type="submit">Update</button>
                                    </div>
                                    @component('components.ajax-error',['field'=>'la-senderid-otp'])@endcomponent
                                </div>
                            </form>
                            
                            <form method="post" action="{{ route('manage.sms.settings.update') }}" class="common-sms-senderid-settings" id="common-sms-senderid-settings">
                                <input type="hidden" name="slug" value="common-senderid">
                                <div class="form-group">
                                    <label for="common-senderid">Common Sender ID<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control" id="common-senderid" name="common-senderid" type="text" value="{{ $options[2]['content'] }}">
                                        <button class="btn btn-outline-secondary" data-bs-original-text="common-senderid-btn" id="common-senderid-btn" type="submit">Update</button>
                                    </div>
                                    @component('components.ajax-error',['field'=>'common-senderid'])@endcomponent
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
    $(document).on('submit', '#sa-sms-senderid-settings, #sa-sms-senderid-otp-settings, #la-sms-senderid-settings, #la-sms-senderid-otp-settings, #lat-sms-senderid-otp-settings, #lat-sms-senderid-settings, #common-sms-senderid-settings', function (event) {
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
