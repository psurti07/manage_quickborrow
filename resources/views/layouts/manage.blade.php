<!DOCTYPE html>
<html lang="en">
    @include('partials.manage.head')
    <body @if(Route::current()->getName() == 'manage.dashboard') onload="startTime()" @endif class="light-sidebar dark">
        {{--<div class="loader-wrapper">
            <div class="loader-index"><span></span></div>
            <svg>
                <defs></defs>
                <filter id="goo">
                    <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                    <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
                </filter>
            </svg>
        </div>--}}
        <!-- tap on top starts-->
        <div class="tap-top"><i data-feather="chevrons-up"></i></div>
        <!-- tap on tap ends-->
        <!-- page-wrapper Start-->
        <div class="page-wrapper compact-wrapper" id="pageWrapper">
            <!-- Page Header Start-->
            @include('partials.manage.header')
            <!-- Page Header Ends  -->
            <!-- Page Body Start-->
            <div class="page-body-wrapper">
                <!-- Page Sidebar Start-->
                @include('partials.manage.sidebar')
                <!-- Page Sidebar Ends-->
                <div class="page-body">
                    <div class="container-fluid">
                        <div class="page-title">
                            <div class="row">
                                <div class="col-6">
                                    @yield('breadcrumb-title')
                                </div>
                                <div class="col-6">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('manage.dashboard')}}">
                                            <svg class="stroke-icon">
                                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                            </svg></a>
                                        </li>
                                        @yield('breadcrumb-items')
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid starts-->
                    @yield('content')
                    <!-- Container-fluid Ends-->
                </div>
                <!-- footer start-->
                @include('partials.manage.footer')
            </div>
        </div>
        @yield('custom-modal')
        <!-- latest jquery-->
        @include('stacks.js.manage.scripts')
        <!-- Plugin used-->
    </body>
</html>
