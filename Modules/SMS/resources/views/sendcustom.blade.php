
@extends('layouts.manage')
@section('title', 'Send Custom Sms')

@push('css-links')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
    <h3>Send Custom Sms</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Send Custom Sms</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card">
                    <form method="post" class="send-custom-form" action="{{ route('manage.sms.fire.custom.sms') }}">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="form-group col-md-12">
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="acc_type" id="btnradio1" autocomplete="off" checked="true" value="1">
                                        <label class="btn btn-outline-primary" for="btnradio1">Self Apply</label>
                                        <input type="radio" class="btn-check" name="acc_type" id="btnradio2" autocomplete="off" value="2">
                                        <label class="btn btn-outline-primary" for="btnradio2">Loan Agent</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label for=""><strong>Target Customer</strong></label>
                                    <div id="self-apply-options">
                                        <div class="form-check">
                                            <input class="form-check-input" id="flexRadioDefault1" type="radio" value="1_0" name="target_customer" checked="true">
                                            <label class="form-check-label" for="flexRadioDefault1">Test SMS</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="flexRadioDefault16" type="radio" value="1_4" name="target_customer">
                                            <label class="form-check-label" for="flexRadioDefault16">Process Step 4 - Users In Leads</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="flexRadioDefault2" type="radio" value="1_5" name="target_customer">
                                            <label class="form-check-label" for="flexRadioDefault2">Process Step 5 - Personalized Offers</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="flexRadioDefault3" type="radio" value="1_6" name="target_customer">
                                            <label class="form-check-label" for="flexRadioDefault3">Process Step 6 - Service Closed</label>
                                        </div>
                                    </div>
                                    <div id="loan-agent-options" style="display:none">
                                        <div class="form-check">
                                            <input class="form-check-input" id="flexRadioDefault4" type="radio" value="2_0" name="target_customer_la" checked="true">
                                            <label class="form-check-label" for="flexRadioDefault4">Test SMS</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="flexRadioDefault17" type="radio" value="2_4" name="target_customer_la">
                                            <label class="form-check-label" for="flexRadioDefault17">Process Step 4 - Users In Leads</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="flexRadioDefault5" type="radio" value="2_5" name="target_customer_la">
                                            <label class="form-check-label" for="flexRadioDefault5">Process Step 5 - Personalized Offers</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="flexRadioDefault6" type="radio" value="2_6" name="target_customer_la">
                                            <label class="form-check-label" for="flexRadioDefault6">Process Step 6, 7 & 8 - Service Calls</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="flexRadioDefault7" type="radio" value="2_9" name="target_customer_la">
                                            <label class="form-check-label" for="flexRadioDefault7">Process Step 9 - Initiated Calls</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="flexRadioDefault8" type="radio" value="2_10" name="target_customer_la">
                                            <label class="form-check-label" for="flexRadioDefault8">Process Step 10 - Other Calls</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="flexRadioDefault9" type="radio" value="2_11" name="target_customer_la">
                                            <label class="form-check-label" for="flexRadioDefault9">Process Step 11 - Service Closed</label>
                                        </div>
                                    </div>
                                    @component('components.ajax-error',['field'=>'target_customer'])@endcomponent
                                </div>
                                
                                <div class="col-md-12">
                                    <h6>Total No. of Users :-  <span id="userCounts">0</span></h6><br/>
                                    <button class="btn btn-sm btn-outline-primary" type="button" id="getcounts">Get User Counts</button>    
                                </div>
                                
                                <div class="col-md-12">
                                    <label for="descriptions">Message <span class="text-danger">*</span></label>
                                    <textarea name="description" id="descriptions" cols="30" rows="10" class="form-control"></textarea>
                                    @component('components.ajax-error',['field'=>'description'])@endcomponent
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-success custom-btn">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-src')
@endpush
@push('script-tag')
<script>
    document.querySelectorAll('input[name="acc_type"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.getElementById('self-apply-options').style.display = 'none';
            document.getElementById('loan-agent-options').style.display = 'none';
    
            if (this.value === '1') {
                document.getElementById('self-apply-options').style.display = 'block';
            } else if (this.value === '2') {
                document.getElementById('loan-agent-options').style.display = 'block';
            }
        });
    });
    
    $('.send-custom-form').submit(function (event) {
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
                    $('#custom-btn').html('<span class="spinner-border spinner-border-sm"></span> Send');
                    $('#custom-btn').attr('disabled', true);
                },
                success: function (result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        window.location.reload();
                    } else {
                        toastr.error(result.message);
                        $('#custom-btn').html('Send');
                        $('#custom-btn').attr('disabled', false);
                    }
                },
                error: function (error) {
                    $(this).attr("disabled", false);
                    let errors = error.responseJSON.errors, errorsHtml = '';
                    $.each(errors, function (key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    $('#custom-btn').html('Send');
                    $('#custom-btn').attr('disabled', false);
                }
            });
        }
    });
    
    /* get user counts */
    $('#getcounts').on('click', function () {
        let value = $('input[name="acc_type"]:checked').val();
    
        let product = (value == 1) ? 'target_customer' 
                    : (value == 2) ? 'target_customer_la' 
                    : 'target_customer_lat';
    
        let targetVal = $(`input[name="${product}"]:checked`).val();
    
        if (targetVal) {
            $.ajax({
                url: `{{ route('manage.sms.user.counts') }}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                data: { 'process':targetVal },
                success: function (result) {
                    if (result.type === 'SUCCESS') {
                        $('#userCounts').text(result.message);            
                    } else {
                        toastr.error(result.message);
                    }
                }
            });
            
        } else {
            console.log("No radio button selected");
        }
    });

</script>
@endpush
