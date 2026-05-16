@extends('layouts.manage')
@section('title', 'Create An Account')

@push('css-links')
@endpush
@push('style-css')
<style>
    .swal-title {
        font-size: 20px
    }
</style>
@endpush

@section('breadcrumb-title')
<h3>Create An Account</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
<li class="breadcrumb-item active">Create An Account</li>
@endsection

@section('content')
<div class="container-fluid">
    <form method="post" action="{{ route('manage.create.account.store') }}" class="create-account-form" id="create-account-form">
        <div class="row g-3">
            <div class="col-sm-12 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-b-0">Personal Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- rec date --}}
                            <div class="form-group col-md-6">
                                <label for="rec_date">Registration Date<span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" name="rec_date" id="rec_date" value="{{ old('rec_date') ?? now()->format('Y-m-d\TH:i:s') }}" max="{{ now()->format('Y-m-d\TH:i:s') }}">
                                @component('components.ajax-error',['field'=>'rec_date'])@endcomponent
                            </div>
                            {{-- acc type --}}
                            <div class="form-group col-md-12">
                                <label for="acc_type">Account Type<span class="text-danger">*</span></label><br />
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="acc_type" id="btnradio1" autocomplete="off" checked="true" value="1">
                                    <label class="btn btn-outline-primary" for="btnradio1">Self Apply</label>
                                    <input type="radio" class="btn-check" name="acc_type" id="btnradio2" autocomplete="off" value="2">
                                    <label class="btn btn-outline-primary" for="btnradio2">Loan Agent</label>
                                </div>
                                @component('components.ajax-error',['field'=>'acc_type'])@endcomponent
                            </div>
                            {{-- first name --}}
                            <div class="form-group col-md-6">
                                <label for="first_name">First Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}">
                                @component('components.ajax-error',['field'=>'first_name'])@endcomponent
                            </div>
                            {{-- last name --}}
                            <div class="form-group col-md-6">
                                <label for="last_name">Last Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}">
                                @component('components.ajax-error',['field'=>'last_name'])@endcomponent
                            </div>
                            {{-- mobile --}}
                            <div class="form-group col-md-6">
                                <label for="mobile">Mobile<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="mobile" id="mobile" value="{{ old('mobile') }}" maxlength="10" minlength="10">
                                @component('components.ajax-error',['field'=>'mobile'])@endcomponent
                            </div>
                            {{-- email --}}
                            <div class="form-group col-md-6">
                                <label for="email">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                                @component('components.ajax-error',['field'=>'email'])@endcomponent
                            </div>
                            {{-- pincode --}}
                            <div class="form-group col-md-6">
                                <label for="pincode">Pincode<span class="text-danger">*</span></label>
                                <input type="text" class="form-control numeric-input" name="pincode" id="pincode" value="{{ old('pincode') }}" maxlength="6" minlength="6">
                                @component('components.ajax-error',['field'=>'pincode'])@endcomponent
                            </div>
                            {{-- city --}}
                            <div class="form-group col-md-6">
                                <label for="city">City<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="city" id="city" value="{{ old('city') }}">
                                @component('components.ajax-error',['field'=>'city'])@endcomponent
                            </div>
                            {{-- state --}}
                            <div class="form-group col-md-6">
                                <label for="state">State<span class="text-danger">*</span></label>
                                <select id="state" name="state" class="form-select mb-0" style="font-size:16px!important;">
                                    <option value="">Select State</option>
                                    {!! getStateOption(old('state')) !!}
                                </select>
                                @component('components.ajax-error',['field'=>'state'])@endcomponent
                            </div>
                            <span class="pincode-msg text-danger"></span>
                            {{-- is user --}}
                            <input type="hidden" class="form-control" name="isUser" value="2">
                            {{-- iagree --}}
                            <input type="hidden" class="form-control" name="iAgree" value="0">
                            {{-- process steps --}}
                            <input type="hidden" class="form-control" name="process_step" value="5">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="form-group col-md-4">
                                <label for="is_offer_user">Is Offer ?</label>
                                <select name="isOffer" id="isOffer" class="form-select">
                                    <option value="0">NO</option>
                                    <option value="1">YES</option>
                                </select>
                            </div>
                            <div class="form-group col-md-8">
                                <div id="offerDropdown"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Loan Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- loan type --}}
                            <div class="form-group col-md-12">
                                <label for="loan_type">Loan Type<span class="text-danger">*</span></label><br/>
                                <div class="btn-group" role="group" aria-label="Loan type">
                                    <input type="radio" class="btn-check" name="loan_type" id="btnradio11" autocomplete="off" checked="true" value="1">
                                    <label class="btn btn-outline-primary" for="btnradio11">Personal Loan</label>
                                    <input type="radio" class="btn-check" name="loan_type" id="btnradio12" autocomplete="off" value="2">
                                    <label class="btn btn-outline-primary" for="btnradio12">Business Loan</label>
                                </div>
                                @component('components.ajax-error',['field'=>'loan_type'])@endcomponent
                            </div>
                            {{-- user type --}}
                            <div class="form-group col-md-12">
                                <label for="user_type">User Type<span class="text-danger">*</span></label><br/>
                                <div class="btn-group" role="group" aria-label="User type">
                                    <input type="radio" class="btn-check" name="user_type" id="btnradio3" autocomplete="off" checked="true" value="1">
                                    <label class="btn btn-outline-primary" for="btnradio3">Salaried</label>
                                    <input type="radio" class="btn-check" name="user_type" id="btnradio4" autocomplete="off" value="2">
                                    <label class="btn btn-outline-primary" for="btnradio4">Self Employed</label>
                                    <input type="radio" class="btn-check" name="user_type" id="btnradio5" autocomplete="off" value="3">
                                    <label class="btn btn-outline-primary" for="btnradio5">Small Business</label>
                                    <input type="radio" class="btn-check" name="user_type" id="btnradio6" autocomplete="off" value="4">
                                    <label class="btn btn-outline-primary" for="btnradio6">Audited Business</label>
                                </div>
                                @component('components.ajax-error',['field'=>'user_type'])@endcomponent
                            </div>
                            {{-- loan amount --}}
                            <div class="form-group col-md-6">
                                <label for="loan_amount">Loan Amount<span class="text-danger">*</span></label>
                                <input type="number" class="form-control numeric-input" name="loan_amount" id="loan_amount" value="{{ old('loan_amount') ?? '500000' }}" max="5000000" min="100000" step="10000">
                                @component('components.ajax-error',['field'=>'loan_amount'])@endcomponent
                            </div>
                            {{-- monthly income --}}
                            <div class="form-group col-md-6">
                                <label for="monthly_income">Monthly Income<span class="text-danger">*</span></label>
                                <input name="monthly_income" id="monthly_income" class="form-control numeric-input" value="{{ old('monthly_income') }}">
                                @component('components.ajax-error',['field'=>'monthly_income'])@endcomponent
                            </div>
                            {{-- current emi --}}
                            <div class="form-group col-md-6">
                                <label for="currentemi">Current EMI<span class="text-danger">*</span></label>
                                <input name="currentemi" id="currentemi" class="form-control numeric-input" value="{{ old('currentemi') }}">
                                @component('components.ajax-error',['field'=>'currentemi'])@endcomponent
                            </div>
                            {{-- loan purpose --}}
                            <div class="form-group col-md-6">
                                <label for="loan_purpose">Loan Purpose<span class="text-danger">*</span></label>
                                <select class="form-select" name="loan_purpose" id="loan_purpose">
                                    <option value="">Select Loan Purpose</option>
                                    <option value="Personal Use">Personal Use</option>
                                    <option value="Property Renovation">Property Renovation</option>
                                    <option value="Marriage Purpose">Marriage Purpose</option>
                                    <option value="Education Purpose">Education Purpose</option>
                                    <option value="Business Purpose">Business Purpose</option>
                                    <option value="Medical Emergency">Medical Emergency</option>
                                </select>
                                @component('components.ajax-error',['field'=>'loan_purpose'])@endcomponent
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-b-0">Membership Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- Card Amount --}}
                            <div class="form-group col-md-6">
                                <label for="amount">Card Amount<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="amount" id="amount" value="{{ old('amount') }}">
                                @component('components.ajax-error',['field'=>'amount'])@endcomponent
                            </div>
                            {{-- Card Number --}}
                            <div class="form-group col-md-6">
                                <label for="card_number">Card Number<span class="text-danger">*</span></label>
                                <input type="text" class="form-control numeric-input" name="card_number" id="card_number" value="{{ old('card_number') ?? random_code_num(16) }}" minlength="16" maxlength="16">
                                @component('components.ajax-error',['field'=>'card_number'])@endcomponent
                            </div>
                            {{-- paymentId --}}
                            <div class="form-group col-md-6">
                                <label for="paymentid">Payment Id<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="paymentid" id="paymentid" value="{{ old('paymentid') ?? 'cash_'.random_code(13) }}">
                                @component('components.ajax-error',['field'=>'paymentid'])@endcomponent
                            </div>
                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn btn-lg btn-primary" id="create-account-btn">Create Account</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('script-src')
