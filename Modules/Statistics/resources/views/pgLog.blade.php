@extends('layouts.manage')
@section('title', 'Payment Gateway Statistics')

@push('css-links')

@endpush

@push('style-css')
@endpush

@section('breadcrumb-title')
<h3>Payment Gateway Statistics - {{ date('d M, Y') }}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{ route('manage.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Payment Gateway Statistics</li>
@endsection

@section(section: 'content')
<div class="container-fluid">
    <div class="row mt-3">
        <h4 class="text-center mb-5">Todays Loan Agent Payment Gateway Statistics</h4>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="zaakpay-log" data-entry-for="12" data-offer-name="Hire Loan Agent" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['zaakPayLA'] ?? 0) }}</h4><span class="f-light">Zaakpay Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="lyra-log" data-entry-for="3" data-offer-name="LA Offer 1" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['lyraLA'] ?? 0) }}</h4><span class="f-light">Lyra Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="sabpaisa-log" data-entry-for="4" data-offer-name="LA Offer 2" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['sabpaisaLA'] ?? 0) }}</h4><span class="f-light">Sabpaisa Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="paygic-log" data-entry-for="53" data-offer-name="LA Offer 4" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['paygicLA'] ?? 0) }}</h4><span class="f-light">Paygic Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="phonepe-log" data-entry-for="10" data-offer-name="LA Offer 5" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['phonePeLA'] ?? 0) }}</h4><span class="f-light">PhonePe Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="razorpay-log" data-entry-for="10" data-offer-name="LA Offer 5" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['razorPayLA'] ?? 0) }}</h4><span class="f-light">Razorpay Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="airpay-log" data-entry-for="22" data-offer-name="LA Offer 5" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['airpayLA'] ?? 0) }}</h4><span class="f-light">Airpay Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="cashfree-log" data-entry-for="52" data-offer-name="LA Offer 6" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['cashfreeLA'] ?? 0) }}</h4><span class="f-light">Cashfree Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div> -->
        <hr />
    </div>
    <div class="row mt-3">
        <h4 class="text-center mb-5">Todays Self Apply Payment Gateway Statistics</h4>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="zaakpay-log" data-entry-for="11" data-offer-name="Self Apply" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['zaakPaySA'] ?? 0) }}</h4><span class="f-light">Zaakpay Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="lyra-log" data-entry-for="6" data-offer-name="SA Offer 1" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['lyraPGSA'] ?? 0) }}</h4><span class="f-light">Lyra Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="sabpaisa-log" data-entry-for="7" data-offer-name="SA Offer 2" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['sabpaisaPGSA'] ?? 0) }}</h4><span class="f-light">Sabpaisa Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="paygic-log" data-entry-for="55" data-offer-name="SA Offer 5" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['paygicSA'] ?? 0) }}</h4><span class="f-light">Paygic Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="phonepe-log" data-entry-for="9" data-offer-name="SA Offer 4" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['phonePeSA'] ?? 0) }}</h4><span class="f-light">PhonePe Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="razorpay-log" data-entry-for="9" data-offer-name="SA Offer 4" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['razorPaySA'] ?? 0) }}</h4><span class="f-light">Razorpay Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="airpay-log" data-entry-for="21" data-offer-name="SA Offer 5" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['airpaySA'] ?? 0) }}</h4><span class="f-light">Airpay Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-payment-gateway="cashfree-log" data-entry-for="31" data-offer-name="SA Offer 6" onclick="paymentLogRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>&#8377;{{ formatePriceIndia($data['cashfreeSA'] ?? 0) }}</h4><span class="f-light">Cashfree Payment Gateway</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div> -->
    </div>
</div>
@endsection

@push('script-src')

@endpush

@push('script-tag')
<script>
    function paymentLogRedirect(element) {
        let pgLog = $(element).data('payment-gateway');
        let offerName = $(element).data('offer-name');
        let entryFor = $(element).data('entry-for');
        let fromDate = new Date().toISOString().split('T')[0];
        let toDate = fromDate;
        let baseUrl = `{{ url('_PLACE_') }}`;
        let targetUrl = baseUrl.replace('_PLACE_',pgLog);
        
        sessionStorage.setItem('from_date', fromDate);
        sessionStorage.setItem('to_date', toDate);
        sessionStorage.setItem('status', 1);
        sessionStorage.setItem('entryfor', entryFor);
        
        window.location.href = targetUrl;
    }
</script>
@endpush