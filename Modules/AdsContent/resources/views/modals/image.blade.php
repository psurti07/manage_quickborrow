<div class="modal fade" id="addAds" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Ads</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('manage.advertisement.image.save')}}" class="save-banks-form" id="save-banks-form" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <input type="hidden" name="rec_date" value="{{ date('Y-m-d H:i:s') }}">
                    <input type="hidden" name="ad_type" value="2">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <span class="text-danger"><small><br/>Please accept only .jpg, .png, .jpeg</small></span>
                            <span class="text-danger mt-0"><small><br/>Please upload less than or equals to 1MB file</small></span>
                            <input type="file" id="bank_image" name="ad_content" class="form-control" accept="image/png,image/jpg,image/jpeg">
                            @component('components.ajax-error',['field'=>'ad_content'])@endcomponent
                        </div>
                        <div class="form-group col-md-6">
                            <img src="https://docutils.sourceforge.io/sandbox/py-rest-doc/sphinx/style/preview.png" width="150px" id="imgpreview" class="mt-3">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="banks-btn" class="btn btn-outline-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.save-banks-form').submit(function (event) {
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
