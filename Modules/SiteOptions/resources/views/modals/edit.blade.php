<div class="modal fade" id="interaktModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Interakt Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('manage.interakt.settings.update')}}" class="save-interakt-form" id="save-interakt-form" method="post">
                <input type="hidden" value="{{ $data->id }}" name="id">
                <div class="modal-body">
                    <div class="row">
                        <dl class="row">
                            <dd class="col-md-3">Product :</dd>
                            <dt class="col-md-3">{{ (($data->product == 'SA') ? 'Self Apply' : 'Loan Agent') }}</dt>
                            <dd class="col-md-3">Type :</dd>
                            <dt class="col-md-3">{{ $data->type }}</dt>
                        </dl>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="template_name">Template Name<span class="text-danger">*</span></label>
                                <input type="text" name="template_name" class="form-control" placeholder="" id="template_name" value="{{ $data->template_name ?? old('template_name')}}">
                                @component('components.ajax-error',['field'=>'template_name'])@endcomponent
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="img_url">Image URL<span class="text-danger">*</span></label>
                                <textarea name="img_url" rows="8" class="form-control" placeholder="" id="img_url">{{ $data->img_url ?? old('img_url')}}</textarea>
                                @component('components.ajax-error',['field'=>'img_url'])@endcomponent
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="api_key">API Key<span class="text-danger">*</span></label>
                                <textarea name="api_key" rows="3" class="form-control" placeholder="" id="api_key">{{ $data->api_key ?? old('api_key') }}</textarea>
                                @component('components.ajax-error',['field'=>'api_key'])@endcomponent
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="account-btn" class="btn btn-outline-primary">Update Interakt Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.save-interakt-form').submit(function (event) {
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
                beforeSend:function(){
                    $('#account-btn').html('<span class="spinner-border spinner-border-sm"></span> Processing...');
                    $('#account-btn').attr('disabled', true);
                },
                success: function (result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $('#interaktModal').modal('hide');
                        $('#interaktsettings-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(result.message);
                        $('#account-btn').html('Update Interakt Settings');
                        $('#account-btn').attr('disabled', false);
                    }
                },
                error: function (error) {
                    $(this).attr("disabled", false);
                    let errors = error.responseJSON.errors, errorsHtml = '';
                    $.each(errors, function (key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    $('#account-btn').html('Update Interakt Settings');
                    $('#account-btn').attr('disabled', false);
                }
            });
        }
    });
</script>
