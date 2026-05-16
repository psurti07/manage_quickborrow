@extends('layouts.manage')
@section('title', 'Application Status')

@push('css-links')
@endpush
@push('style-css')
    <style>
        .swal-title { font-size:14px!important}
    </style>
@endpush

@section('breadcrumb-title')
    <h3>Application Status</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Application Status</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-12 text-end">
                <button type="button" class="btn btn-outline-light text-dark" onclick="window.history.back()"><span class="icon icon-arrow-left"></span>&nbsp;Back</button>
            </div>
            @php
                $name = request()->segment(3);
                switch($name){
                    case 'verified-account':
                        $process = 5;
                        $isVerified = 1;
                        break;
                    case 'close-account':
                        $process = 6;
                        break;
                    default :
                        $process = 6;
                        break;
                }
            @endphp
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <form method="post" class="application-status-form needs-validation custom-input" novalidate="" id="application-status-form" action="{{ route('manage.selfapply.loan.applications.store.remarks') }}">
                            <input type="hidden" name="process" value="{{ $process }}">
                            @if($name == 'verified-account')
                            <input type="hidden" name="isVerified" value="{{ $isVerified }}">
                            @endif
                            <input type="hidden" name="userid" value="{{ $appdetails->userid }}">
                            <input type="hidden" name="usermobile" value="{{ $appdetails->mobile }}">
                            <div class="row g-3">
                                <small>Fill the information to continue.</small>
                                <div class="col-md-6">
                                    <label>Application No - </label>
                                    <span class="fw-bold">{{ $appdetails->id }}</span>
                                    <input type="hidden" name="applicationid" value="{{ $appdetails->id }}">
                                </div>
                                <div class="col-md-6">
                                    <label>Customer Name - </label>
                                    <span class="fw-bold">{{ $appdetails->first_name.' '.$appdetails->last_name }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label>Loan Type - </label>
                                    <span class="fw-bold">{{ $appdetails->loan_type == 1 ? 'Personal Loan' : 'Business Loan' }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label>Loan Amount - </label>
                                    <span class="fw-bold">&#8377; {{ formatePriceIndia($appdetails->loan_amount) }}</span>
                                </div>
                                <hr/>
                                
                                <div class="col-md-4">
                                    <label for="entry_at">Entry Date</label>
                                    <input class="form-control digits" name="entry_at" id="example-datetime-local-input" type="datetime-local" value="{{ date('Y-m-d H:i') }}">
                                </div>
                                <div class="col-md-8">
                                    <label for="subject">Subject<span class="text-danger">*</span></label>
                                    <select class="form-select" id="subject" name="subject">
                                        <option value="" selected>Select Subject</option>
                                        @foreach($loanRemarks as $remark)
                                        <option value="{{ $remark->id }}">{{ $remark->title }}</option>
                                        @endforeach
                                    </select>
                                    @component('components.ajax-error',['field'=>'subject'])@endcomponent
                                </div>
                                <div class="col-md-12">
                                    <div id="message"></div>
                                </div>
                                <div class="col-md-12">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" name="notes" id="notes" rows="5"></textarea>
                                </div>
                                <hr/>
                                <div class="col-md-12 text-end">
                                    <button type="submit" id="submit-btn" class="btn btn-outline-success btn-min-width">SEND</button>
                                </div>
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
$(document).ready(function(){
    $("#subject").on('change', function(){
        let titleVal = $(this).val();
        let staff = `{{$staff ?? '9429214352'}}`;
        if(titleVal){
            $.ajax({
                url: `{{ route('manage.loanagent.application.status.title') }}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                data: { title: titleVal,staff:staff },
                success: function (result) {
                    if (result.type === 'SUCCESS') {
                        // HTML decode function
                        function htmlDecode(input) {
                            var e = document.createElement('textarea');
                            e.innerHTML = input;
                            return e.value;
                        }

                        // Decode and insert
                        const decodedMessage = htmlDecode(result.message);
                        $("#message").html(decodedMessage);
                        
                        // Apply style to any <textarea> inside #message
                        $("#message").css({
                            "padding": "6px 12px",
                            "background-color": "#ffffff",
                            "border": "1px solid #ced4da",
                            "border-radius": "5px"
                        });
                    } else {
                        toastr.error(result.message);
                    }
                },
            });
        }
    })
})

$('.application-status-form').submit(function(){
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
                    toastr.success(result.message);
                    let applicationId = result.data;
                    let url = 'https://manage.easyailoans.com/selfapply/applications-details/:userId';
                    url = url.replace(':userId', applicationId);
                    setTimeout(function(){
                        window.location.href = url;
                    },2000)
                } else {
                    toastr.error(result.message);
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
})
</script>
@endpush
