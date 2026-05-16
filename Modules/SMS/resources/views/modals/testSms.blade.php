<div class="modal fade" id="sendTestMsg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send Test Sms</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" class="send-sms-form" id="send-sms-form" action="{{ route('manage.sms.fire.sms') }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12 mb-3">
                            <label>Sms Portal</label>
                            <select class="form-select" name="portal" id="portal">
                                <option value="">Choose Portal</option>
                                <option value="self">Self Apply</option>
                                <option value="hire">Hire Agent</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label>Sender Id's</label>
                            <div class="form-check-size rtl-input">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input me-2" id="inlineRadio1" type="radio" name="senderid" value="EASYAI" checked="">
                                    <label class="form-check-label" for="inlineRadio1">EASYAI</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input me-2" id="inlineRadio2" type="radio" name="senderid" value="AILONS">
                                    <label class="form-check-label" for="inlineRadio2">AILONS</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input me-2" id="inlineRadio3" type="radio" name="senderid" value="ESYAIL">
                                    <label class="form-check-label" for="inlineRadio3">ESYAIL</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label>Mobile<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="mobile" id="mobile" maxlength="10" minlength="10">
                            @component('components.ajax-error',['field'=>'mobile'])@endcomponent
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label>Title<span class="text-danger">*</span></label>
                            <select class="form-select" name="title" id="title">
                                <option value="">Choose Title</option>
                                @foreach($titles as $title)
                                <option value="{{ $title->id }}" data-slug="{{ $title->slug }}">
                                    @php
                                        $titleType = 'Common';
                                        switch($title->type){
                                            case 1:
                                                $titleType = 'Self Apply';
                                                break;
                                            case 2:
                                                $titleType = 'Loan Agent';
                                                break;
                                            default:
                                                $titleType = 'Common';
                                                break;
                                        }
                                    @endphp
                                    {{ $title->title }} - {{ $titleType }}
                                </option>
                                @endforeach
                            </select>
                            @component('components.ajax-error',['field'=>'title'])@endcomponent
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label>Message<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="message" id="message" rows="5"></textarea>
                            @component('components.ajax-error',['field'=>'message'])@endcomponent
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="banks-btn" class="btn btn-outline-primary">Send SMS</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#title").on('change', function(){
        let titleVal = $(this).val();
        if(titleVal){
            $.ajax({
                url: `{{ route('manage.sms.get.title.message') }}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                data: { title: titleVal },
                success: function (result) {
                    if (result.type === 'SUCCESS') {
                        // HTML decode function
                        $("#message").val(result.message)
                    } else {
                        toastr.error(result.message);
                    }
                },
            });
        }
    });
    
    $('.send-sms-form').submit(function (event) {
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
                success: function (result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $('#sendTestMsg').modal('hide');
                        $('#smsmessage-table').DataTable().ajax.reload();
                    } else {
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
                }
            });
        }
    });
</script>
