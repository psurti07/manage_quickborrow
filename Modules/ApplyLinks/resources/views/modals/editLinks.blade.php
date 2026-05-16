<div class="modal fade" id="editLinks" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Links</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('manage.apply.links.update')}}" class="update-links-form" id="update-links-form" method="post">
                <input type="hidden" name="id" value="{{$result['id']}}">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="form-group col-md-6">
                            <label for="bankid">Bank<span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="bankid" id="bankid">
                                <option value="">Select Bank</option>
                                @foreach($banks as $bnk)
                                    <option value="{{ $bnk->id }}" {{ $bnk->id == $result['bankid'] ? 'selected' : '' }}>{{ $bnk->bank_name }}</option>
                                @endforeach
                            </select>
                            @component('components.ajax-error',['field'=>'bankid'])@endcomponent
                        </div>
                        <div class="form-group col-md-6">
                            <label for="roi">ROI<span class="text-danger">*</span></label>
                            <small>(In %)</small>
                            <input type="number" class="form-control" step="0.5" name="roi" id="roi" min="7" max="40" value="{{$result['roi']}}">
                            @component('components.ajax-error',['field'=>'roi'])@endcomponent
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tenures">Loan Tenures<span class="text-danger">*</span></label>
                            <small>(In months)</small>
                            <input type="number" class="form-control" step="1" name="tenures" id="tenures" min="12" max="60" value="{{$result['tenures']}}">
                            @component('components.ajax-error',['field'=>'tenures'])@endcomponent
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="checkbox-checked">
                                <label>Type</label>
                                <div class="form-check-size">
                                    <div class="form-check form-check-inline radio radio-primary">
                                        <input class="form-check-input" id="radioinline1" type="radio" name="status_type" value="1" {{ $result['status_type'] == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label mb-0" for="radioinline1">Salaried</label>
                                    </div>
                                    <div class="form-check form-check-inline radio radio-primary">
                                        <input class="form-check-input" id="radioinline2" type="radio" name="status_type" value="2" {{ $result['status_type'] == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label mb-0" for="radioinline2">Self Employed</label>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group col-md-6">
                            <label for="option1">Point 1</label>
                            <input type="text" class="form-control" name="option1" id="option1" value="{{ $result['option1'] }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="option2">Point 2</label>
                            <input type="text" class="form-control" name="option2" id="option2" value="{{ $result['option2'] }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="option3">Point 3</label>
                            <input type="text" class="form-control" name="option3" id="option3" value="{{ $result['option3'] }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="option4">Point 4</label>
                            <input type="text" class="form-control" name="option4" id="option4" value="{{ $result['option4'] }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="option5">Point 5</label>
                            <input type="text" class="form-control" name="option5" id="option5" value="{{ $result['option5'] }}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="title">Title<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ $result['title'] }}">
                            @component('components.ajax-error',['field'=>'title'])@endcomponent
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <label for="roi">Apply Url<span class="text-danger">*</span></label>
                            <textarea name="applyurl" class="form-control" placeholder="" id="applyurl">{{$result['applyurl']}}</textarea>
                            @component('components.ajax-error',['field'=>'applyurl'])@endcomponent
                        </div>
                        @foreach($criterias as $criteria)
                        <div class="form-group col-md-4">
                            <input class="form-check-input" id="flexCheckDefault{{ $loop->iteration }}" type="checkbox" value="{{ $criteria->id }}"  {{ in_array($criteria->id,$checkedCriteria) ? 'checked' : '' }} name="criteria[]">
                            <label class="form-check-label" for="flexCheckDefault{{ $loop->iteration }}">&nbsp;{{ $criteria->criteria }}</label>
                        </div>
                        @endforeach
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="flexSwitchCheckChecked" type="checkbox" role="switch" {{ $result['is_recommended'] == 1 ? 'checked=checked' : '' }} name="is_recommended" value="1">
                            <label class="form-check-label" for="flexSwitchCheckChecked">Highly Recommended</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="links-btn" class="btn btn-outline-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.update-links-form').submit(function (event) {
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
                        $('#editLinks').modal('hide');
                        $('#applylinks-table').DataTable().ajax.reload();
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
