<?php

namespace Modules\Loan\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ApplicationRemarks;
use App\Models\LoanApplications;
use App\Models\LoanApplicationStatus;
use App\Models\UserRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Banks\App\Models\Banks;

class LoanStatusController extends Controller
{
    public function addStatus($appId){
        $appdetails = appDetailsWithUser($appId);
        $banklist = Banks::where(['isActive' => 1,'isDelete' => 0])->get();
        $loanstatuslist = DB::table('loanstatus')->orderBy('priorityno','asc')->get();
        return view('loan::pages.addStatus',compact(['appdetails','banklist','loanstatuslist']));
    }

    public function predefineMessage(Request $request){
        if($request->statusId != 0 || $request->statusId != ''){
            $remarksList = DB::table('loanstatus_remarks')->select('title','remarks')->where(['statusid'=>$request->statusId,'isDelete'=>0])->get();
            $options = '<option value="">Select Option</option>';
            foreach($remarksList as $remarks){
                $options.='<option value="'.$remarks->remarks.'">'.$remarks->title.'</option>';
            }
            return response()->json(array('type'=>'SUCCESS','data'=>$options));
        } else {
            return response()->json(array('type'=>'ERROR','data'=>[]));
        }
    }

    public function applicationStatusStore(Request $request){
        $inputs = $request->all();
        $request->validate([
            'subject' => 'required',
            /*'statusid' => 'required',
            'statusdate' => 'required',
            'bankid' => 'required',
            'remarks' => 'required',
            'predefinemessage' => 'required'*/
        ]/*,[
            'statusid.required' => 'Choose first application status',
            'bankid.required' => 'You must choose one banks',
            'predefinemessage.required' => 'Select pre-defined message',
            'remarks.required' => 'Remarks field is required'
        ]*/);
        try{
            $upd = [
                'rec_date' => date('Y-m-d H:i:s'),
                'entry_at' => $request->entry_at,
                'subject' => $request->subject,
                'application_id' => $request->applicationid,
                'staff_id' => Auth::user()->id,
                'service' => (int)$request->process,
                'notes' => $request->notes
            ];
            
            $res = ApplicationRemarks::create($upd);
            if($res){
                $result = UserRegistration::where('id', $request->userid)->update(['update_date'=>date('Y-m-d H:i:s'),'process_step'=>$request->process]);
                if($result){
                    $data3 = array(
                        'phoneNumber' => $request->usermobile,
                        'countryCode' => '+91',
                        'event' => 'Hire_Service_Completed',
                    );
                    $restrack2 = event_track($data3);
                    
                    /* send remarks message starts */
                    $slug = (($request->process == 11) ? 'sales_cycle_closed' : 'app_remarks_add' );
                    $msg = DB::table('sms_list')->where('type',2)->where('slug',$slug)->first()->message;
                    if($msg != '#'){
                        $senderId = DB::table('info_pages')->where('slug','la-senderid')->first()->content;
                        sendDynamicSMS($senderId, $msg, $request->usermobile, 'hire');
                    }
                    /* send remarks message ends */
                    
                    return response()->json(['type'=>'SUCCESS','message'=>'Remarks added successfully!','data'=>$request->input('applicationid')]);    
                } else {
                    Log::info('error in while updating process steps of user');
                    return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong','data'=>$request->input('applicationid')]);
                }
            } else {
                return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.'], 200);
            }
        } catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.'], 200);
        }
        /*if ($request->hasFile('sanction_letter')) {
            $image = $request->file('sanction_letter');
            $image_name = time() . '.' . $request->sanction_letter->extension();
            $path = public_path('upload/sanction_letter');
            $dest = $image->move($path, $image_name);
            $inputs['sanction_letter'] = $image_name;
        }*/
        /*$inputs['rec_date'] = date('Y-m-d H:i:s');
        $inputs['staffid'] = Auth::user()->id;
        $inputs['statusdate'] = date('Y-m-d',strtotime($request->input('statusdate')));
        $userData = appDetailsWithUser($request->input('applicationid'));
        try{
            $insertId = 0;
            $result = '';
            DB::transaction(function() use ($inputs, $insertId, $request, $userData, $result) {
                $loanApplicationStatus = LoanApplicationStatus::create($inputs);
                $insertId = $loanApplicationStatus->id;
                $updateUserProcess = updateUserProcess($request->input('statusid'));
                $result = UserRegistration::where('id',$userData->userid)->update($updateUserProcess);
            });
            return response()->json(array('type'=>'SUCCESS','message'=>'Status added successfully','data'=>$request->input('applicationid')));
        } catch(\Exception $e){
            return response()->json(array('type'=>'ERROR','message'=>$e->getMessage()));
        }*/
    }

    public function applicationStatus(Request $request){
        try{
            $statusId = $request->input('statusId');
            $appId = $request->input('appId');
            $appDetails = appDetailsWithUser($appId);
            $data2 = userProcessStep($statusId);
            DB::transaction(function() use ($data2, $appDetails, $appId, $statusId) {
                LoanApplications::where('id',$appId)->update(['status'=>$statusId]);
                UserRegistration::where('id',$appDetails->userid)->update($data2);
            });
            return response()->json(array('type'=>'SUCCESS'));
        } catch(\Exception $e){
            return response()->json(array('type'=>'ERROR','message'=>$e->getMessage()));
        }
    }
    
    
    /* starts new developing */
    public function getTitle(Request $request){
        $title = DB::table('loanstatus_remarks')->where('id',$request->title)->first()->remarks;
        $title = str_ireplace('{var_consultant_number}', '<strong>+91 '.trim(chunk_split(($request->staff ?? '9429214352'),5,' ')).'</strong>', $title);
        if($title){
            return response()->json(['type'=>'SUCCESS','message'=>htmlspecialchars($title)]);
        } else {
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.']);
        }
    }
    
    public function missedCalls($applicationId){
        try{
            $appdetails = appDetailsWithUser($applicationId);
            $staff = optional(DB::table('administrations')->where('id',$appdetails->staff_id)->first())->mobile;
            $banklist = Banks::where(['isActive' => 1,'isDelete' => 0])->get();
            $loanRemarks = DB::table('loanstatus_remarks')->where('statusid',9)->get();
            return view('loan::pages.addStatus',compact(['appdetails','banklist','loanRemarks','staff']));
        } catch(\Exception $e ){
            Log::info('Missed call function - '. $e->getMessage());
            return redirect(route('selfapply.loan.application.details',['applicationId'=>$applicationId]));
        }
    }
    
    public function initiatedCalls($applicationId){
        try{
            $appdetails = appDetailsWithUser($applicationId);
            $staff = optional(DB::table('administrations')->where('id',$appdetails->staff_id)->first())->mobile;
            $banklist = Banks::where(['isActive' => 1,'isDelete' => 0])->get();
            $loanRemarks = DB::table('loanstatus_remarks')->where('statusid',8)->get();
            return view('loan::pages.addStatus',compact(['appdetails','banklist','loanRemarks','staff']));
        } catch(\Exception $e ){
            Log::info('Initiated call function - '. $e->getMessage());
            return redirect(route('selfapply.loan.application.details',['applicationId'=>$applicationId]));
        }
    }
    
    public function serviceClosed($applicationId){
        try{
            $appdetails = appDetailsWithUser($applicationId);
            $staff = optional(DB::table('administrations')->where('id',$appdetails->staff_id)->first())->mobile;
            $banklist = Banks::where(['isActive' => 1,'isDelete' => 0])->get();
            $loanRemarks = DB::table('loanstatus_remarks')->where('statusid',10)->get();
            return view('loan::pages.addStatus',compact(['appdetails','banklist','loanRemarks','staff']));
        } catch(\Exception $e ){
            Log::info('Initiated call function - '. $e->getMessage());
            return redirect(route('selfapply.loan.application.details',['applicationId'=>$applicationId]));
        }
    }
    
    public function serviceCalls($applicationId){
        try{
            $appdetails = appDetailsWithUser($applicationId);
            $staff = optional(DB::table('administrations')->where('id',$appdetails->staff_id)->first())->mobile;
            $banklist = Banks::where(['isActive' => 1,'isDelete' => 0])->get();
            $loanRemarks = DB::table('loanstatus_remarks')->where('statusid',7)->get();
            return view('loan::pages.addStatus',compact(['appdetails','banklist','loanRemarks','staff']));
        } catch(\Exception $e ){
            Log::info('Service call function - '. $e->getMessage());
            return redirect(route('selfapply.loan.application.details',['applicationId'=>$applicationId]));
        }
    }
    
    public function deleteRemark(Request $request){
        try{
            $res = ApplicationRemarks::findOrFail($request->id);
            if($res){
                $res->delete();
                return response()->json(['type'=>'SUCCESS', 'message'=>'Remark deleted successfully']);
            } else {
                return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.']);
            }
        } catch(\Exception $e){
            Log::info('delete remarks - '. $e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.']);
        }
    }
    
}
