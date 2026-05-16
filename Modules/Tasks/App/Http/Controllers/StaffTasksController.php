<?php

namespace Modules\Tasks\App\Http\Controllers;

use App\DataTables\InhouseDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Auth\App\Models\Administrations;
use Modules\Tasks\App\Models\StaffTask;

class StaffTasksController extends Controller
{
    public function index(InhouseDataTable $dataTable){
        return $dataTable->render('tasks::stafftasks');
    }

    public function create(){
        $assignees = Administrations::where('role',1)->where('isActive',1)->where('isDelete',0)->get();
        $followers = Administrations::where('role',3)->where('isActive',1)->where('isDelete',0)->get();
        return view('tasks::modals.staffTaskCreate',compact('assignees','followers'));
    }

    public function store(Request $request){
        $input = $request->all();
        $request->validate([
            'task_title' => 'required',
            'task_desc' => 'required',
            'assignee_id' => 'required',
            'follower_id' => 'required',
            'priority' => 'required',
            'task_module' => 'required',
            'task_status' => 'required',
            'projects' => 'required',
            'task_goal' => 'required',
        ],[
            'task_desc.required' => 'The task description field is required',
            'assignee_id.required' => 'The assignees field is required',
            'follower_id.required' => 'The followers field is required',
        ]);
        if ($request->hasFile('attachment')) {
            $request->validate([
                'attachment' => 'mimes:jpeg,png,jpg|max:5120|required'
            ],[
                'attachment.mimes' => 'The uploaded file must be a JPG, JPEG or PNG image.',
                'attachment.uploaded' => 'The uploaded file may not be greater than 5 MB in size.',
            ]);
            $image = $request->file('attachment');
            $image_name = time() . '.' . $request->attachment->extension();
            $path = public_path('upload/tasks');
            $dest = $image->move($path, $image_name);
            $input['attachment'] = $image_name;
        }
        $result = StaffTask::create($input);
        if($result){
            return response()->json(['type'=>'SUCCESS','message'=>'Task added successfully','data'=>'']);
        } else {
            return response()->json(['type'=>'ERROR','message'=>'Something went wrong','data'=>'']);
        }
    }

    public function statusChange(Request $request){
        $input = $request->all();
        $result = StaffTask::where('id', $input['id'])->first();
        StaffTask::where('id', $result['id'])->update(['task_status'=>$input['status']]);
        $message = 'Status changed successfully';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }
}
