@extends('layouts.manage')
@section('title', 'Search Data')
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
<h3>Search Data</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
<li class="breadcrumb-item active">Search Data</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="border custom-rounded">
                                <div class="card-header">
                                    <h6 class="card-title">Search Data</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ route('manage.searchdata.post') }}" id="searchForm" class="needs-validation theme-form" novalidate="">
                                        @csrf
                                        <div class="card-body p-0">
                                            <div class="row g-3">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="module" id="selfApply" value="1" checked>
                                                        <label class="form-check-label" for="selfApply">
                                                            Self Apply
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="module" id="loanAgent" value="2">
                                                        <label class="form-check-label" for="loanAgent">
                                                            Loan Agent
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <div class="form-group">
                                                        <label for="mobile_no">Mobile No<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile No" maxlength="10" minlength="10">
                                                        @component('components.ajax-error', ['field' => 'mobile_no'])@endcomponent
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <button type="submit" id="submit" class="btn btn-outline-primary">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border custom-rounded">
                                <div class="card-body">
                                    <div class="row g-3" id="dataList">
                                        <div class="card-body p-0">
                                            <p class="text-center text-danger">No data available.</p>
                                        </div>
                                    </div>
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
<script>
    $('.numeric-input').on('keydown', function(event) {
        if (!(event.key === 'Backspace' || event.key === 'Delete' || (event.key >= '0' && event.key <= '9'))) {
            event.preventDefault();
        }
    });
    $(document).ready(function() {
        var searchInput = $('#mobile_no');

        if (searchInput.length > 0) { // Ensure element exists before adding event listeners
            searchInput.on('input', function() {
                var inputVal = $(this).val();
                if (inputVal && inputVal.length === 10 && $.isNumeric(inputVal)) {
                    $('#searchForm').submit();
                }
            });

            searchInput.keypress(function(event) {
                if (event.which === 13) { // Enter key
                    event.preventDefault();
                    $('#searchForm').submit();
                }
            });
        }

        $('#searchForm').submit(function(event) {
            var status = document.activeElement ? document.activeElement.innerHTML : '';
            event.preventDefault();

            if (status || (searchInput.length > 0 && searchInput.val().length === 10)) {
                $('.ajax-error').html('');
                var data = new FormData(this);
                $.ajax({
                    url: $(this).attr("action"),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#submit').html('<span class="spinner-border spinner-border-sm"></span> Submit ');
                        $('#submit').attr('disabled', true);
                    },
                    success: function(result) {
                        if (result.type === 'SUCCESS') {
                            if (result.data !== '') {
                                sessionStorage.setItem('infoId', result.data);
                            }
                            $('#submit').html('Submit');
                            $('#dataList').html(result.html);
                            $('#submit').attr('disabled', false);
                        } else {
                            toastr.error(result.message);
                            $('#dataList').html(`<div class="card-body p-0">
                                                    <p class="text-center text-danger">No data available.</p>
                                                </div>`);
                            $('#submit').html('Submit');
                            $('#submit').attr('disabled', false);
                        }
                    },
                    error: function(error) {
                        $(this).attr("disabled", false);
                        let errors = error.responseJSON.errors,
                            errorsHtml = '';
                        $.each(errors, function(key, value) {
                            errorsHtml = '<strong>' + value[0] + '</strong>';
                            $('.' + key).html(errorsHtml);
                        });
                        $('#dataList').html(`<div class="card-body p-0">
                                                <p class="text-center text-danger">No data available.</p>
                                            </div>`);
                        $('#submit').html('Submit');
                        $('#submit').attr('disabled', false);
                    }
                });
            }
        });
    });


</script>
@endpush
