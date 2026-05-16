<div class="modal fade" id="editCareers" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Careers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('manage.careers.update')}}" class="update-careers-form" id="update-careers-form" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{$data['id']}}">
                    <input type="hidden" name="rec_date" value="{{ date('Y-m-d H:i:s') }}">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="title">Job Title<span class="text-danger">*</span></label>
                                <textarea name="title" class="form-control" placeholder="Job Title" id="title">{{$data['title']}}</textarea>
                                @component('components.ajax-error',['field'=>'title'])@endcomponent
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="descriptions">Job Description<span class="text-danger">*</span></label>
                                <textarea name="descriptions" class="form-control" placeholder="Job Description" id="descriptions">{{$data['descriptions']}}</textarea>
                                @component('components.ajax-error',['field'=>'descriptions'])@endcomponent
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="careers-btn" class="btn btn-outline-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace( 'descriptions');
    $('.update-careers-form').submit(function (event) {
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
                    success: function (result) {
                        $(this).attr("disabled", false);
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            $('#editCareers').modal('hide');
                            $('#careers-table').DataTable().ajax.reload();
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
