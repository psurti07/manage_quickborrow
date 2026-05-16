@extends('layouts.manage')
@section('title', 'Staff Statistics')

@push('css-links')

@endpush

@push('style-css')
@endpush

@section('breadcrumb-title')
<h3>Staff Statistics</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{ route('manage.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Staff Statistics</li>
@endsection

@section(section: 'content')
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-12 text-end d-inline align-content-end">
            <form method="post" action="{{ route('manage.statistics.self.apply.staff.stats') }}" class="filterForm" id="filterForm">
                @csrf
                <div class="row g-3">
                    <div class="col-md-2 position-relative text-start">
                        <label class="form-label" for="fromDate">From Date</label>
                        <input class="form-control" id="fromDate" type="date" name="fromDate" max="{{ date('Y-m-d') }}" value="{{ \Carbon\Carbon::parse($fromDate)->format('Y-m-d') }}" data-bs-original-title="" title="">
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
        @foreach($data as $d)
        <div class="col-xxl-3 col-ed-6 col-md-5 col-sm-6 box-col-5">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <h5 class="m-0">{{ $d->staff_name }}</h5>
                        <div class="card-header-right-icon"><span class="common-space badge badge-light-{{ $d->isActive == 1 ? 'success' : 'danger' }}">{{ $d->isActive == 1 ? 'Active' : 'Inactive' }}</span></div>
                    </div>
                </div>
                <div class="card-body pt-0"> 
                    <ul class="lessons-lists"> 
                        <li>
                            <div> 
                                <h6 class="f-14 f-w-400 mb-0">New Application</h6>
                            </div>
                            <div class="lesson-wrap ms-auto"> 
                                <span class="text-end txt-dark">{{ $d->new_count }}</span>
                            </div>
                        </li>
                        <li>
                            <div> 
                                <h6 class="f-14 f-w-400 mb-0">Verified Application</h6>
                            </div>
                            <div class="lesson-wrap ms-auto"> 
                                <span class="text-end txt-dark">{{ $d->verified_count }}</span>
                            </div>
                        </li>
                        <li>
                            <div> 
                                <h6 class="f-14 f-w-400 mb-0">Account Closed</h6>
                            </div>
                            <div class="lesson-wrap ms-auto"> 
                                <span class="text-end txt-dark">{{ $d->closed_count }}</span>
                            </div>
                        </li>
                        <li>
                            <div> 
                                <h6 class="f-14 f-w-400 mb-0">Total</h6>
                            </div>
                            <div class="lesson-wrap ms-auto"> 
                                <span class="text-end txt-dark">{{ $d->user_count }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('script-src')

@endpush

@push('script-tag')
@endpush