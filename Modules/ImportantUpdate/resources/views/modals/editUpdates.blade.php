<div class="modal fade" id="editUpdates" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Important Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('manage.important.update.update')}}" class="update-remarks-form" id="update-remarks-form" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{$data['id']}}">
                    <input type="hidden" name="rec_date" value="{{ date('Y-m-d H:i:s') }}">
                    <div class="row">
                        <div class="form-group col-md-12 mb-3">
                            <label>Tags<span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-air-primary" name="tags" id="tags" value="{{$data['tags']}}" placeholder="Tag">
                            @component('components.ajax-error',['field'=>'tags'])@endcomponent
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label>Description<span class="text-danger">*</span></label>
                            <textarea class="form-control input-air-primary"
                                name="descriptions" id="descriptions" rows="10" placeholder="Description">{{ $data['descriptions'] }}
                            </textarea>
                            @component('components.ajax-error', ['field' => 'descriptions'])@endcomponent
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="remark-btn" class="btn btn-outline-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace( 'descriptions');
    $('.update-remarks-form').submit(function(event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var editor = CKEDITOR.instances['descriptions'];
            editor.updateElement();
            var data = new FormData(this);
            data.append('descriptions', $('#descriptions').val());
            $.ajax({
                url: $(this).attr("action"),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                beforeSend: function(){
                    $('#remark-btn').html('<span class="spinner-border spinner-border-sm"></span> Update');
                    $('#remark-btn').attr('disabled', true);
                },
                success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $('#editUpdates').modal('hide');
                        $('#importantupdate-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(result.message);
                        $('#remark-btn').html('Update');
                        $('#remark-btn').attr('disabled', false);
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
                    $('#remark-btn').html('Update');
                    $('#remark-btn').attr('disabled', false);
                }
            });
        }
    });
</script>
