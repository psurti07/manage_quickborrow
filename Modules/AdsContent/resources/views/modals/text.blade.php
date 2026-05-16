<div class="modal fade" id="addAds" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Ads</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('manage.advertisement.save')}}" class="save-careers-form" id="save-careers-form" method="post">
                <div class="modal-body">
                    <input type="hidden" name="rec_date" value="{{ date('Y-m-d H:i:s') }}">
                    <input type="hidden" name="ad_type" value="1">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="editor1">Ads Content<span class="text-danger">*</span></label>
                                <textarea name="ad_content" class="form-control" placeholder="Job Description" id="jobdesc"></textarea>
                                @component('components.ajax-error',['field'=>'ad_content'])@endcomponent
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="careers-btn" class="btn btn-outline-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace( 'jobdesc');
    $('.save-careers-form').submit(function (event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var editor = CKEDITOR.instances['jobdesc'];
            editor.updateElement();
            var data = new FormData(this);
            data.append('jobdesc', $('#jobdesc').val());
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
                        $('#addAds').modal('hide');
                        $('#advertisements-table').DataTable().ajax.reload();
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
