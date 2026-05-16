@extends('layouts.manage')
@section('title', 'Self Apply Application Details')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
    <style>
        .swal-title{font-size:20px!important;}
        .bg-danger.bg-lighten-4 { background-color: #FFC8D0 !important; }
        .bg-info.bg-lighten-4 { background-color: #BCE2FB !important; }
        .bg-success.bg-lighten-4 { background-color: #BFF1DF !important; }
        .bg-warning.bg-lighten-4 { background-color: #FFDEC8 !important; }
        .fs-14{font-size:14px!important;}
    </style>
@endpush

@section('breadcrumb-title')
    <h3>Self Apply Application Details</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Self Apply Application Details</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <!-- Personal Details -->
            <div class="col-xl-6 col-sm-12">
                <div class="card user-bio">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="ttl-info text-start">
                                    <p><b>Personal Details :</b></p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="ttl-info text-start">
                                    <h6 class="fw-normal fs-14">Name</h6>
                                    <span><a href="{{ route('manage.selfapply.customer.details',['userId'=>$data->id]) }}">{{ $data->first_name.' '.$data->last_name }}</a></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="ttl-info text-start">
                                    <h6 class="fw-normal fs-14">Mobile</h6>
                                    <span>{{ $data->mobile }}</span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="ttl-info text-start">
                                    <h6 class="fw-normal fs-14">Email</h6>
                                    <span>{{ $data->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Agent Details -->
            <div class="col-xl-6 col-sm-12">
                <div class="card user-bio">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="ttl-info text-start">
                                    <p><b>Agent Details :</b></p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="ttl-info text-start">
                                    <h6 class="fw-normal fs-14">Agent Name</h6>
                                    <span>{{ $agentDetails->fullname ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="ttl-info text-start">
                                    <h6 class="fw-normal fs-14">Agent Mobile</h6>
                                    <span>{{ ($agentDetails && $agentDetails->mobile) ? '+91 '.trim(chunk_split($agentDetails->mobile,'5',' ')) : 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="ttl-info text-start">
                                    <h6 class="fw-normal fs-14">Agent Email</h6>
                                    <span>{{ $agentDetails->emailid ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Loan Details -->
            <div class="col-xl-6 col-md-12 col-sm-12">
                <div class="card">
                    @php $appdetails = $data->loanApplications[0]; @endphp
                    <div class="card-body">
                        <div class="row">
                            <p><b>Loan Details :</b></p>
                            <dl class="row">
                                <dd class="col-md-4">Loan Date</dd>
                                <dt class="col-md-8">{{ displayDate($appdetails->rec_date) }}</dt>
                            </dl>
                            <hr/>
                            <dl class="row">
                                <dd class="col-md-4">Loan Type</dd>
                                <dt class="col-md-8">{{ $appdetails->loan_type == 1 ? 'Personal Loan' : 'Business Loan' }}</dt>
                            </dl>
                            <hr/>
                            <dl class="row">
                                <dd class="col-md-4">Loan Amount</dd>
                                <dt class="col-md-8">{{ formatePriceIndia($appdetails->loan_amount) }}</dt>
                            </dl>
                            <hr/>
                            <dl class="row">
                                <dd class="col-md-4">Loan Purpose :</dd>
                                <dt class="col-md-8">{{ $appdetails->loan_purpose }}</dt>
                            </dl>
                            <hr/>
                            <dl class="row">
                                <dd class="col-md-4">Income :</dd>
                                <dt class="col-md-8">{{ formatePriceIndia($appdetails->monthly_income) }}</dt>
                            </dl>
                            <hr/>
                            <dl class="row">
                                <dd class="col-md-4">Current EMI :</dd>
                                <dt class="col-md-8">{{ formatePriceIndia($appdetails->currentemi) }}</dt>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Approved Offers -->
            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body pt-30">
                        <div class="ttl-info text-start">
                            <p><b>Approved Offers :</b></p>
                        </div>
                        <div class="recent-table table-responsive currency-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="f-light">Bank Logo</th>
                                        <th class="f-light">Bank Name</th>
                                        <th class="f-light">Loan Amount</th>
                                        <th class="f-light">Max Tenure<br/><small>(Best Rate)</small></th>
                                        <th class="f-light text-center">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($offers)
                                        @foreach($offers as $offer)
                                        <tr>
                                            <td>         
                                                <img src="{{ asset('upload/banks/'.$offer->bank_image) }}" width="80">
                                            </td>
                                            <td>
                                                <div>
                                                    <h6 class="f-14 mb-0 f-w-400">{{ $offer->bank_name }}</h6>
                                                </div>
                                            </td>
                                            <td>₹{{ formatePriceIndia($offer->loanAmount) }}</td>
                                            <td>{{ $offer->tenures }} Months<br/><small>({{ $offer->roi }}%)</small></td>
                                            <td class="text-center">
                                                <a href="javascript:;" onclick="openCountsModal({{ $offer->apply_id }}, {{ $data->id }}, {{ $offer->bankid }})" id="appInfo" class="appInfo-ClickCounts" data-bs-original-title="" title="">
                                                    <span class="icon-info-alt"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4"><p class=text-center>Currently not any offers.</p></tr>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="row g-3">
                    <div class="col-md-3 text-start">
                        <a href="{{ route('manage.selfapply.loan.application.download.report',['userid'=>$data->id,'appid'=>$appdetails->id]) }}" 
                            class='btn btn-outline-dark m-l-5 m-r-5'>
                            <i class="fa fa-download"></i>&nbsp;Download Report
                        </a>
                    </div>
                    <div class="col-md-9 text-end">
                        @if($data->process_step == 4 && $data->isUser == 2)
                        <a href="javascript:;" class="btn btn-outline-success m-l-5 m-r-5" id="updProcessBtn" onclick="updProcessStep({{ $data->id }},{{ $appdetails->id }})"> <i class="fa fa-upload"></i>&nbsp;Update Process Step 5 </a>
                        @endif
                        <a href="{{ url('/selfapply/applications-details/verified-account/'.$appdetails->id) }}" class="btn btn-outline-success m-l-5 m-r-5" id="verifiedBtn"> <i class="fa fa-check"></i>&nbsp;Verified </a>
                        <a href="{{ url('/selfapply/applications-details/close-account/'.$appdetails->id) }}" class="btn btn-outline-danger m-l-5 m-r-5" id="closeBtn"> <i class="fa fa-times"></i>&nbsp;Closed </a>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered loan-status-table" id="loan-status-table" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>DateTime</th>
                                            <th>Service</th>
                                            <th>Subject</th>
                                            <th>Staff Name</th>
                                            <th>Notes</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($remarks  as $remark)
                                                @php
                                                switch($remark->service){
                                                    case 5:
                                                        $service = 'PDF Sent';
                                                        break;
                                                    case 6:
                                                        $service = 'Service Closed';
                                                        break;
                                                    default:
                                                        $service = 'N/A';
                                                        break;
                                                }
                                                @endphp
                                                <tr class="">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ date('d-m-Y H:i:s', strtotime($remark->entry_at)) }}</td>
                                                    <td>{{ $service }}</td>
                                                    <td>{{ $remark->title }}</td>
                                                    <td>{{ $remark->fullname }}</td>
                                                    <td>{{ $remark->notes }}</td>
                                                    <td class="text-center"><a href="javascript:;" onclick="deleteRemark({{ $remark->id }})"><i class="text-danger fa fa-trash"></i></a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clickCountsModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush

@push('script-tag')
<script>
    $("#loan-status-table").DataTable({});
    /* click counts scripts start */
    function openCountsModal(applyId, userId, bankId){
        $.ajax({
            url: "{!! route('manage.selfapply.customers.offers.click.count') !!}",
            type: 'POST',
            data:  JSON.stringify({applyId: applyId, userId: userId, bankId: bankId}),
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.clickCountsModals').html(result);
                $('#clickCountsModal').modal('show');
            }
        });
    }
    
    function deleteRemark(remarks_id){
        swal({
            title: "Are you sure?",
            text: "You want to delete this remark.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel","Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: 'https://manage.easyailoans.com/selfapply/applications-details/delete-remarks',
                    type: 'POST',
                    data:  JSON.stringify({id: remarks_id}),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            window.location.reload();
                        }
                    }
                });
            }
        });
    }
    
    function updProcessStep(userId, appId){
        swal({
            title: "Are you sure?",
            text: "You want to update process step.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel","Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: 'https://manage.easyailoans.com/selfapply/applications-details/update-process',
                    type: 'POST',
                    data:  JSON.stringify({id: userId, appid: appId}),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            window.location.reload();
                        }
                    }
                });
            }
        });
    }
</script>
@endpush