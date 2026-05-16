@extends('layouts.manage')
@section('title', $type)

@push('css-links')

@endpush

@push('style-css')
@endpush

@section('breadcrumb-title')
<h3>{{ $type }} Statistics - {{ date('d M, Y') }}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{ route('manage.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">{{ $type }}</li>
@endsection

@section(section: 'content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-url="{{ strtolower(str_ireplace(' ', '',$type)) }}" data-url2="customers" onclick="customersLists(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ $data['customers'] }}</h4><span class="f-light">Todays {{ $type }} Customers</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="javascript:;" data-url="{{ strtolower(str_ireplace(' ', '',$type)) }}" data-url2="leads" onclick="customersLists(this)">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ $data['leads'] }}</h4><span class="f-light">Todays {{ $type }} Leads</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <div class="card widget-1">
                <div class="card-body">
                    <div class="widget-content">
                        <div>
                            <h4>&#8377;{{ formatePriceIndia($data['amount']) ?? 0 }}</h4><span class="f-light">Todays {{ $type }} Collections</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="{{ route('manage.statistics.open.accounts',['type' => (($type == 'Self Apply') ? 'self-apply' : 'Loan Agent')]) }}">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div>
                                <h4>{{ $data['openAccounts'] ?? 0 }}</h4><span class="f-light">{{ $type }} {{ (($type == 'Self Apply') ? 7 : 10) }} Days</span>
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
        function customersLists(element){
            let url = $(element).data('url');
            let url2 = $(element).data('url2');
            let fromDate = new Date().toISOString().split('T')[0];
            let toDate = fromDate;
            let baseUrl = `{{ url('_URL_/_URL2_') }}`;
            let baseUrl2 = baseUrl.replace('_URL_',url);
            let targetUrl = baseUrl2.replace('_URL2_',url2);

            sessionStorage.setItem('from_date', fromDate);
            sessionStorage.setItem('to_date', toDate);

            window.location.href = targetUrl;
                
        }
    </script>
@endpush