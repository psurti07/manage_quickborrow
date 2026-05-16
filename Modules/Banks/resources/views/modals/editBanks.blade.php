<div class="modal fade" id="editBanks" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Banks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('manage.banks.update')}}" class="update-banks-form" id="update-banks-form" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{$data['id']}}">
                    <input type="hidden" name="rec_date" value="{{ date('Y-m-d H:i:s') }}">
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label>Bank Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-air-primary" name="bank_name" id="bank_name" value="{{$data['bank_name']}}" placeholder="Bank Name">
                            @component('components.ajax-error',['field'=>'bank_name'])@endcomponent
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label>Order No<span class="text-danger">*</span></label>
                            <input type="number" min="0" step="1" class="form-control input-air-primary" name="order_no" id="order_no" value="{{$data['order_no']!=''?$data['order_no']:0}}" placeholder="Order No">
                            @component('components.ajax-error',['field'=>'order_no'])@endcomponent
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Bank Logo<span class="text-danger">*</span></label>
                            <span class="text-danger"><small><br/>Please accept only .jpg, .png, .jpeg</small></span>
                            <span class="text-danger mt-0"><small><br/>Please upload less than or equals to 1MB file</small></span>
                            <input type="file" id="bank_image" name="bank_image" class="form-control" accept="image/png,image/jpg,image/jpeg">
                            @component('components.ajax-error',['field'=>'bank_image'])@endcomponent
                        </div>
                        <div class="form-group col-md-6">
                            <img src="{{$data['bank_image']!=''?asset('upload/banks/'.$data['bank_image']):'https://docutils.sourceforge.io/sandbox/py-rest-doc/sphinx/style/preview.png'}}" width="150px" id="imgpreview" class="mt-3">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="banks-btn" class="btn btn-outline-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.update-banks-form').submit(function (event) {
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
                        $('#editBanks').modal('hide');
                        $('#banks-table').DataTable().ajax.reload();
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

    // img preview
    $("#bank_image").change(function(){
        const file = this.files[0];
        if (file){
            let reader = new FileReader();
            reader.onload = function(event){
                $('#imgpreview').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
