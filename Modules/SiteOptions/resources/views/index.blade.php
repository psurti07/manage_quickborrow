@extends('layouts.manage')
@section('title', 'Site Settings')

@push('css-links')
@endpush
@push('style-css')
<style>
    .custom-rounded {
        border-radius: 10px;
    }
</style>
@endpush

@section('breadcrumb-title')
<h3>Site Message</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
<li class="breadcrumb-item active">Site Message</li>
@endsection

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Self Apply Facebook Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="border custom-rounded">
                                <div class="card-header">
                                    <h6 class="card-title">Key Settings</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ route('manage.sitesettings.update-key') }}" class="needs-validation theme-form" novalidate="">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="form-group">
                                                <label for="fbdomainid">Facebook Domain Verification ID</label>
                                                <input type="text" class="form-control" name="fbdomainid" id="fbdomainid" placeholder="Facebook Domain Verification Id" value="{{$fbDomain}}">
                                                @component('components.error',['field'=>'fbdomainid'])@endcomponent
                                            </div>
                                            <div class="form-group">
                                                <label for="fbpixelkey">Facebook Pixel Key</label>
                                                <input type="text" class="form-control" name="fbpixelkey" id="fbpixelkey" placeholder="Facebook Pixel Key" value="{{ $fbPixelKey }}">
                                                @component('components.error',['field'=>'fbpixelkey'])@endcomponent
                                            </div>
                                            <div class="col-12 mt-3">
                                                <button type="submit" class="btn btn-outline-primary">Update Key Settings</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border custom-rounded">
                                <div class="card-header">
                                    <h6 class="card-title">Event Settings</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ route('manage.sitesettings.update-event') }}" class="needs-validation theme-form" novalidate="">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="form-group">
                                                <label for="fbaccesstoken">Facebook Access Token</label>
                                                <input type="text" class="form-control" name="fbaccesstoken" id="fbaccesstoken" placeholder="Facebook Access Token" value="{{ $fbAccessToken }}">
                                                @component('components.error', ['field' => 'fbaccesstoken'])@endcomponent
                                            </div>
                                            <div class="form-group">
                                                <label for="fbeventname">Facebook Event Name</label>
                                                <input type="text" class="form-control" name="fbeventname" id="fbeventname" placeholder="Facebook Event Name" value="{{ $fbEventName }}">
                                                @component('components.error', ['field' => 'fbeventname'])@endcomponent
                                            </div>
                                            <div class="form-group">
                                                <label for="fbeventid">Facebook Event ID</label>
                                                <input type="text" class="form-control" name="fbeventid" id="fbeventid" placeholder="Facebook Event ID" value="{{ $fbEventId }}">
                                                @component('components.error', ['field' => 'fbeventid'])@endcomponent
                                            </div>
                                            <div class="col-12 mt-3">
                                                <button type="submit" class="btn btn-outline-primary">Update Event Settings</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Parent Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title ">Loan Agent Facebook Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                             <div class="border custom-rounded">
                                <div class="card-header">
                                    <h6 class="card-title">Key Settings</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ route('manage.sitesettings.loan-update-key') }}" class="needs-validation theme-form" novalidate="">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="form-group">
                                                <label for="loanfbdomainid">Facebook Domain Verification ID</label>
                                                <input type="text" class="form-control" name="loanfbdomainid" id="loanfbdomainid" placeholder="Facebook Domain Verification ID" value="{{ $loanfbDomain }}">
                                                @component('components.error', ['field' => 'loanfbdomainid'])@endcomponent
                                            </div>
                                            <div class="form-group">
                                                <label for="loanfbpixelkey">Facebook Pixel Key</label>
                                                <input type="text" class="form-control" name="loanfbpixelkey" id="loanfbpixelkey" placeholder="Facebook Pixel Key" value="{{ $loanfbPixelKey }}">
                                                @component('components.error', ['field' => 'loanfbpixelkey'])@endcomponent
                                            </div>
                                            <div class="col-12 mt-3">
                                                <button type="submit" class="btn btn-outline-primary">Update Key Settings</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="border custom-rounded">
                                <div class="card-header">
                                    <h6 class="card-title">Event Settings</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ route('manage.sitesettings.loan-update-event') }}" class="needs-validation theme-form" novalidate="">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="form-group">
                                                <label for="loanfbaccesstoken">Facebook Access Token</label>
                                                <input type="text" class="form-control" name="loanfbaccesstoken" id="loanfbaccesstoken" placeholder="Facebook Access Token" value="{{ $loanfbAccessToken }}">
                                                @component('components.error', ['field' => 'loanfbaccesstoken'])@endcomponent
                                            </div>
                                            <div class="form-group">
                                                <label for="loanfbeventname">Facebook Event Name</label>
                                                <input type="text" class="form-control" name="loanfbeventname" id="loanfbeventname" placeholder="Facebook Event Name" value="{{ $loanfbEventName }}">
                                                @component('components.error', ['field' => 'loanfbeventname'])@endcomponent
                                            </div>
                                            <div class="form-group">
                                                <label for="loanfbeventid">Facebook Event ID</label>
                                                <input type="text" class="form-control" name="loanfbeventid" id="loanfbeventid" placeholder="Facebook Event ID" value="{{ $loanfbEventId }}">
                                                @component('components.error', ['field' => 'loanfbeventid'])@endcomponent
                                            </div>
                                            <div class="col-12 mt-3">
                                                <button type="submit" class="btn btn-outline-primary">Update Event Settings</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script-src')
@endpush
@push('script-tag')
@if(Session::has('success'))
<script>
    toastr.success('{{Session::get('success')}}')
</script>
@endif
@if(session('error'))
<script>
    toastr.error('{{Session::get('error')}}')
</script>
@endif
@endpush