<div class="modal fade" id="leadDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Channel Partner Leads Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="badge badge-warning">Personal Details</div>
                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label>First Name :- <b>{{ $partner->first_name }}</b></label>
                    </div>
                    <div class="col-md-4">
                        <label>Last Name :- <b>{{ $partner->last_name }}</b></label>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label>Email :- <b>{{ $partner->email }}</b></label>
                    </div>
                    <div class="col-md-4">
                        <label>Mobile :- <b>+91 {{ substr($partner->mobile,0,5).' '.substr($partner->mobile,5) }}</b></label>
                    </div>
                </div>
                <hr/>
                <div class="badge badge-warning">Company Details</div>
                <div class="row g-3 mt-2">
                    <div class="col-md-2">
                        <label>Company Code :- <b>{{ $partner->company_code }}</b></label>
                    </div>
                    <div class="col-md-4">
                        <label>Company Name :- <b>{{ $partner->company_name }}</b></label>
                    </div>
                    <div class="col-md-4">
                        <label>Company Mobile :- <b>+91 {{ substr($partner->phone,0,5).' '.substr($partner->phone,5) }}</b></label>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                        <label>City :- <b>{{ $partner->city }}</b></label>
                    </div>
                    <div class="col-md-3">
                        <label>State :- <b>{{ $partner->state }}</b></label>
                    </div>
                    <div class="col-md-3">
                        <label>Pincode :- <b>{{ $partner->pincode }}</b></label>
                    </div>
                    <div class="col-md-3">
                        <label>Website :- <b>{{ $partner->website }}</b></label>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label>Address :- <b>{{ $partner->address }}</b></label>
                    </div>
                    <div class="col-md-4">
                        <label>VAT/GST No :- <b>{{ $partner->vat_gst_no }}</b></label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-outline-primary" id="activate-Btn" data-userid="{{$partner->id}}" type="button">Activate Partner Account</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#activate-Btn").on('click', function(){
            var userid = $(this).data('userid');
            var msg = 'You want to activate this account.';
            var txtx = 'Activate Partner Account';
            swal({
                title: "Are you sure?",
                text: `${msg}`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: ["No","Yes"],
            }).then((performYes) => {
                if (performYes) {
                    $.ajax({
                        url: `{{ route('manage.channelpartner.account.deactivate') }}`,
                        type: `POST`,
                        data: JSON.stringify({userid: userid, status: 1}),
                        contentType: "application/json",
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        beforeSend: function() {
                            $(this).html(`<span class="spinner-border spinner-border-sm"></span> ${txtx} `);
                            $(this).attr('disabled', true);
                        },
                        success: function (result) {
                            if (result.type === 'SUCCESS') {
                                toastr.success(result.message);
                                var baseUrl = "{{ route('manage.channelpartner.details', ['id' => '__id__']) }}";
                                let url = baseUrl.replace('__id__', result.data);
                                window.location.href = `${url}`;
                            } else {
                                toastr.error(result.message);
                            }
                        }
                    })
                }
            });
        })
    })
</script>
