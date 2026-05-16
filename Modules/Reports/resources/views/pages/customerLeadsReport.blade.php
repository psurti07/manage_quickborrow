@extends('layouts.manage')
@section('title', $type.' Reports' )

@push('css-links')
    @include('stacks.css.manage.datatables')
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/chart/morris.css') }}"/>
@endpush
@push('style-css')
    <style>
        #loading-spinner {
            display: table-row; /* Initially hidden */
            text-align: center;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
@endpush

@section('breadcrumb-title')
    <h3>{{ ucfirst($type) }} Report</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">All {{ ucfirst($type) }} Report</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <canvas id="column-chart" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered all-leads-table" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Total Leads</th>
                                    <th class="text-center">Date Wise</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php $grandtotal = 0; $barlabel = $bardata = ""; @endphp
                                    @foreach($getLeadReport as $leads)
                                    <tr>
                                        <td width="10px">{{ $leads->recyear }}</td>
                                        <td width="10px">{{ $leads->recmonth }}</td>
                                        <td width="10px">{{ number_format($leads->totaluser,0) }}</td>
                                        <td class="text-center" width="70px">
                                            <button type="button" class="btn active btn-light txt-dark btn-sm modal_data" data-bs-toggle="modal" data-bs-target="#modaldata" id="{{ $leads->recyear }}" data-id="{{ $leads->recmonth }}" data-ids="{{ $leads->monthno }}">
                                                <span class='icon icon-info'></span>View Datewise
                                            </button>
                                        </td>
                                        @php
                                            $grandtotal += $leads->totaluser;
                                            $barlabel .= "'".$leads->recyear." - ".$leads->recmonth."',";
                                            $bardata .= $leads->totaluser.",";
                                        @endphp
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
@endsection

@section('custom-modal')
    <div class="modal fade" id="modaldata" tabindex="-1" aria-labelledby="myLargeModalLabel" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id='clickmonthname'></h3><br>
                    <button type="button" class="close" data-bs-dismiss="modal">x</button>
                </div>
                <div class="modal-body dark-modal" style="overflow-y:scroll; height:400px;">
                    <table class="table table-bordered table-sm" id="modal-table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th class='text-right'>Total Leads</th>
                        </tr>
                        </thead>
                        <tbody id="table_data">
                            <!-- Loading Spinner -->
                            <tr id="loading-spinner">
                                <td colspan="2" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                        <tr class='text-right text-bold-600'>
                            <td>Total Leads</td>
                            <td>
                                <div id="subtotalleads"></div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
    <script type="text/javascript" src="{{asset('assets/js/chart/chart.min.js')}}"></script>
    @include('stacks.js.modules.reports.leads')
@endpush

@push('script-tag')
@endpush
