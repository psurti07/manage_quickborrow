<div class="modal fade" id="addPartnerTasks" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add new task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('manage.partners.tasks.store')}}" class="save-tasks-form" id="save-tasks-form" method="post">
                <input type="hidden" value="{{ date('Y-m-d H:i:s') }}" name="rec_date">
                <div class="modal-body">
                    <div class="row g-3 custom-input">
                        <div class="col-md-6">
                            <label for="rec_date">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="rec_date" name="rec_date" value="{{ date('Y-m-d') }}" disabled />
                            @component('components.ajax-error',['field'=>'rec_date'])@endcomponent
                        </div>
                        <div class="col-md-6">
                            <label for="completion_date">Completion Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="completion_date" name="completion_date" value="{{ old('completion_date') }}" />
                            @component('components.ajax-error',['field'=>'completion_date'])@endcomponent
                        </div>
                        <div class="col-md-12">
                            <label for="task_title">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="task_title" name="task_title" placeholder="Task Title" value="{{ old('task_title') }}" />
                            @component('components.ajax-error',['field'=>'task_title'])@endcomponent
                        </div>
                        <div class="col-md-12">
                            <label for="task_desc">Description <span class="text-danger">*</span></label>
                            <textarea name="task_desc" class="form-control" placeholder="Description" id="task_desc">{{old('task_desc')}}</textarea>
                            @component('components.ajax-error',['field'=>'task_desc'])@endcomponent
                        </div>
                        <div class="col-md-6">
                            <label for="assignees">Assignees <span class="text-danger">*</span></label>
                            <select class="form-select" id="assignees" name="assignees">
                                <option value="">Select Assignees</option>
                                @foreach($assignees as $assignee)
                                <option value="{{ $assignee->id }}">{{ $assignee->fullname }}</option>
                                @endforeach
                            </select>
                            @component('components.ajax-error',['field'=>'assignees'])@endcomponent
                        </div>
                        <div class="col-md-6">
                            <label for="assign_to">Followers <span class="text-danger">*</span></label>
                            <select class="form-select" id="assign_to" name="assign_to">
                                <option value="">Select Follower</option>
                                @foreach($followers as $follower)
                                    <option value="{{ $follower->id }}">{{ $follower->fullname }}</option>
                                @endforeach
                            </select>
                            @component('components.ajax-error',['field'=>'assign_to'])@endcomponent
                        </div>
                        <div class="col-md-6">
                            <label>Priority</label>
                            {!! taskPriorityOptions(old('priority')) !!}
                        </div>
                        <div class="col-md-6">
                            <label for="task_module">Task Module <span class="text-danger">*</span></label>
                            <select class="form-select" id="task_module" name="task_module">
                                <option value="">Select Module</option>
                                {!! taskModulesOptions(old('task_module')) !!}
                            </select>
                            @component('components.ajax-error',['field'=>'assign_to'])@endcomponent
                        </div>
                        <div class="col-md-12">
                            <label>Task Status</label>
                            {!! taskStatusOptions(old('task_status')) !!}
                        </div>
                        <div class="col-md-12">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarks" placeholder="Staff Remarks" rows="3">{{ old('remarks') }}</textarea>
                            @component('components.ajax-error',['field'=>'remarks'])@endcomponent
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="tasks-btn" class="btn btn-outline-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace( 'task_desc');
    $('.save-taks-form').submit(function (event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var editor = CKEDITOR.instances['task_desc'];
            editor.updateElement();
            var data = new FormData(this);
            data.append('task_desc', $('#task_desc').val());
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
                    $('#tasks-btn').html('<span class="spinner-border spinner-border-sm"></span> Add');
                    $('#tasks-btn').attr('disabled', true);
                },
                success: function (result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $('#tasks-btn').modal('hide');
                        $('#partnertasks-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(result.message);
                        $('#tasks-btn').html('Add');
                        $('#tasks-btn').attr('disabled', false);
                    }
                },
                error: function (error) {
                    $(this).attr("disabled", false);
                    let errors = error.responseJSON.errors, errorsHtml = '';
                    $.each(errors, function (key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    $('#tasks-btn').html('Add');
                    $('#tasks-btn').attr('disabled', false);
                }
            });
        }
    });
</script>
