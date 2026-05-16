<?php

namespace Modules\SMS\App\Http\Controllers;

use App\DataTables\SmsMessageDataTable;
use App\DataTables\SmsTemplateDataTable;
use App\Http\Controllers\Controller;
use App\Models\SmsList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SMSController extends Controller
{

    public function smsTemplates(SmsTemplateDataTable $dataTable){
        return $dataTable->render('sms::index');
    }

    public function smsMessage(SmsMessageDataTable $dataTable){
        return $dataTable->render('sms::message');
    }

    public function sendCustomSms(){
        return view('sms::sendcustom');
    }
    
    public function edit($id)
    {
        $result = SmsList::where('id', $id)->first();
        return view('sms::modals.editSms', compact('result'));
    }

    public function update(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'message' => 'required',
        ]);
        $result = SmsList::where('id', $request->id)->update($input);
        $message = 'Message Successfully Updated.';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }
    
    public function getMessage(Request $request){
        try{
            $res = DB::table('sms_list')->where('id', $request->title)->first()->message;
            return response()->json(['type'=>'SUCCESS','message'=>$res]);
        } catch(\Exception $e){
            Log::info('getting error from getMessage - '. $e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops!Something went wrong.']);
        }
    }
    
    
    public function fireSms(Request $request){
        try{
            $request->validate([
                'mobile' => ['required','numeric','regex:/^[6-9]\d{9}$/'],
                'title' => 'required',
                'portal' => 'required',
                'message' => 'required'
            ]);
            $panel = '';
            if($request->portal == 'self'){
                $panel = 'self';
            } else if($request->portal == 'hire'){
                $panel = 'hire';
            } else {
                $panel = 'self';
            }
            
            $tempId = '';
            /* if($request->title == 24){
                $tempId = 1707175432183949491;
            } */
            $res = sendDynamicSMS($request->senderid, $request->message, $request->mobile, $panel, $tempId);
            if($res['status_code'] == 200){
                return response()->json(['type'=>'SUCCESS','message'=>'Message sent successfully.']);
            } else {
                return response()->json(['type'=>'ERROR','message'=>'Message sending failed.']);
            }
        } catch(\Exception $e){
            Log::info('fire sms function - '. $e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops!Something went wrong.']);
        }
    }
    
    
    /* send custom sms modules starts */
    
    public function testSms(){
        $titles = DB::table('sms_list')->where('isActive', 1)->get();
        return view('sms::modals.testSms',compact('titles'));
    }
    
    public function fireCustomSms(Request $request){
        try{
            $datas = $request->all();
            $request->validate([
                'description' => 'required'
            ],[
                'description.required' => 'The message field is required.'
            ]);
            
            if($request->has('acc_type') && in_array($request->input('acc_type'), [1,2,3])){
                if($datas['target_customer'] == '1_0' || $datas['target_customer'] == '2_0' || $datas['target_customer'] == '3_0'){
                    $response = $this->sendCustomTestCustomSms($datas);
                } else {
                    $response = $this->sendSmsCustom($datas);
                }
            } else {
                return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong...']);
            }
            return response()->json($response);
        } catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['type'=>'ERROR', 'errors'=>$e->errors()], 422);
        } catch(\Exception $e){
            Log::info('an error occured in fireCustomSms - ' . $e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops!Something went wrong.']);
        }
    }
    
    public function getSenderId($accType){
        $senderId = '';
        if($accType == 1){
            $username = env('SMS_OBB_USERNAME');
            $password = env('SMS_OBB_PASSWORD');
            $senderId = DB::table('info_pages')->where('slug','sa-senderid')->select('content')->first()->content;
        } else if($accType == 2){
            $username = env('SMS_OBB_LA_USERNAME');
            $password = env('SMS_OBB_LA_PASSWORD');
            $senderId = DB::table('info_pages')->where('slug','la-senderid')->select('content')->first()->content;
        } else {
            $username = env('SMS_OBB_USERNAME');
            $password = env('SMS_OBB_PASSWORD');
            $senderId = DB::table('info_pages')->where('slug','sa-senderid')->select('content')->first()->content;
        }
        
        return ['username'=>$username,'password'=>$password, 'senderId'=>$senderId];
    }
    
    public function sendCustomTestCustomSms($data){
        try{
            $nos = [6358025966,9904466599,6352257117,6358141826,9023987358,9724157166,9998892746,8511127147,9998807547,9998846839,6358945179];
            $msgData = $this->getSenderId($data['acc_type']);
            $dataset = '';
            $arrnumbers = 0;
            foreach($nos as $no){
                $dataset .= "
                    <sms>
                        <user>".$msgData['username']."</user>
                        <password>".$msgData['password']."</password>
                        <mobiles>".$no."</mobiles>
                        <message>".$data['description']."</message>
                        <accusage>1</accusage>
                        <senderid>".$msgData['senderId']."</senderid>
                    </sms>
                ";
                $arrnumbers++;
            }
            
            $response = sendDynamicXMLSMS($dataset);
            $data1 = array(
				'rec_date' => date('Y-m-d H:i:s'),
				'crontype' => 'Test Sms',
				'parentid' => $data['acc_type'], // self apply
				'cronname' => 'Send Test Sms',
				'msgcount' => $arrnumbers,
				'msgresponse' => $response
			);
			DB::table('sms_log')->insert($data1);
			return ['type'=>'SUCCESS','message'=>'Sms sent successfully'];
        } catch(\Exception $e){
            Log::info('An error occured in send custom test sms - ' . $e->getMessage());
            return ['type'=>'ERROR', 'message'=>'Error in sending SMS.'];
        }
    }
    
    public function sendSmsCustom($data){
        try{
            $accProcess = explode('_',$data['target_customer']);
            $users = DB::table('user_registrations')->where('acc_type',$accProcess[0])
                ->where('process_step',$accProcess[1])->where('isDelete',0)
                ->where('isActive',1)->where('isDnd',0)->pluck('mobile');
            if($users->isNotEmpty()){
                /* send sms users present */
                $msgData = $this->getSenderId($accProcess[0]);
                $dataset = '';
                $arrnumbers = 0;
                foreach($users as $mobile){
                    $dataset .= "
                        <sms>
                            <user>".$msgData['username']."</user>
                            <password>".$msgData['password']."</password>
                            <mobiles>".$mobile."</mobiles>
                            <message>".$data['description']."</message>
                            <accusage>1</accusage>
                            <senderid>".$msgData['senderId']."</senderid>
                        </sms>
                    ";
                    $arrnumbers++;
                }
            
                $response = sendDynamicXMLSMS($dataset);
                $data1 = array(
    				'rec_date' => date('Y-m-d H:i:s'),
    				'crontype' => (($accProcess[0] == 1) ? 'Self Apply' : 'Hire Agent').' Custom',
    				'parentid' => $data['acc_type'],
    				'cronname' => 'Send Custom SMS',
    				'msgcount' => $arrnumbers,
    				'msgresponse' => $response
    			);
    			DB::table('sms_log')->insert($data1);
    			return ['type'=>'SUCCESS','message'=>'Sms sent successfully'];
            } else {
                /* user not present */
                return ['type'=>'SUCCESS','message'=>'User not present in this criteria.'];
            }
        } catch(\Exception $e){
            Log::info('An error occured in send custom test sms - ' . $e->getMessage());
            return ['type'=>'ERROR', 'message'=>'Error in sending SMS.'];
        }
    }
    
    public function getUserCounts(Request $request){
        try{
            $accProcess = explode('_',$request->input('process'));
            if(in_array($request->input('process'),['1_0','2_0','3_0'])){
                $users = 11;
            } else {
                $users = DB::table('user_registrations')->where('acc_type',$accProcess[0])
                ->where('process_step',$accProcess[1])->where('isDelete',0)
                ->where('isActive',1)->where('isDnd',0)->count();    
            }
            return response()->json(['type'=>'SUCCESS','message'=>$users]);
        } catch(\Exception $e){
            Log::info('An error occured in get user counts - ' . $e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'User not found']);
        }
    }
    

}
