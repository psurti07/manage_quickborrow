<div class="modal fade" id="addStaffTasks" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add new task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('manage.staff.tasks.store')}}" class="save-tasks-form" id="save-tasks-form" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{{ date('Y-m-d H:i:s') }}" name="rec_date">
                <div class="modal-body">
                    <div class="row g-3 custom-input">
                        <div class="col-md-6">
                            <label for="rec_date">Start Date <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="rec_date" name="rec_date" value="{{ date('Y-m-d H:i:s') }}" disabled />
                            @component('components.ajax-error',['field'=>'rec_date'])@endcomponent
                        </div>
                        <div class="col-md-6">
                            <label for="completion_date">Completion Date</label>
                            <input type="date" class="form-control" id="completion_date" name="completion_date" value="{{ old('completion_date') }}" />
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
                            <label for="assignee_id">Assignee <span class="text-danger">*</span></label>
                            <select class="form-select" id="assignee_id" name="assignee_id">
                                <option value="">Select Assignee</option>
                                @foreach($assignees as $assignee)
                                    <option value="{{ $assignee->id }}">{{ $assignee->fullname }}</option>
                                @endforeach
                            </select>
                            @component('components.ajax-error',['field'=>'assignee_id'])@endcomponent
                        </div>
                        <div class="col-md-6">
                            <label for="follower_id">Assign To <span class="text-danger">*</span></label>
                            <select class="form-select" id="follower_id" name="follower_id">
                                <option value="">Select Assign To</option>
                                @foreach($followers as $follower)
                                    <option value="{{ $follower->id }}">{{ $follower->fullname }}</option>
                                @endforeach
                            </select>
                            @component('components.ajax-error',['field'=>'follower_id'])@endcomponent
                        </div>
                        <div class="col-md-6">
                            <label>Priority <span class="text-danger">*</span></label>
                            {!! taskPriorityOptions(old('priority')) !!}
                        </div>
                        <div class="col-md-6">
                            <label for="task_module">Task Module <span class="text-danger">*</span></label>
                            <select class="form-select" id="task_module" name="task_module">
                                <option value="">Select Module</option>
                                {!! taskModulesOptions(old('task_module')) !!}
                            </select>
                            @component('components.ajax-error',['field'=>'task_module'])@endcomponent
                        </div>
                        <div class="col-md-12">
                            <label>Task Status <span class="text-danger">*</span></label>
                            {!! taskStatusOptions(old('task_status')) !!}
                        </div>
                        <div class="col-md-12">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarks" placeholder="Staff Remarks" rows="3">{{ old('remarks') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="projects">Projects <span class="text-danger">*</span></label>
                            <select class="form-select" id="projects" name="projects">
                                <option value="">Select Projects</option>
                                {!! projectsOptions(old('projects')) !!}
                            </select>
                            @component('components.ajax-error',['field'=>'projects'])@endcomponent
                        </div>
                        <div class="col-md-6">
                            <label for="task_goal">Tasks Goal <span class="text-danger">*</span></label>
                            <select class="form-select" id="task_goal" name="task_goal">
                                <option value="">Select Task Goal </option>
                                {!! taskGoalOptions(old('task_goal')) !!}
                            </select>
                            @component('components.ajax-error',['field'=>'task_goal'])@endcomponent
                        </div>
                        <div class="col-md-6">
                            <label for="attachment">Attachment</label>
                            <span class="text-danger"><small><br/>Please accept only .jpg, .png, .jpeg</small></span>
                            <span class="text-danger mt-0"><small><br/>Please upload less than or equals to 5MB file</small></span>
                            <input type="file" id="attachment" name="attachment" class="form-control" accept="image/png,image/jpg,image/jpeg">
                            @component('components.ajax-error',['field'=>'attachment'])@endcomponent
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
    CKEDITOR.replace('task_desc');
    $('.save-tasks-form').submit(function (event) {
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
                        $('#addStaffTasks').modal('hide');
                        $('#inhouse-table').DataTable().ajax.reload();
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
