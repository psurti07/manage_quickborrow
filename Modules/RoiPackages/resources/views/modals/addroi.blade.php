<div class="modal fade" id="addROI" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add ROI Packages</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('manage.roipackages.store')}}" class="save-roi-form" id="save-roi-form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="bankid">Bank<span class="text-danger">*</span></label>
                                <select class="form-control form-select" name="bankid" id="bankid">
                                    <option value="">Select Bank</option>
                                    @foreach($banks as $bnk)
                                        <option value="{{ $bnk->id }}">{{ $bnk->bank_name }}</option>
                                    @endforeach
                                </select>
                                @component('components.ajax-error',['field'=>'bankid'])@endcomponent
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="roi">ROI<span class="text-danger">*</span><br/><small class="text-danger f-12">eg.,10.00,11.55,..like this</small></label>
                                <input type="text" name="roi" class="form-control" placeholder="" id="roi" value="{{old('roi')}}">
                                @component('components.ajax-error',['field'=>'roi'])@endcomponent
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="termsyears">Terms - Years<span class="text-danger">*</span><br/><small class="text-danger f-12">eg.,5.00,8.00...like this</small></label>
                                <input type="text" name="termsyears" class="form-control" placeholder="" id="termsyears" value="{{old('termsyears')}}">
                                @component('components.ajax-error',['field'=>'termsyears'])@endcomponent
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="termsmonths">Terms - Months<span class="text-danger">*</span><br/><small class="text-danger f-12">eg.,60.00,72.00,..like this</small></label>
                                <input type="text" name="termsmonths" class="form-control" placeholder="" id="termsmonths" value="{{old('termsmonths')}}">
                                @component('components.ajax-error',['field'=>'termsmonths'])@endcomponent
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="roi-btn" class="btn btn-outline-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.save-roi-form').submit(function (event) {
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
                        $('#addROI').modal('hide');
                        $('#roipackages-table').DataTable().ajax.reload();
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
