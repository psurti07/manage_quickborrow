<div class="modal fade" id="addRemarks" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Remark</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('manage.remarks.save')}}" class="save-remarks-form" id="save-remarks-form" method="post">
                <div class="modal-body">
                    <input type="hidden" name="rec_date" value="{{ date('Y-m-d H:i:s') }}">
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label>Status<span class="text-danger">*</span></label>
                            <select class="form-control input-air-primary form-select" name="statusid" id="statusid">
                                <option value="" selected disabled>Select Status</option>
                                @foreach($statuses as $id => $status)
                                <option value="{{ $id }}">{{ $status }}</option>
                                @endforeach
                            </select>
                            @component('components.ajax-error', ['field' => 'status'])@endcomponent
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label>Title<span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-air-primary" name="title" id="title" value="{{old('title')}}" placeholder="Title">
                            @component('components.ajax-error',['field'=>'title'])@endcomponent
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label>Remarks<span class="text-danger">*</span></label>
                            <textarea class="form-control input-air-primary"
                                name="remarks" id="remarks" placeholder="Remarks" rows="10">{{ old('remarks') }}
                            </textarea>
                            @component('components.ajax-error', ['field' => 'remarks'])@endcomponent
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="remark-btn" class="btn btn-outline-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.save-remarks-form').submit(function(event) {
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
                success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $('#addRemarks').modal('hide');
                        $('#remarks-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(result.message);
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
                }
            });
        }
    });
</script>