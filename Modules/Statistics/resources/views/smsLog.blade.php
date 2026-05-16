@extends('layouts.manage')
@section('title', 'Sms Statistics')

@push('css-links')

@endpush

@push('style-css')
@endpush

@section('breadcrumb-title')
<h3>Sms Statistics  - {{ date('d M, Y') }}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{ route('manage.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Sms Statistics</li>
@endsection

@section(section: 'content')
<div class="container-fluid">
    <div class="row">
        <h4 class="text-center mt-2 mb-5">OTP Statistics</h4>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" id="otpSACard">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ $todaySACount }}</h4><span class="f-light">Self Apply</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" id="otpLACard">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ $todayLACount }}</h4><span class="f-light">Loan Agent</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <hr/>
    </div>
    <div class="row mt-5">
        <h4 class="text-center mt-2 mb-5">Whatsapp Remarketing Statistics</h4>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" id="whatsappSA">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ $todaySAWPtotal }}</h4><span class="f-light">Self Apply</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" id="whatsappLA">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ $todayLAWPPtotal }}</h4><span class="f-light">Loan Agent</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <hr/>
    </div>
    <div class="row mt-5">
        <h4 class="text-center mt-2 mb-5">SMS Remarketing Statistics</h4>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" id="remarketingSA">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ $todaySASMSStotal }}</h4><span class="f-light">Self Apply</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" id="remarketingLA">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ $todayLASMSStotal }}</h4><span class="f-light">Loan Agent</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
        <!-- <div class="col-xxl-auto col-xl-4 col-sm-4 box-col-4">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card widget-1">
                        <div class="card-body">
                            <div class="widget-content">
                                <div>
                                    <h4>{{ $todayLACount }}</h4><span class="f-light">Loan Agent</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>
@endsection

@push('script-src')

@endpush

@push('script-tag')
    <script>
        $(document).ready(function(){
            /* self apply card click */
            $("#otpSACard").on('click', function(){
                let fromDate = new Date().toISOString().split('T')[0];
                let toDate = fromDate;
                let product = '1';
                let targetURL = `{!! route('manage.sendotps') !!}`;

                // Store in session storage (optional, can also pass via URL)
                sessionStorage.setItem('from_date', fromDate);
                sessionStorage.setItem('to_date', toDate);
                sessionStorage.setItem('product', product);

                // Redirect to the DataTables page with parameters
                window.location.href = targetURL;
            });
            
            /* loan agent card click */
            $("#otpLACard").on('click', function(){
                let fromDate = new Date().toISOString().split('T')[0];
                let toDate = fromDate;
                let product = '2';
                let targetURL = `{!! route('manage.sendotps') !!}`;

                // Store in session storage (optional, can also pass via URL)
                sessionStorage.setItem('from_date', fromDate);
                sessionStorage.setItem('to_date', toDate);
                sessionStorage.setItem('product', product);

                // Redirect to the DataTables page with parameters
                window.location.href = targetURL;
            });

        })
    </script>
@endpush