@extends('layouts.manage')
@section('title', str_ireplace('_',' ',$offerName))

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush
@push('style-css')
<style>
    .swal-title {
        font-size: 20px
    }
    #offers-table_length{
        margin-left: 50px;
    }
</style>
@endpush

@section('breadcrumb-title')
<h3>{{ str_ireplace('_',' ',$offerName) }}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
<li class="breadcrumb-item active">{{ str_ireplace('_',' ',$offerName) }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3">
        <div class="col-md-2 position-relative">
            <label class="form-label">From Date</label>
            <input class="form-control" type="date" name="fromdate" id="fromdate" value="{{ date('Y-m-d',strtotime('-2 days')) }}">
        </div>
        <div class="col-md-2 position-relative">
            <label class="form-label">To Date</label>
            <input class="form-control" type="date" name="todate" id="todate" value="{{ date('Y-m-d') }}">
        </div>
        <div class="col-md-2 position-relative">
            <button type="button" class="mt-4 btn btn-outline-primary" id="dateBtn">Show</button>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-src')
@include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
<script>
    function convert(offer_id, msg, status) {
        swal({
            title: "Are you sure?",
            text: `${msg}`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel", "Confirm"],
        }).then((willConvert) => {
            if (willConvert) {
                $.ajax({
                    url: '{!! route('manage.offers.convert')  !!}',
                    type: 'POST',
                    data: JSON.stringify({
                        id: offer_id,
                        status: status
                    }),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $(`#btn-${offer_id}`).html(`<span class="spinner-border spinner-border-sm"></span>`);
                        $(`#btn-${offer_id}`).attr('disabled', true);
                    },
                    success: function(result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            $('#offers-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        });
    }

    $(document).on("init.dt",'#offers-table', function() { // Ensures full page load
        let today = new Date();
        let twoDaysBefore = new Date();
        twoDaysBefore.setDate(today.getDate() - 2);

        let formatDate = (date) => date.toISOString().split('T')[0]; // Format YYYY-MM-DD

        let fromDate = sessionStorage.getItem('from_date') || new URLSearchParams(window.location.search).get('from_date') || formatDate(twoDaysBefore);
        let toDate = sessionStorage.getItem('to_date') || new URLSearchParams(window.location.search).get('to_date') || formatDate(today);
        
        // Set date input fields
        $('#fromdate').val(fromDate);
        $('#todate').val(toDate);
    
        let table = $("#offers-table").DataTable(); // Get existing DataTable instance

        table.on('preXhr.dt', function(e, settings, data) {
            data.start_date = $("#fromdate").val();
            data.end_date = $("#todate").val();
        });

        // 🚀 Reload only if session storage had data
        if (sessionStorage.getItem('from_date') || sessionStorage.getItem('to_date')) {
            setTimeout(() => {
                table.ajax.reload(null, false);
            }, 500); // Delay reload slightly after full page load
        }

        // Remove session storage after setting values
        sessionStorage.removeItem('from_date');
        sessionStorage.removeItem('to_date');

        // Click event for manually refreshing the table
        $('#dateBtn').on('click', function() {
            table.ajax.reload(null, false);
            return false;
        });
    });
</script>
@endpush