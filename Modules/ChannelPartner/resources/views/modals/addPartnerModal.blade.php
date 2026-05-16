<div class="modal fade" id="addChannelPartner" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{route('manage.channelpartner.store')}}" class="save-channel-partner-form" id="save-channel-partner-form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Channel Partner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input type="hidden" value="{{ date('Y-m-d H:i:s') }}" name="rec_date">
                <div class="modal-body">
                    <h6 class="badge badge-warning">Personal Details</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="first_name">First Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="First Name"/>
                            @component('components.ajax-error',['field'=>'first_name'])@endcomponent
                        </div>
                        <div class="col-md-4">
                            <label for="last_name">Last Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="Last Name"/>
                            @component('components.ajax-error',['field'=>'last_name'])@endcomponent
                        </div>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-md-4">
                            <label for="email">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Email" autocomplete="off"/>
                            @component('components.ajax-error',['field'=>'email'])@endcomponent
                        </div>
                        <div class="col-md-4">
                            <label for="mobile">Mobile<span class="text-danger">*</span></label>
                            <input type="tel" class="form-control numeric-input" name="mobile" maxlength="10" minlength="10" id="mobile" value="{{ old('mobile') }}" placeholder="Mobile"/>
                            @component('components.ajax-error',['field'=>'mobile'])@endcomponent
                        </div>
                        <div class="col-md-4">
                            <label for="password">Password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}" placeholder="Password" autocomplete="off"/>
                            @component('components.ajax-error',['field'=>'password'])@endcomponent
                        </div>
                    </div>
                    <hr/>
                    <h6 class="badge badge-danger">Company Details</h6>
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label for="company_code">Company Code<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="company_code" id="company_code" readonly value="{{ random_code_num(4) }}"/>
                        </div>
                        <div class="col-md-6">
                            <label for="company_name">Company Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="company_name" id="company_name" value="{{ old('company_name') }}" placeholder="Company Name"/>
                            @component('components.ajax-error',['field'=>'company_name'])@endcomponent
                        </div>
                        <div class="col-md-4">
                            <label for="phone">Company Mobile<span class="text-danger">*</span></label>
                            <input type="tel" class="form-control numeric-input" name="phone" maxlength="10" minlength="10" id="phone" value="{{ old('phone') }}" placeholder="Company Mobile"/>
                            @component('components.ajax-error',['field'=>'phone'])@endcomponent
                        </div>
                        <div class="col-md-4">
                            <label for="city">City<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="city" id="city" value="{{ old('city') }}" placeholder="City"/>
                            @component('components.ajax-error',['field'=>'city'])@endcomponent
                        </div>
                        <div class="col-md-4">
                            <label for="state">State<span class="text-danger">*</span></label>
                            <select class="form-select" name="state" id="state">
                                <option value="">Select State</option>
                                {!! getStateOption(old('state')) !!}
                            </select>
                            @component('components.ajax-error',['field'=>'state'])@endcomponent
                        </div>
                        <div class="col-md-4">
                            <label for="pincode">Pincode<span class="text-danger">*</span></label>
                            <input type="text" class="form-control numeric-input" name="pincode" id="pincode" value="{{ old('pincode') }}" placeholder="Pincode" maxlength="6" minlength="6"/>
                            @component('components.ajax-error',['field'=>'pincode'])@endcomponent
                        </div>
                        <div class="col-md-4">
                            <label for="website">Website<span class="text-danger">*</span></label>
                            <input type="url" class="form-control" name="website" id="website" value="{{ old('website') }}" placeholder="Website"/>
                            @component('components.ajax-error',['field'=>'website'])@endcomponent
                        </div>
                        <div class="col-md-4">
                            <label for="vat_gst_no">GST No<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="vat_gst_no" id="vat_gst_no" value="{{ old('vat_gst_no') }}" placeholder="GST No"/>
                            @component('components.ajax-error',['field'=>'vat_gst_no'])@endcomponent
                        </div>
                        <div class="col-md-8">
                            <label for="address">Address<span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="5" name="address" id="address">{{ old('address') }}</textarea>
                            @component('components.ajax-error',['field'=>'address'])@endcomponent
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="account-btn" class="btn btn-outline-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        const channelPartnerDetailsUrl = @json(route('manage.channelpartner.details', ['id' => '__ID__']));

        $('.save-channel-partner-form').submit(function (event) {
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
                        $('#account-btn').html('<span class="spinner-border spinner-border-sm"></span> Add');
                        $('#account-btn').attr('disabled', true);
                    },
                    success: function (result) {
                        $(this).attr("disabled", false);
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            let redirectUrl = channelPartnerDetailsUrl.replace('__ID__', result.data);
                            window.location.href = redirectUrl;
                        } else {
                            toastr.error(result.message);
                            $('#account-btn').html('Add');
                            $('#account-btn').attr('disabled', false);
                        }
                    },
                    error: function (error) {
                        $(this).attr("disabled", false);
                        let errors = error.responseJSON.errors, errorsHtml = '';
                        $.each(errors, function (key, value) {
                            errorsHtml = '<strong>' + value[0] + '</strong>';
                            $('.' + key).html(errorsHtml);
                        });
                        $('#account-btn').html('Add');
                        $('#account-btn').attr('disabled', false);
                    }
                });
            }
        });
        $('.numeric-input').on('keydown', function(event) {
            if (!(event.key === 'Backspace' || event.key === 'Delete' || (event.key >= '0' && event.key <= '9'))) {
                event.preventDefault();
            }
        });
    });
</script>
