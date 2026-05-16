@extends('layouts.manage')
@section('title', 'DND List')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
<style>
    #dndlist-table_length{ margin-left:50px; }
</style>
@endpush

@section('breadcrumb-title')
    <h3>DND Lists</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">DND Lists</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-7">
                <div class="row pull-left">
                    <div class="col-md-5 position-relative">
                        <label class="form-label">From Date</label>
                        <input class="form-control" type="date" name="fromdate" id="fromdate" value="{{ date('Y-m-d',strtotime('-7 days')) }}">
                    </div>
                    <div class="col-md-5 position-relative">
                        <label class="form-label">To Date</label>
                        <input class="form-control" type="date" name="todate" id="todate" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-2 position-relative">
                        <button type="button" class="mt-4 btn btn-outline-primary" id="dateBtn">Show</button>
                    </div>
                </div>
            </div>
            <div class="col-md-5 pull-right">
                <div class="d-flex">
                    <div class="col">
                        <input type="file" id="csvFile" name="csv_file" accept=".csv" class="d-none">
                        <button type="button" id="uploadBtn" class="mt-4 btn btn-outline-danger"><i class="fa fa-upload"></i>&nbsp;Upload Data</button>
                        <span id="fileName" class="ml-2 text-muted"></span>
                    </div>
                    <div class="col">
                        <a href="{{ asset('assets/csv/dndfile-sample.csv') }}" target="_blank" type="button" class="mt-4 btn btn-outline-primary" id="downloadBtn"><i class="fa fa-download"></i>&nbsp;Download Sample</a>
                    </div>
                </div>
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
{{ $dataTable->scripts(attributes:['type' => 'module']) }}
<script>
    const table = $("#dndlist-table");
    table.on('preXhr.dt', function(e, settings, data) {
        data.start_date = $("#fromdate").val();
        data.end_date = $("#todate").val();
    });
    $('#dateBtn').on('click', function() {
        table.DataTable().ajax.reload();
        return false;
    })

    $(document).ready(function() {
        // Trigger file input when button is clicked
        $('#uploadBtn').click(function() {
            $('#csvFile').click();
        });

        // Clear file input on click to allow selecting the same file again
        $('#csvFile').on('click', function() {
            $(this).val('');
        });

        $('#csvFile').change(function() {
            var fileName = $(this).val().split('\\').pop();
            if (fileName) {
                $('#fileName').text(fileName).removeClass('text-muted').addClass('text-primary');

                // Auto-process the file after selection
                processCsvFile();
            } else {
                $('#fileName').text('No file chosen').removeClass('text-primary').addClass('text-muted');
            }
        });

        function processCsvFile() {
            var formData = new FormData();
            formData.append('csv_file', $('#csvFile')[0].files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('manage.dnd.list.process.csv') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#uploadBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $('#dndlist-table').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.error || 'Error processing file');
                },
                complete: function() {
                    $('#fileName').text('');
                    $('#uploadBtn').prop('disabled', false).html('<i class="fa fa-upload"></i> Upload Data');
                    $('#csvFile').val(''); // Reset file input to allow re-uploading the same file
                }
            });
        }
    });

     /* destroy the record */
    function destroy(dndId){
        swal({
            title: "Are you sure?",
            text: "You want to remove this record from DND.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel","Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                //var pic = $(this).data('photo')
                $.ajax({
                    url: '{!! route('manage.dnd.list.destroy')  !!}',
                    type: 'POST',
                    data:  JSON.stringify({id: dndId}),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            $('#dndlist-table').DataTable().ajax.reload();
                        } else {
                            toastr.error(result.message);                                
                        }
                    }
                });
            }
        });
    } 
</script>
@endpush