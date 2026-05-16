@extends('layouts.manage')
@section('title', 'Loan Agent Process Steps Statistics')

@push('css-links')

@endpush

@push('style-css')
@endpush

@section('breadcrumb-title')
<h3>Loan Agent Process Steps Statistics</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{ route('manage.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">LA Process Steps</li>
@endsection

@section(section: 'content')
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-12 text-end d-inline align-content-end">
            <form method="post" action="{{ route('manage.statistics.loan.agent.process.steps') }}" class="filterForm" id="filterForm">
                @csrf
                <div class="row g-3">
                    <div class="col-md-2 position-relative text-start">
                        <label class="form-label" for="fromDate">From Date</label>
                        <input class="form-control" id="fromDate" type="date" name="fromDate" max="{{ date('Y-m-d') }}" value="{{ \Carbon\Carbon::parse($fromDate)->subDays(2)->format('Y-m-d') }}" data-bs-original-title="" title="">
                    </div>
                    <div class="col-md-2 position-relative text-start">
                        <label class="form-label" for="toDate">To Date</label>
                        <input class="form-control" id="toDate" type="date" name="toDate" max="{{ date('Y-m-d') }}" value="{{ \Carbon\Carbon::parse($toDate)->format('Y-m-d') }}" data-bs-original-title="" title="">
                    </div>
                    <div class="col-md-2 position-relative text-start">
                        <button type="submit" class="mt-4 btn btn-outline-primary" id="filterBtn" data-bs-original-title="" title="">Show</button>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-12">
            <div class="card small-widget"> 
                <div class="card-body warning">
                    <span class="f-light">Loan Details</span>
                    <div class="d-flex align-items-end gap-1">
                        <h4>{{ $data['processOne'] }}</h4>
                    </div>
                    <div class="bg-gradient"><span class="font-warning f-20 f-light f-w-500">01</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <div class="card small-widget"> 
                <div class="card-body warning">
                    <span class="f-light">Personal Details</span>
                    <div class="d-flex align-items-end gap-1">
                    <h4>{{ $data['processTwo'] }}</h4>
                    </div>
                    <div class="bg-gradient"><span class="font-warning f-20 f-light f-w-500">02</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <div class="card small-widget"> 
                <div class="card-body warning">
                    <span class="f-light">Unlock Offers</span>
                    <div class="d-flex align-items-end gap-1">
                        <h4><h4>{{ $data['processThree'] }}</h4></h4>
                    </div>
                    <div class="bg-gradient"><span class="font-warning f-20 f-light f-w-500">03</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <div class="card small-widget"> 
                <div class="card-body warning">
                    <span class="f-light">Purchase Plan</span>
                    <div class="d-flex align-items-end gap-1">
                        <h4>{{ $data['processFour'] }}</h4>
                    </div>
                    <div class="bg-gradient"><span class="font-warning f-20 f-light f-w-500">04</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <div class="card small-widget"> 
                <div class="card-body warning">
                    <span class="f-light">Personalized Offers</span>
                    <div class="d-flex align-items-end gap-1">
                        <h4>{{ $data['processFive'] }}</h4>
                    </div>
                    <div class="bg-gradient"><span class="font-warning f-20 f-light f-w-500">05</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <div class="card small-widget"> 
                <div class="card-body warning">
                    <span class="f-light">1<sup>st</sup> Service Calls</span>
                    <div class="d-flex align-items-end gap-1">
                        <h4>{{ $data['processSix'] }}</h4>
                    </div>
                    <div class="bg-gradient"><span class="font-warning f-20 f-light f-w-500">06</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <div class="card small-widget"> 
                <div class="card-body warning">
                    <span class="f-light">2<sup>nd</sup> Service Calls</span>
                    <div class="d-flex align-items-end gap-1">
                        <h4>{{ $data['processSeven'] }}</h4>
                    </div>
                    <div class="bg-gradient"><span class="font-warning f-20 f-light f-w-500">07</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <div class="card small-widget"> 
                <div class="card-body warning">
                    <span class="f-light">3<sup>rd</sup> Service Calls</span>
                    <div class="d-flex align-items-end gap-1">
                        <h4>{{ $data['processEight'] }}</h4>
                    </div>
                    <div class="bg-gradient"><span class="font-warning f-20 f-light f-w-500">08</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <div class="card small-widget"> 
                <div class="card-body warning">
                    <span class="f-light">Initiated Calls</span>
                    <div class="d-flex align-items-end gap-1">
                        <h4>{{ $data['processNine'] }}</h4>
                    </div>
                    <div class="bg-gradient"><span class="font-warning f-20 f-light f-w-500">09</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <div class="card small-widget"> 
                <div class="card-body warning">
                    <span class="f-light">Other Calls</span>
                    <div class="d-flex align-items-end gap-1">
                        <h4>{{ $data['processTen'] }}</h4>
                    </div>
                    <div class="bg-gradient"><span class="font-warning f-20 f-light f-w-500">10</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <div class="card small-widget"> 
                <div class="card-body warning">
                    <span class="f-light">Service Closed</span>
                    <div class="d-flex align-items-end gap-1">
                        <h4>{{ $data['processEleven'] }}</h4>
                    </div>
                    <div class="bg-gradient"><span class="font-warning f-20 f-light f-w-500">11</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-src')

@endpush

@push('script-tag')

@endpush