<?php

namespace Modules\SupportRequest\App\Http\Controllers;

use App\DataTables\SupportRequestDataTable;
use App\Http\Controllers\Controller;
use App\Models\SupportRequestChat;
use App\Models\SupportRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SupportRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SupportRequestDataTable $dataTable)
    {
        return $dataTable->render('supportrequest::index');
    }

    public function ticketDetails($supportId){
        $supportDetails = SupportRequests::where('id', $supportId)->first();
        $staffReply = SupportRequestChat::with('staff:id,fullname')->where('requestid', $supportId)->where('isDelete', 0)->get();
        return View('supportrequest::modals.details',compact('supportDetails','staffReply'));
    }

    public function addSupportRemarks(Request $request){
        try{
            $inputs = $request->all();
            $request->validate([
                'remarks' => 'required'
            ]);
            $insData = [
                'rec_date' => date('Y-m-d H:i:s'),
                'requestid' => $inputs['requestid'],
                'remarks' => $inputs['remarks'],
                'staffid' => Auth::user()->id,
                'isDelete' => 0
            ];
            $res = SupportRequestChat::create($insData);
            $remarksData = SupportRequestChat::with('staff:id,fullname')->where('requestid', $inputs['requestid'])->where('isDelete', 0)->get();
            if($res){
                return response()->json(['type'=>'SUCCESS','data' => $remarksData, 'message'=>'Remarks added successfully!'],200);
            } else {
                return response()->json(['type'=>'SUCCESS','message'=>'Server is busy right now. Try after some time!'],200);
            }
        } catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['type' => 'error', 'errors' => $e->errors()], 422);
        }
        catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.'],422);
        }
    }

    public function changeSupportStatus(Request $request){
        try{
            $inputs = $request->all();
            
            $reqData = SupportRequests::where('id', $inputs['supportId'])->first();
            
            if($reqData->id > 0){
                $updRes = SupportRequests::where('id', $inputs['supportId'])->update(['status'=>$inputs['status']]);
                
                /* send ticket message starts */
                switch($inputs['status']) {
                    case '1':
                        // Ticket - OPEN
                        $msg = DB::table('sms_list')->where('type',3)->where('slug','ticket_raised')->first()->message;
                        break;
                
                    case '2':
                        // Ticket - PROCESS
                        $msg = DB::table('sms_list')->where('type',3)->where('slug','ticket_underprocess')->first()->message;
                        break;
                        
                    case '3':
                        // Ticket - CLOSED NO-RESPONSE
                        $msg = DB::table('sms_list')->where('type',3)->where('slug','ticket_noresponse')->first()->message;
                        break;
                        
                    case '4':
                        // Ticket - SOLVED
                        $msg = DB::table('sms_list')->where('type',3)->where('slug','ticket_solved')->first()->message;
                        break;
                
                    default:
                        $msg = DB::table('sms_list')->where('type',3)->where('slug','ticket_closed')->first()->message;
                        break;
                }
                
                if($msg != '#'){
                    $msg = str_ireplace('{#varticket#}',$reqData->ticketno,$msg);
                    $senderId = DB::table('info_pages')->where('slug','common-senderid')->first()->content;
                    sendDynamicSMS($senderId, $msg, $reqData->mobile, 'self'); 
                }
                /* send ticket message ends */
                
                if($updRes){
                    return response()->json(['type'=>'SUCCESS','data'=>$inputs['status'], 'message'=>'Status changed successfully!'],200);
                } else {
                    return response()->json(['type'=>'ERROR','message'=>'Server is busy right now. Try after some time!'],200);
                }
            }
        } catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.'],422);
        }
    }
}
