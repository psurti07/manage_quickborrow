@extends('layouts.manage')
@section('title', 'Offer Page Statistics')

@push('css-links')

@endpush

@push('style-css')
@endpush

@section('breadcrumb-title')
<h3>Offer Page Statistics - {{ date('d M, Y') }}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{ route('manage.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Offer Page Statistics</li>
@endsection

@section(section: 'content')
<div class="container-fluid">
    <div class="row">
        <h4 class="text-center mb-5">Loan Agent Offer Page Statistics</h4>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-offer="Great_Deal_Offer" onclick="offerPageRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ offerPageStatistics(1) }}</h4><span class="f-light">Great Deal Offer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-offer="Elite_Offer" onclick="offerPageRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ offerPageStatistics(2) }}</h4><span class="f-light">Elite Offer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-offer="Big_Offer" onclick="offerPageRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ offerPageStatistics(8) }}</h4><span class="f-light">Big Offer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-offer="Big_Benefit_Offer" onclick="offerPageRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ offerPageStatistics(10) }}</h4><span class="f-light">Big Benefit Offer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-offer="Silver_Offer" onclick="offerPageRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ offerPageStatistics(32) }}</h4><span class="f-light">Silver Offer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <hr />
    </div>
    <div class="row mt-3">
        <h4 class="text-center mb-5">Self Apply Offer Page Statistics</h4>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-offer="Prime_Offer" onclick="offerPageRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ offerPageStatistics(4) }}</h4><span class="f-light">Prime Offer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-offer="Mega_Offer" onclick="offerPageRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ offerPageStatistics(5) }}</h4><span class="f-light">Mega Offer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!--<div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-offer="Premium_Offer" onclick="offerPageRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ offerPageStatistics(6) }}</h4><span class="f-light">Premium Offer - Cipher Pay</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>-->
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-offer="Star_Offer" onclick="offerPageRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ offerPageStatistics(7) }}</h4><span class="f-light">Star Offer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-offer="Great_Offer" onclick="offerPageRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ offerPageStatistics(9) }}</h4><span class="f-light">Great Offer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-offer="Standard_Offer" onclick="offerPageRedirect(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ offerPageStatistics(31) }}</h4><span class="f-light">Standard Offer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('script-src')

@endpush

@push('script-tag')
<script>
    function offerPageRedirect(element) {
        let offerPage = $(element).data('offer');
        let fromDate = new Date().toISOString().split('T')[0];
        let toDate = fromDate;

        sessionStorage.setItem('from_date', fromDate);
        sessionStorage.setItem('to_date', toDate);

        let baseUrl = "{{ route('manage.offers', ['type' => '__PLACEHOLDER__']) }}";
        let targetUrl = baseUrl.replace('__PLACEHOLDER__', offerPage);
        
        window.location.href = targetUrl;
    }
</script>
@endpush