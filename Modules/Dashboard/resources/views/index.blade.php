@extends('layouts.manage')
@section('title', config('dashboard.name'))

@push('css-links')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
    <h3>Dashboard</h3>
@endsection

@section('breadcrumb-items')
    <!-- <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li> -->
@endsection

@section('content')
    <div class="container-fluid">
        @if(Auth::user()->role != 4)
        <div class="row widget-grid">
            <div class="col-sm-12 col-xl-6 box-col-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>SelfApply Customers</h5>
                    </div>
                    <div class="card-body">
                        <div id="sa-customers"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6 box-col-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>SelfApply Leads</h5>
                    </div>
                    <div class="card-body">
                        <div id="sa-leads"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6 box-col-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>Loan Agent Customers</h5>
                    </div>
                    <div class="card-body">
                        <div id="la-customers"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6 box-col-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>Loan Agent Leads</h5>
                    </div>
                    <div class="card-body">
                        <div id="la-leads"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@push('script-src')
    <!-- <script src="{{ asset('assets/js/clock.js') }}"></script> -->
    <script src="{{ asset('assets/js/animation/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
@endpush
@push('script-tag')
    <script>
        /* self-apply customer */
        let saCustomer = @json($saCustomers);
        let saCustomersDetailsTotalUsers = @json(array_column($saCustomers,'totaluser'));
        let saCustomersDetailsDateMonth = saCustomer.map(item => `${item.recday} - ${item.recmonth}`);
        let saCustYear = saCustomer.map(item => `${item.recyear}`);

        /* self-apply leads */
        let saLead = @json($saLeads);
        let saLeadsDetailsTotalUsers = @json(array_column($saLeads,'totaluser'));
        let saLeadsDetailsDateMonth = saLead.map(item => `${item.recday} - ${item.recmonth}`);
        let saLeadYear = saLead.map(item => `${item.recyear}`);
        
        /* loan-agent customer */
        let laCustomer = @json($laCustomers);
        let laCustomersDetailsTotalUsers = @json(array_column($laCustomers,'totaluser'));
        let laCustomersDetailsDateMonth = laCustomer.map(item => `${item.recday} - ${item.recmonth}`);
        let laCustYear = laCustomer.map(item => `${item.recyear}`);

        /* loan-agent leads */
        let laLead = @json($laLeads);
        let laLeadsDetailsTotalUsers = @json(array_column($laLeads,'totaluser'));
        let laLeadsDetailsDateMonth = laLead.map(item => `${item.recday} - ${item.recmonth}`);
        let laLeadYear = laLead.map(item => `${item.recyear}`);
    </script>
    <script>
        $(document).ready(function(){
            /* self-apply customers Chart */
            var saCustomerChart = {
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar:{
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        endingShape: 'rounded',
                        columnWidth: '55%',
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                series: [{
                    name: 'Registrations:',
                    data: saCustomersDetailsTotalUsers
                }],
                xaxis: {
                    categories: saCustomersDetailsDateMonth,
                },
                yaxis: {
                    title: {
                        text: 'Total No.of Registered Users.'
                    }
                },
                fill: {
                    opacity: 1

                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val;
                        }
                    },
                    x: {
                        formatter: function (val, {dataPointIndex}) {
                            return val +" - "+saCustYear[dataPointIndex];
                        }
                    },
                },
                colors:[ CubaAdminConfig.primary]
            }

            var chart1 = new ApexCharts(
                document.querySelector("#sa-customers"),
                saCustomerChart
            );
            chart1.render();

            /* self-apply leads Chart */
            var saLeadChart = {
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar:{
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        endingShape: 'rounded',
                        columnWidth: '55%',
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                series: [{
                    name: 'Leads:',
                    data: saLeadsDetailsTotalUsers
                }],
                xaxis: {
                    categories: saLeadsDetailsDateMonth,
                },
                yaxis: {
                    title: {
                        text: 'Total No.of Leads Users.'
                    }
                },
                fill: {
                    opacity: 1

                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val;
                        }
                    },
                    x: {
                        formatter: function (val, {dataPointIndex}) {
                            return val +" - "+saLeadYear[dataPointIndex];
                        }
                    },
                },
                colors:[ CubaAdminConfig.primary]
            }

            var chart2 = new ApexCharts(
                document.querySelector("#sa-leads"),
                saLeadChart
            );
            chart2.render();

            /* loan-agent customers Chart */
            var laCustomerChart = {
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar:{
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        endingShape: 'rounded',
                        columnWidth: '55%',
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                series: [{
                    name: 'Registrations:',
                    data: laCustomersDetailsTotalUsers
                }],
                xaxis: {
                    categories: laCustomersDetailsDateMonth,
                },
                yaxis: {
                    title: {
                        text: 'Total No.of Registered Users.'
                    }
                },
                fill: {
                    opacity: 1

                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val;
                        }
                    },
                    x: {
                        formatter: function (val, {dataPointIndex}) {
                            return val +" - "+laCustYear[dataPointIndex];
                        }
                    },
                },
            colors:[ CubaAdminConfig.secondary]
            }

            var chart3 = new ApexCharts(
                document.querySelector("#la-customers"),
                laCustomerChart
            );
            chart3.render();

            /* loan-agent leads Chart */
            var laLeadChart = {
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar:{
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        endingShape: 'rounded',
                        columnWidth: '55%',
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                series: [{
                    name: 'Leads:',
                    data: laLeadsDetailsTotalUsers
                }],
                xaxis: {
                    categories: laLeadsDetailsDateMonth,
                },
                yaxis: {
                    title: {
                        text: 'Total No.of Leads Users.'
                    }
                },
                fill: {
                    opacity: 1

                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val;
                        }
                    },
                    x: {
                        formatter: function (val, {dataPointIndex}) {
                            return val +" - "+laLeadYear[dataPointIndex];
                        }
                    },
                },
                colors:[ CubaAdminConfig.secondary]
            }

            var chart4 = new ApexCharts(
                document.querySelector("#la-leads"),
                laLeadChart
            );
            chart4.render();
        });
    </script>
@endpush
