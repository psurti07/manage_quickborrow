<div class="modal fade" id="ticket-details" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog  modal-lg" style="max-width:1140px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Support Request Ticket Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 col-lg-5 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item"> Ticket no :&nbsp;<b>{{ $supportDetails->ticketno }}</b></li>
                                    <li class="list-group-item"> Request Date :&nbsp;<b>{{ date('d-m-Y H:i', strtotime($supportDetails->rec_date)) }}</b></li>
                                    <li class="list-group-item"> User Type :&nbsp;<b>{{ (($supportDetails->usertype==1) ? 'Customer' : 'Guest User') }}</b></li>
                                    <li class="list-group-item"> Fullname :&nbsp;<b>{{ $supportDetails->firstname.' '.$supportDetails->lastname }}</b></li>
                                    <li class="list-group-item"> Mobile :&nbsp;<b>{{ $supportDetails->mobile }}</b></li>
                                    <li class="list-group-item"> Email :&nbsp;<b>{{ $supportDetails->email }}</b></li>
                                    <li class="list-group-item"> Issue Type :&nbsp;<b>{{ $supportDetails->issuetype }}</b></li>
                                    <li class="list-group-item"> Card/Plan No :&nbsp;<b>{{ $supportDetails->cardnumber }}</b></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-7 col-lg-7 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="btn-group mb-3">
                                    <button class="btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Status</button>
                                    <ul class="dropdown-menu dropdown-block" style="">
                                        <li><a class="dropdown-item text-dark" href="javascript:;" onclick="changeStatus(1,{{ $supportDetails->id }})">Open</a></li>
                                        <li><a class="dropdown-item text-dark" href="javascript:;" onclick="changeStatus(2,{{ $supportDetails->id }})">Processing</a></li>
                                        <li><a class="dropdown-item text-dark" href="javascript:;" onclick="changeStatus(3,{{ $supportDetails->id }})">Closed - No response</a></li>
                                        <li><a class="dropdown-item text-dark" href="javascript:;" onclick="changeStatus(4,{{ $supportDetails->id }})">Solved</a></li>
                                    </ul>
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item" id="current-status">
                                        @php
                                            switch ($supportDetails->status) {
                                                  case '1':
                                                    echo '<p class="badge-default badge-info text-center text-white">Ticket is currently open.</p>';
                                                    break;

                                                  case '2':
                                                    echo '<p class="badge-default badge-danger text-center text-white">Ticket is under processing.</p>';
                                                    break;

                                                  case '3':
                                                    echo '<p class="badge-default badge-warning text-center text-white">Ticket is closed, due to no customer response.</p>';
                                                    break;

                                                  case '4':
                                                    echo '<p class="badge-default badge-success text-center text-white">Ticket is successfully resolved.</p>';
                                                    break;
                                                }
                                        @endphp
                                    </li>
                                    <li class="list-group-item text-danger text-break">
                                        Customer : <br/>
                                        <strong>{{ $supportDetails->message }}</strong>
                                    </li>
                                    @if(count($staffReply))
                                        @foreach ($staffReply as $row)
                                            <li class="list-group-item">
                                                {{ $row->staff->fullname }} - <small><em>{{ DateFormatDisplay($row->rec_date) }}</em></small><br/>
                                                <b>{{ $row->remarks }}</b>
                                            </li>
                                        @endforeach
                                    @endif
                                    <p id="remarksdetails"></p>
                                </ul>
                                <form method="post" action="{{ route('manage.supportrequest.addSupportRemarks') }}" id = "submitForm" class = "form-horizontal">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <input type="hidden" name="requestid" id="requestid" value="{{ $supportDetails->id }}">
                                            <div class="form-group">
                                                <textarea class="form-control" name="remarks" id="remarks" placeholder="Staff Remark" aria-describedby="button-addon6"></textarea>
                                                @component('components.ajax-error',['field'=>'remarks'])@endcomponent
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-outline-success add-remarks">Add Remarks</button>
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
<script>
    function changeStatus(status, supportId){
        $.ajax({
            url: `{!! route('manage.supportrequest.changeSupportStatus') !!}`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: {status:status, supportId:supportId},
            success: function(result){
                if (result.type === 'SUCCESS') {
                    $('#current-status').html("");
                    let statusText = "";
                    let statusClass = "";

                    switch (result.data) { // Access the 'status' property from your JSON data
                        case '1':
                            statusText = "Ticket is currently open.";
                            statusClass = "badge-info";
                            break;
                        case '2':
                            statusText = "Ticket is under processing.";
                            statusClass = "badge-danger";
                            break;
                        case '3':
                            statusText = "Ticket is closed, due to no customer response.";
                            statusClass = "badge-warning";
                            break;
                        case '4':
                            statusText = "Ticket is successfully resolved.";
                            statusClass = "badge-success";
                            break;
                        default: // Handle any other cases or errors
                            statusText = "Unknown Status";
                            statusClass = "badge-secondary"; // Or another appropriate class
                    }

                    let html = `<li class="list-group-item" id="current-status">
                        <p class="badge-default ${statusClass} text-center text-white">${statusText}</p>
                    </li>`;
                    $('#current-status').html(html);
                    $("#supportrequest-table").DataTable().ajax.reload()
                    toastr.success(result.message);
                } else {
                    toastr.error(result.message);
                }
            },
        })
    }

    $('#submitForm').submit(function (event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
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
                beforeSend: function () {
                    $('#add-remarks').html("<i class='fa fa-spinner spinner'></i>");
                    $('#add-remarks').attr('disabled', true);
                },
                success: function (result) {
                    $(this).attr("disabled", false);

                    if (result.type === 'SUCCESS') {
                        $('#add-remarks').html("Add Remarks");
                        $('#add-remarks').attr('disabled', false);
                        $('#submitForm')[0].reset();
                        $('#remarksdetails').html("");
                        let html = "";
                        $.each(result.data, function(index, item) { // Assuming 'response.data' is your JSON array
                            html += `<li class='list-group-item'>
                                ${item.staff.fullname} - <small><em>${new Date(item.rec_date).toLocaleDateString()}</em></small><br/>
                                                <b>${item.remarks}</b>
                            </li>`; // Example: Adjust as needed.
                        });
                        $('#remarksdetails').html(html);
                        toastr.success(result.message);
                    } else {
                        $('#add-remarks').html("Add Remarks");
                        $('#add-remarks').attr('disabled', false);
                        toastr.error(result.message);
                    }
                },
                error: function (error) {
                    $(this).attr("disabled", false);
                    let errors = error.responseJSON.errors, errorsHtml = '';
                    $.each(errors, function (key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    $('#add-remarks').html("Add Remarks");
                    $('#add-remarks').attr('disabled', false);
                }
            });
        }
    });
</script>