<script>
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
                    $(".pincode-msg").text('we are fetching cities and state..'); // Example: Show a loading indicator
                },
                success: function(response) {
                    $('#loader').hide(); // Hide loader
                    if (response.status === 'success') {
                        $(".pincode-msg").text('');
                        // Populate District and State fields
                        $('#city').val(response.district);
                        $('#state').val(response.state);
                    } else {
                        alert(response.message);
                        $(".pincode-msg").text('');
                        $('#district').val('');
                        $('#state').val('');
                    }
                },
                error: function() {
                    $('#loader').hide(); // Hide loader on error
                    $(".pincode-msg").text('');
                    alert('An error occurred while fetching the details.');
                }
            });
        } else {
            // Clear the fields if pincode length is not 6 digits
            $('#city').val('');
            $('#state').val('');
        }
    });
    $(".create-account-form").submit(function(event) {
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
                    $('#create-account-btn').html('<span class="spinner-border spinner-border-sm"></span> Create Account');
                    $('#create-account-btn').attr('disabled', true);
                },
                success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        window.location.reload();
                    } else {
                        toastr.error(result.message);
                        $('#create-account-btn').html('Create Account');
                        $('#create-account-btn').attr('disabled', false);
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
                    $('#create-account-btn').html('Create Account');
                    $('#create-account-btn').attr('disabled', false);
                }
            });
        }
    })

    /* OFFER PAGE DROPDOWN */
    $('#isOffer').on('change',function(){
        let offer = $(this).val();
        if(offer == 1){
            let html = `
                <label for="offerlist">Offer Page</label>
                <select class="form-select" id="offerlist" name="offerpage">
                    <option value="1">Great Deal Offer</option>
                    <option value="2">Elite Offer</option>
                    <option value="3">Ultra Saver Offer</option>
                    <option value="4">Prime Offer</option>
                    <option value="5">Mega Offer</option>
                    <option value="6">Premium Offer</option>
                    <option value="7">Star Offer</option>
                    <option value="8">Big Offer</option>
                    <option value="9">Great Offer</option>
                    <option value="10">Big Benefit Offer</option>
                    <option value="52">Top Offer</option>
                    <option value="53">Excel Offer</option>
                </select>
            `;
            $("#offerDropdown").html(html);
        } else {
            $("#offerDropdown").html('');
        }
    })
</script>
@endpush
@push('script-tag')
@endpush