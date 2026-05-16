<div class="modal fade" id="userDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Customer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 col-xs-12">
                        <div class="nav flex-column nav-pills nav-success" id="ver-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="ver-pills-customerInfo-tab" data-bs-toggle="pill" href="#ver-pills-customerInfo" role="tab" aria-controls="ver-pills-customerInfo" aria-selected="true">
                                <i class="icofont icofont-business-man-alt-1"></i>Customer Info
                            </a>
                            <a class="nav-link" id="ver-pills-kycDoc-tab" data-bs-toggle="pill" href="#ver-pills-kycDoc" role="tab" aria-controls="ver-pills-kycDoc" aria-selected="false"  tabindex="-1">
                                <i class="icofont icofont-file-document"></i>KYC Documents
                            </a>
                            <a class="nav-link" id="ver-pills-payoutDoc-tab" data-bs-toggle="pill" href="#ver-pills-payoutDoc" role="tab" aria-controls="ver-pills-payoutDoc" aria-selected="false" tabindex="-1">
                                <i class="icofont icofont-law-document"></i>Payout Documents
                            </a>
                            <a class="nav-link" id="ver-pills-membershipCard-tab" data-bs-toggle="pill" href="#ver-pills-membershipCard" role="tab" aria-controls="ver-pills-membershipCard" aria-selected="false" tabindex="-1">
                                <i class="icofont icofont-credit-card"></i>Membership Card
                            </a>
                            <a class="nav-link" id="ver-pills-applicationList-tab" data-bs-toggle="pill" href="#ver-pills-applicationList" role="tab" aria-controls="ver-pills-applicationList" aria-selected="false" tabindex="-1">
                                <i class="icofont icofont-file-document"></i>Application List
                            </a>
                             @if(false)
                            <a class="nav-link" id="ver-pills-referral-tab" data-bs-toggle="pill" href="#ver-pills-referral" role="tab" aria-controls="ver-pills-referral" aria-selected="false" tabindex="-1">
                                <i class="icofont icofont-share"></i>&nbsp;Referral Customer List
                            </a>
                            @endif
                            <a class="nav-link" id="ver-pills-actions-tab" data-bs-toggle="pill" href="#ver-pills-actions" role="tab" aria-controls="ver-pills-actions" aria-selected="false" tabindex="-1">
                                <i class="icofont icofont-gear"></i>Actions
                            </a>
                        </div>
                    </div>
                    <div class="col-md-9 col-xs-12">
                        <div class="tab-content" id="ver-pills-tabContent">
                            <div class="tab-pane fade show active" id="ver-pills-customerInfo" role="tabpanel" aria-labelledby="ver-pills-customerInfo-tab">
                                <form action="{{ route('manage.selfapply.customers.update') }}" method="post" class="customer-update-form" id="customer-update-form">
                                    <input type="hidden" name="userid" value="{{ $customerInfo->id }}">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <h6 class="fw-normal">Registration on: <b>{{ date('d-m-Y H:i', strtotime($customerInfo->rec_date)) }}</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="fw-normal">Referal Code: <b>{{ $customerInfo->refcode }}</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $customerInfo->first_name }}">
                                            @component('components.ajax-error',['field'=>'first_name'])@endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $customerInfo->last_name }}">
                                            @component('components.ajax-error',['field'=>'last_name'])@endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $customerInfo->email }}">
                                            @component('components.ajax-error',['field'=>'email'])@endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            <label for="mobile">Mobile</label>
                                            <input type="tel" inputmode="numeric" class="numeric-input form-control" maxlength="10" minlength="10" id="mobile" name="mobile" value="{{ $customerInfo->mobile }}">
                                            @component('components.ajax-error',['field'=>'mobile'])@endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            <label for="city">City</label>
                                            <input type="text" class="numeric-input form-control" id="city" name="city" value="{{ $customerInfo->city }}">
                                            @component('components.ajax-error',['field'=>'city'])@endcomponent
                                        </div>
                                        <div class="col-md-12 mt-3 text-end">
                                            <button type="submit" class="btn btn-outline-primary customersBtn" id="customersBtn" name="customersBtn">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="ver-pills-kycDoc" role="tabpanel" aria-labelledby="ver-pills-kycDoc-tab">
                                <p>No document uploaded</p>
                            </div>
                            <div class="tab-pane fade" id="ver-pills-payoutDoc" role="tabpanel" aria-labelledby="ver-pills-payoutDoc-tab">
                                <p>No document uploaded</p>
                            </div>
                            <div class="tab-pane fade" id="ver-pills-membershipCard" role="tabpanel" aria-labelledby="ver-pills-membershipCard-tab">
                                <div class="row">
                                    @if($membershipOrder != null)
                                        <div class="col-md-12 text-end mb-3"><a href="{{ route('manage.selfapply.customers.invoice', ['cardId' => $membershipOrder->id, 'userId' => $customerInfo->id]) }}" target="_blank" class="btn btn-success"><i class="icon icon-download"></i>&nbsp;Download Invoice</a></div>
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <tbody>
                                                    <tr>
                                                        <th class="fw-normal">Membership Type :</th>
                                                        <td class="fw-bold">SelfApply</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-normal">Full Name :</th>
                                                        <td class="fw-bold">{{ $customerInfo->first_name.' '.$customerInfo->last_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-normal">Purchase Date :</th>
                                                        <td class="fw-bold">{{ date('d-m-Y',strtotime($membershipOrder->registration_date)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-normal">Expiry Date :</th>
                                                        <td class="fw-bold">{{ date('d-m-Y',strtotime($membershipOrder->expiry_date)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-normal">Membership Number :</th>
                                                        <td class="fw-bold">{{ $membershipOrder->card_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-normal">Amount :</th>
                                                        <td class="fw-bold">{{ formatePriceIndia($membershipOrder->amount) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-normal">Payment Id :</th>
                                                        <td class="fw-bold">{{ $membershipOrder->paymentid }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="fw-normal">Card Status :</th>
                                                        <td class="fw-bold"><span class="text-{{ $membershipOrder->isActive == 1 ? 'success':'danger' }}">{{ $membershipOrder->isActive == 1 ? 'Active':'Deactive' }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                                <p>No Data Available</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="ver-pills-applicationList" role="tabpanel" aria-labelledby="ver-pills-applicationList-tab">
                                <div class="row mt-5">
                                    <div class="table-responsive">
                                        <table class="table table-bordered loanApp-table" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th></th>
                                                <th>Date</th>
                                                <th>Loan Type</th>
                                                <th>Amount</th>
                                                <th>Tenure</th>
                                                <th>CIBIL Score</th>
                                                <th>Purpose</th>
                                                <th>Income</th>
                                                <th>Current EMI</th>
                                                <th>EMI Bounce</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($loanApp as $la)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><a href="javascript:;" id="appInfo" class="appInfo"><span class="icofont icofont-info" style="font-size: 25px;color:#54ba4a"></span></a></td>
                                                    <td>{{ date('d-m-Y H:i',strtotime($la->rec_date)) }}</td>
                                                    <td>{{ $la->loan_type == 1 ? 'Personal Loan' : 'Business Loan'}}</td>
                                                    <td>{{ $la->loan_amount}}</td>
                                                    <td>{{ $la->loantenure}}</td>
                                                    <td>{{ $la->cibilscore}}</td>
                                                    <td>{{ $la->loan_purpose}}</td>
                                                    <td>{{ $la->monthly_income}}</td>
                                                    <td>{{ $la->currentemi}}</td>
                                                    <td>{{ $la->emibounce}}</td>
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
            {{--<div class="modal-footer">
                <button class="btn btn-outline-primary" type="button" id="convert-customer" data-userid="{{$details->id}}">Convert To Customer</button>
                @if($details->isDnd === 0)
                    <button class="btn btn-outline-primary" id="stop-remarketing" data-userid="{{$details->id}}" type="button">Stop Remarketing</button>
                @endif
                @if($details->isActive === 1)
                    <button class="btn btn-outline-danger" id="block-customer" data-userid="{{$details->id}}" type="button">Block Customer</button>
                @endif
                <button class="btn btn-outline-danger" id="delete-customer" data-userid="{{$details->id}}" type="button">Delete Customer</button>
            </div>--}}
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        /* Customer form update start */
        $(".customer-update-form").submit(function(){
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
                        $('#customersBtn').html('<span class="spinner-border spinner-border-sm"></span> Save');
                        $('#customersBtn').attr('disabled', true);
                    },
                    success: function (result) {
                        $(this).attr("disabled", false);
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            $('#userDetails').modal('hide');
                            $('#customer-table').DataTable().ajax.reload();
                        } else {
                            toastr.error(result.message);
                            $('#customersBtn').html('Save');
                            $('#customersBtn').attr('disabled', false);
                        }
                    },
                    error: function (error) {
                        $(this).attr("disabled", false);
                        let errors = error.responseJSON.errors, errorsHtml = '';
                        $.each(errors, function (key, value) {
                            errorsHtml = '<strong>' + value[0] + '</strong>';
                            $('.' + key).html(errorsHtml);
                        });
                        $('#customersBtn').html('Save');
                        $('#customersBtn').attr('disabled', false);
                    }
                });
            }
        })
        /* Customer forms update end */
        $('.loanApp-table').DataTable({
            responsive: true,
            searching: false,
            pageLength: 50,
            lengthChange: false
        });
    })
</script>
