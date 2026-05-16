<style>
    .sidebar-list.active {
        transition: all .5s ease;
        position: relative;
        margin-bottom: 10px;
        background-color: #dbeee5;
    }

    .sidebar-list.active a span {
        color: #0a8b4b !important;
        /* Ensures the color is applied */
    }
    .rupee-sign{
        font-size: 18px;
        font-weight: normal;
    }
</style>
@php
     $activeRouteName = str_ireplace('manage.','',Route::currentRouteName());
@endphp
<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('manage.dashboard') }}">
                <img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo.png') }}" alt="{{ env('APP_NAME') }}" width="160">
                <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo-w.png') }}" alt="{{ env('APP_NAME') }}" width="160">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="{{ route('manage.dashboard') }}">
                <img class="img-fluid for-light" src="{{ asset('assets/images/logo/favicon-32x32.png') }}" alt="{{ env('APP_NAME') }}">
                <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/favicon-32x32-w.png') }}" alt="{{ env('APP_NAME') }}">
            </a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="{{ route('manage.dashboard') }}">
                            <img class="img-fluid for-light" src="{{ asset('assets/images/logo/favicon-32x32.png') }}" alt="{{ env('APP_NAME') }}">
                            <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/favicon-32x32-w.png') }}" alt="{{ env('APP_NAME') }}">
                        </a>
                        <div class="mobile-back text-end">
                            <span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                        </div>
                    </li>
                    
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="">General</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.dashboard') }}">
                            <i data-feather="airplay"></i>
                            <span class="">Dashboard</span>
                        </a>
                    </li>
                    @if(!in_array(Auth::user()->role, [4]))
                        @if(!in_array(Auth::user()->role, [2,5]))
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.create.account') }}">
                                    <i data-feather="user-plus"></i>
                                    <span class="">Create An Account</span>
                                </a>
                            </li>
                        @endif
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.searchdata') }}">
                                <i data-feather="search"></i>
                                <span class="">Search Data</span>
                            </a>
                        </li>
                    @endif
                    @if(!in_array(Auth::user()->role, [4]))
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="">Statistics</h6>
                            </div>
                        </li>
                        @if(in_array(Auth::user()->role, [0,1,3,6,5]))
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title" href="javascript:;">
                                    <i data-feather="bar-chart-2"></i>
                                    <span class="">Self Apply</span>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('manage.statistics.self.apply') }}">Today Statistics</a></li>
                                    <li><a href="{{ route('manage.statistics.self.apply.process.steps') }}">Process Steps</a></li>
                                    <li><a href="{{ route('manage.statistics.self.apply.staff.stats') }}">Staff Statistics</a></li>
                                </ul>
                            </li>
                        @endif
                        @if(in_array(Auth::user()->role, [0,1,3,6,2]))
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title" href="javascript:;">
                                    <i data-feather="bar-chart-2"></i>
                                    <span class="">Loan Agent</span>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('manage.statistics.loan.agent') }}">Today Statistics</a></li>
                                    <li><a href="{{ route('manage.statistics.loan.agent.process.steps') }}">Process Steps</a></li>
                                    <li><a href="{{ route('manage.statistics.loan.agent.staff.stats') }}">Staff Statistics</a></li>
                                </ul>
                            </li>
                        @endif
                        @if(!in_array(Auth::user()->role, [5,2,7]))
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.statistics.sms.log') }}">
                                    <i data-feather="bar-chart-2"></i>
                                    <span class="">SMS Statistics</span>
                                </a>
                            </li>
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.statistics.offer.page.log') }}">
                                    <i data-feather="bar-chart-2"></i>
                                    <span class="">Offer Page Statistics</span>
                                </a>
                            </li>
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.statistics.payment.gateway.log') }}">
                                    <i data-feather="bar-chart-2"></i>
                                    <span class="">PG Statistics</span>
                                </a>
                            </li>
                            @if(false)
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.statistics.referral.customers') }}">
                                    <i data-feather="git-merge"></i>
                                    <span class="">Referral Customers</span>
                                </a>
                            </li>
                            @endif
                        @endif
                    @endif
                    @if(!in_array(Auth::user()->role, [4]))
                        @if(in_array(Auth::user()->role, [0,1,3,6,5]))
                            <li class="sidebar-main-title">
                                <div>
                                    <h6 class="">Self Apply</h6>
                                </div>
                            </li>
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.selfapply.company.leads') }}">
                                    <i data-feather="layers"></i>
                                    <span class="">User Leads</span>
                                </a>
                            </li>
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.selfapply.users') }}">
                                    <i data-feather="users"></i>
                                    <span class="">Customers</span>
                                </a>
                            </li>
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title" href="javascript:;">
                                    <i data-feather="archive"></i>
                                    <span class="">Applications</span>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('manage.selfapply.saapplications',['type'=>'new']) }}">New Application</a></li>
                                    <li><a href="{{ route('manage.selfapply.saapplications',['type'=>'verified']) }}">Verified Application</a></li>
                                    <li><a href="{{ route('manage.selfapply.saapplications',['type'=>'closed']) }}">Closed Application</a></li>
                                </ul>
                            </li>
                        @endif
                    @endif
                    @if(!in_array(Auth::user()->role, [4]))
                        @if(in_array(Auth::user()->role, [0,1,3,6,2]))
                            <li class="sidebar-main-title">
                                <div>
                                    <h6 class="">Loan Agent</h6>
                                </div>
                            </li>
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.loanagent.company.leads') }}">
                                    <i data-feather="layers"></i>
                                    <span class="">User Leads</span>
                                </a>
                            </li>
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.loanagent.users') }}">
                                    <i data-feather="users"></i>
                                    <span class="">Customers</span>
                                </a>
                            </li>
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title" href="javascript:;">
                                    <i data-feather="archive"></i>
                                    <span class="">Applications</span>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('manage.loanAgent.application.new.application') }}">New Application</a></li>
                                    <li>
                                        <a href="javascript:;" class="submenu-title">Service Calls
                                            <span class="sub-arrow"><i class="fa fa-angle-right"></i></span>
                                        </a>
                                        <ul class="nav-sub-childmenu submenu-content">
                                            <li><a href="{{ route('manage.loanAgent.application.service.calls.application',['serviceno'=>6]) }}">Service Call 1</a></li>
                                            <li><a href="{{ route('manage.loanAgent.application.service.calls.application',['serviceno'=>7]) }}">Service Call 2</a></li>
                                            <li><a href="{{ route('manage.loanAgent.application.service.calls.application',['serviceno'=>8]) }}">Service Call 3</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('manage.loanAgent.application.initiated.calls.application') }}">Initiated Calls</a></li>
                                    <li><a href="{{ route('manage.loanAgent.application.other.calls.application') }}">Other Calls</a></li>
                                    <li><a href="{{ route('manage.loanAgent.application.closed.application') }}">Service Closed</a></li>
                                </ul>
                            </li>
                        @endif
                    @endif
                    @if(!in_array(Auth::user()->role, [4,7,2,5]))
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="">Orders</h6>
                            </div>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title" href="javascript:;">
                                <i data-feather="star"></i>
                                <span class="">Failed Payment Page</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('manage.offers',['type'=>'Star_Offer']) }}">Star Offer</a></li>
                                <li><a href="{{ route('manage.offers',['type'=>'Elite_Offer']) }}">Elite Offer</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title" href="javascript:;">
                                <i data-feather="star"></i>
                                <span class="">IVR Payment Page</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('manage.offers',['type'=>'Prime_Offer']) }}">Prime Offer</a></li>
                                <li><a href="{{ route('manage.offers',['type'=>'Big_Offer']) }}">Big Offer</a></li>
                                <li><a href="{{ route('manage.offers',['type'=>'Mega_Offer']) }}">Mega Offer</a></li>    
                                <li><a href="{{ route('manage.offers',['type'=>'Premium_Offer']) }}">Premium Offer</a></li>
                                <li><a href="{{ route('manage.offers',['type'=>'Great_Offer']) }}">Great Offer</a></li>
                                <li><a href="{{ route('manage.offers',['type'=>'Big_Benefit_Offer']) }}">Big Benefit Offer</a></li>
                                <li><a href="{{ route('manage.offers',['type'=>'Great_Deal_Offer']) }}">Great Deal Offer</a></li>
                                <li><a href="{{ route('manage.offers',['type'=>'Ultra_Saver_Offer']) }}">Ultra Saver Offer</a></li>
                            </ul>
                        </li>
                    @endif
                    @if(!in_array(Auth::user()->role, [4,7,2,5,1]))
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="">Tasks</h6>
                            </div>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.partners.tasks') }}">
                                <i data-feather="clipboard"></i>
                                <span class="">Channel Partner Tasks</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.staff.tasks') }}">
                                <i data-feather="clipboard"></i>
                                <span class="">Staff Tasks</span>
                            </a>
                        </li>
                    @endif
                    @if(!in_array(Auth::user()->role, [4,7,2,5]))
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="">Reports</h6>
                            </div>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title" href="javascript:;">
                                <i data-feather="bar-chart-2"></i>
                                <span class="">All Leads</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('manage.reports.customers.leads.data',['type'=>'leads','acc_type'=>1]) }}">SelfApply Leads</a></li>
                                <li><a href="{{ route('manage.reports.customers.leads.data',['type'=>'leads','acc_type'=>2]) }}">LoanAgent Leads</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title" href="javascript:;">
                                <i data-feather="bar-chart-2"></i>
                                <span class="">Customer</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('manage.reports.customers.leads.data',['type'=>'customer','acc_type'=>1]) }}">SelfApply Customer</a></li>
                                <li><a href="{{ route('manage.reports.customers.leads.data',['type'=>'customer','acc_type'=>2]) }}">LoanAgent Customer</a></li>
                            </ul>
                        </li>
                    @endif
                    @if(!in_array(Auth::user()->role, [7,5,2]))
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="">Accounting</h6>
                            </div>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.reports.invoice') }}">
                                <i data-feather="file-text"></i>
                                <span class="">Invoice</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.reports.gst.data') }}">
                                <i data-feather="percent"></i>
                                <span class="">GST</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.reports.tds.data') }}">
                                <i data-feather="percent"></i>
                                <span class="">TDS</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.reports.refund.data') }}">
                                <i data-feather="repeat"></i>
                                <span class="">Refund Data</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.reports.company.gst') }}">
                                <i data-feather="file"></i>
                                <span class="">Company GST</span>
                            </a>
                        </li>
                    @endif
                    @if(!in_array(Auth::user()->role, [2,4,5,7]))
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="">Payment Log</h6>
                            </div>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav payment-log" href="{{ route('manage.razorpaylog') }}" data-table="razorpayentry">
                                <span class="rupee-sign">₹</span>
                                <span class="">RazorPay Log</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav payment-log" href="{{ route('manage.paymentlog') }}" data-table="phonepe_entry">
                                <span class="rupee-sign">₹</span>
                                <span class="">PhonePe Log</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav payment-log" href="{{ route('manage.zaakpaylog') }}" data-table="zaakpay_entry">
                                <span class="rupee-sign">₹</span>
                                <span class="">ZaakPay Log</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav payment-log" href="{{ route('manage.paygiclog') }}" data-table="paygic_entry">
                                <span class="rupee-sign">₹</span>
                                <span class="">Paygic Log</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav payment-log" href="{{ route('manage.lyralog') }}" data-table="lyra_entry">
                                <span class="rupee-sign">₹</span>
                                <span class="">Lyra Log</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav payment-log" href="{{ route('manage.subpaisalog') }}" data-table="subpaisa_entry">
                                <span class="rupee-sign">₹</span>
                                <span class="">SubPaisa Log</span>
                            </a>
                        </li>

                        @if(false)
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav payment-log" href="{{ route('manage.vegaahlog') }}" data-table="vegaah_entry">
                                <span class="rupee-sign">₹</span>
                                <span class="">Vegaah Log</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav payment-log" href="{{ route('manage.zwitchlog') }}" data-table="zwitch_entry">
                                <span class="rupee-sign">₹</span>
                                <span class="">Zwitch Log</span>
                            </a>
                        </li>
                         <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav payment-log" href="{{ route('manage.airpaylog') }}" data-table="airpay_entry">
                                <span class="rupee-sign">₹</span>
                                <span class="">Airpay Log</span>
                            </a>
                        </li>
                        @endif
                    @endif
                    @if(Auth::user()->role != 4)
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="">Data List</h6>
                            </div>
                        </li>
                        @if(!in_array(Auth::user()->role, [1,2,5,7]))
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title" href="javascript:;">
                                    <i data-feather="shield"></i>
                                    <span class="">Banks</span>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('manage.banks') }}">Banks</a></li>
                                    <li><a href="{{ route('manage.apply.links') }}">Apply Links</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title" href="javascript:;">
                                    <i data-feather="briefcase"></i>
                                    <span class="">Career</span>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('manage.career') }}">Career Openings</a></li>
                                    <li><a href="{{ route('manage.career.enquiry') }}">Career Enquiry</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title" href="javascript:;">
                                    <i data-feather="zap"></i>
                                    <span class="">Ads Content</span>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('manage.advertisement',['type'=>'text']) }}">Text</a></li>
                                    <li><a href="{{ route('manage.advertisement',['type'=>'image']) }}">Images</a></li>
                                </ul>
                            </li>
                        @endif
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.supportrequest') }}">
                                <i data-feather="life-buoy"></i>
                                <span class="">Support Request</span>
                            </a>
                        </li>
                        @if(!in_array(Auth::user()->role, [2,5,7]))
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.contactenquiry') }}">
                                    <i data-feather="globe"></i>
                                    <span class="">Contact Enquiry</span>
                                </a>
                            </li>
                        @endif
                    @endif
                    @if(!in_array(Auth::user()->role, [2,4,5,7]))
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="">SMS Data</h6>
                            </div>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.sms.send.custom.sms') }}">
                                <i data-feather="message-circle"></i>
                                <span class="">Send Custom SMS</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.sms.smsmessage') }}">
                                <i data-feather="message-circle"></i>
                                <span class="">SMS Message</span>
                            </a>
                        </li>
                        @if(!in_array(Auth::user()->role, [1]))
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.sms.smstemplates') }}">
                                    <i data-feather="message-circle"></i>
                                    <span class="">SMS Templates List</span>
                                </a>
                            </li>
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title" href="javascript:;">
                                    <i data-feather="shield-off"></i>
                                    <span class="">DND List</span>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('manage.dnd.list',['type'=>'selfapply']) }}">Self Apply DND List</a></li>
                                    <li><a href="{{ route('manage.dnd.list',['type'=>'loanagent']) }}">Loan Agent DND List</a></li>
                                </ul>
                            </li>
                        @endif
                        @if(!in_array(Auth::user()->role, [1]))
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.sendotps') }}">
                                    <i data-feather="loader"></i>
                                    <span class="">Send OTPs</span>
                                </a>
                            </li>
                        @endif
                        @if(in_array(Auth::user()->role, [0,1,3,6]))
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.remarketing.log') }}">
                                    <i data-feather="clock"></i>
                                    <span class="">Remarketing Log</span>
                                </a>
                            </li>
                        @endif
                    @endif
                    @if (!in_array(Auth::user()->role, [2,4,5,7]))
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="">Site Options</h6>
                            </div>
                        </li>
                        @if(in_array(Auth::user()->role, [0,1,3,6]))
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.remarks') }}">
                                    <i data-feather="alert-circle"></i>
                                    <span class="">File Remarks</span>
                                </a>
                            </li>
                        @endif
                        @if(!in_array(Auth::user()->role, [1]))
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title" href="javascript:;">
                                    <i data-feather="settings"></i>
                                    <span class="">Site Options</span>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('manage.site-settings') }}">Facebook Settings</a></li>
                                    <li><a href="{{ route('manage.interakt.settings') }}">Interakt Settings</a></li>
                                    <li><a href="{{ route('manage.aisensy.settings') }}">AiSensy Settings</a></li>
                                    <li><a href="{{ route('manage.sms.settings') }}">Sms Settings</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title" href="javascript:;">
                                    <i data-feather="message-circle"></i>
                                    <span class="">Messages</span>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('manage.account-message') }}">Customer A/c Message</a></li>
                                    <li><a href="{{ route('manage.welcome-message') }}">HomePage Message</a></li>
                                    <li><a href="{{ route('manage.important.updates') }}">Site Imp. Updates</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-list">
                                <i class="fa fa-thumb-tack"></i>
                                <a class="sidebar-link sidebar-title" href="javascript:;">
                                    <i data-feather="file"></i>
                                    <span class="">Pages</span>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('manage.privacy-policy') }}">Privacy Policy</a></li>
                                    <li><a href="{{ route('manage.refund-policy') }}">Refund Policy</a></li>
                                    <li><a href="{{ route('manage.disclaimer') }}">Disclaimer</a></li>
                                    <li><a href="{{ route('manage.terms-conditions') }}">Terms &amp; Conditions</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.staff.account') }}">
                                    <i data-feather="users"></i>
                                    <span class="">Staff Account</span>
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</div>
