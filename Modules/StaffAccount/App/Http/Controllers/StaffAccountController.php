<?php

namespace Modules\StaffAccount\App\Http\Controllers;

use App\DataTables\StaffAccountDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\App\Models\Administrations;

class StaffAccountController extends Controller
{
    public function index(StaffAccountDataTable $dataTable){
        return $dataTable->render('staffaccount::index');
    }

    public function create(){
        return view('staffaccount::modals.addStaff');
    }

    public function staffDetails($staffId){
        $staffDetails = Administrations::where('id',$staffId)->first();
        return view('staffaccount::staffdetails',compact('staffDetails'));
    }

    public function store(Request $request){
        $inputs = $request->all();
        $request->validate([
            'role' => 'required',
            'fullname' => 'required',
            'emailid' => 'required|email|unique:administrations,emailid',
            'mobile' => ['required','numeric', 'regex:/^[6-9]\d{9}$/'],
            'password' => 'required|confirmed'
        ]);
        $inputs['password'] = Hash::make($inputs['password']);
        $inputs['role'] = (int)$inputs['role'];
        $inputs['staff_code'] = random_code_num(4);
        unset($inputs['password_confirmation']);
        $result = Administrations::create($inputs);
        $message = 'Staff account created successfully!';
        if($result){
            return response()->json(array('type'=>'SUCCESS','message'=>$message,'data'=>[]));
        } else {
            return response()->json(array('type'=>'ERROR','message'=>'Oops! Something went wrong.','data'=>[]));
        }
    }

    public function destroy(Request $request){
        $input = $request->all();
        $result = Administrations::where('id', $input['userid'])->first();
        if ($result) {
            $res = Administrations::where('id', $result['id'])->update(['isDelete'=>1]);
            if($res > 0){
                $message = 'Staff account deleted successfully!';
                return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
            }
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function statusChange(Request $request){
        $input = $request->all();
        $result = Administrations::where('id', $input['id'])->first();
        Administrations::where('id', $result['id'])->update(['isActive'=>$input['status']==1?0:1]);
        $message = 'Status changed successfully!';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function updatePassword(Request $request){
        $user = Administrations::find($request->input('userid'));
        if($user!=null){
            $request->validate([
                'new_password' => 'required',
                'retype_password' => 'required|same:new_password'
            ]);
            $result = $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            if($result){
                return response()->json(array('type' => 'SUCCESS', 'message' => 'Password updated successfully!', 'data' => []));
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
            }
        }
        else {
            return response()->json(array('type' => 'ERROR', 'message' => 'User not found!', 'data' => []));
        }
    }

    public function deactivateAccount(Request $request){
        $user = Administrations::find($request->input('userid'));
        if($user){
            $updateData = array('isActive'=>$request->input('status'));
            $result = Administrations::where('id',$request->input('userid'))->update($updateData);
            $message = '';
            if($request->input('status') == 1){
                $message = 'Account activated successfully!';
            } else {
                $message = 'Account deactivate successfully!';
            }
            if($result > 0){
                return response()->json(['type'=>'SUCCESS','message'=>$message]);
            } else {
                return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.']);
            }
        } else {
            return response()->json(['type'=>'ERROR','message'=>'Invalid user perform action!']);
        }
    }

    public function updateStaffDetails(Request $request){
        $request->validate([
            'fullname' => 'required',
            'emailid' => 'required|email|unique:administrations,emailid,'.$request->input('userid'),
            'mobile' => ['required','numeric', 'regex:/^[6-9]\d{9}$/'],
        ]);
        $upd = [
            'fullname' => $request->input('fullname'),
            'emailid' => $request->input('emailid'),
            'mobile' => $request->input('mobile'),
            'dob' => $request->input('dob'),
            'position' => $request->input('position'),
            'role' => $request->input('role')!='' ? $request->input('role') : '0',
        ];
        $result = Administrations::where('id',$request->input('userid'))->update($upd);
        if($result > 0){
            return response()->json(array('type'=>'SUCCESS','message'=>'Staff data updated successfully!'));
        } else {
            return response()->json(array('type'=>'ERROR','message'=>'Oops! Something went wrong.'));
        }
    }
}
