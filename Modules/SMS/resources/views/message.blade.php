@extends('layouts.manage')
@section('title', 'Sms Message')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
    <h3>SMS Message</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">SMS Message</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-2 position-relative">
                <label class="form-label">Product</label>
                <select class="form-select" name="product" id="product">
                    <option value="" selected>All</option>
                    <option value="1">Self Apply</option>
                    <option value="2">Loan Agent</option>
                    <option value="3">Common</option>
                </select>
            </div>
            <div class="col-md-2 position-relative">
                <button type="button" class="mt-4 btn btn-outline-primary" id="dateBtn">Show</button>
            </div>
            <div class="col-md-2 position-relative">
                <a href="javascript:;" onclick="openModal()" class="mt-4 btn btn-outline-primary" id="testBtn"><i class="fa fa-send-o"></i>&nbsp;Test SMS</a>
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
    <div class="addMessageModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        function editModal(messageid) {
            $.ajax({
                url: "sms-message-edit/" + messageid,
                type: 'GET',
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    $('.addMessageModals').html(result);
                    $('#editSms').modal('show');
                }
            });
        }
        
        function openModal(){
            $.ajax({
                url: "https://manage.easyailoans.com/sms/send-test-sms",
                type: 'GET',
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    $('.addMessageModals').html(result);
                    $('#sendTestMsg').modal('show');
                }
            });
        }

        const table = $("#smsmessage-table");
        table.on('preXhr.dt',function(e, settings, data){
            data.products = $("#product").val();
        });
        $('#dateBtn').on('click',function () {
            table.DataTable().ajax.reload();
            return false;
        })
    </script>
@endpush
