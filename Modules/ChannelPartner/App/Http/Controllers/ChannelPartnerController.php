<?php

namespace Modules\ChannelPartner\App\Http\Controllers;

use App\DataTables\ChannelPartnerDataTable;
use App\DataTables\ChannelPartnerLeadsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\ChannelPartner\App\Models\ChannelPartner;
use Monolog\Handler\FingersCrossed\ChannelLevelActivationStrategy;

class ChannelPartnerController extends Controller
{
    public function index(ChannelPartnerDataTable $dataTable)
    {
        return $dataTable->render('channelpartner::index');
    }

    public function create(){
        return view('channelpartner::modals.addPartnerModal');
    }

    public function store(Request $request){
        $inputs = $request->all();
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:channel_partners,email',
            'mobile' => 'required|numeric|regex:/^[6-9]\d{9}$/',
            'password' => 'required',
            'company_name' => 'required',
            'phone' => 'required|numeric|regex:/^[6-9]\d{9}$/',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required|numeric',
            'website' => 'required|url',
            'vat_gst_no' => 'required',
            'address' => 'required'
        ]);
        $inputs['first_name'] = capitalizeFirstLetter($inputs['first_name']);
        $inputs['last_name'] = capitalizeFirstLetter($inputs['last_name']);
        $inputs['email'] = strtolower($inputs['email']);
        $inputs['city'] = capitalizeFirstLetter($inputs['city']);
        $inputs['company_name'] = capitalizeFirstLetter($inputs['company_name']);
        $result = ChannelPartner::create($inputs);
        if($result){
            $partnerId = $result->id;
            return response()->json(array('type'=>'SUCCESS','message'=>'Channel partner added successfully!','data'=>encrypt($partnerId)));
        } else {
            return response()->json(array('type'=>'ERROR','message'=>'Oops! Oops! Something went wrong. while adding channel partner.'));
        }
    }

    public function details($partnerId){
        try{
            $partnerData = ChannelPartner::where('id',decrypt($partnerId))->first();
            return view('channelpartner::channelPartnerDetails',compact('partnerData'));
        } catch(\Exception $e){
            Log::error('error',['error'=>$e->getMessage()]);

        }
    }

    public function updatePassword(Request $request){
        $user = ChannelPartner::find($request->input('userid'));
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
            return response()->json(array('type' => 'ERROR', 'message' => 'Channel Partner not found', 'data' => []));
        }
    }

    public function deactivateAccount(Request $request){
        $user = ChannelPartner::find($request->input('userid'));
        if($user){
            $updateData = array('isActive'=>$request->input('status'));
            $result = ChannelPartner::where('id',$request->input('userid'))->update($updateData);
            $message = '';
            if($request->input('status') == 1){
                $message = 'Account activated successfully!';
            } else {
                $message = 'Account deactivate successfully!';
            }
            if($result > 0){
                return response()->json(['type'=>'SUCCESS','message'=>$message,'data'=>encrypt($request->input('userid'))]);
            } else {
                return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.']);
            }
        } else {
            return response()->json(['type'=>'ERROR','message'=>'Invalid user perform action.']);
        }
    }

    public function destroy(Request $request){
        $input = $request->all();
        $result = ChannelPartner::where('id', $input['userid'])->first();
        if ($result) {
            $res = ChannelPartner::where('id', $result['id'])->update(['isDelete'=>1]);
            if($res > 0){
                $message = 'Channel Partner Account deleted successfully!';
                return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
            }
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function updateCompany(Request $request){
        try{
            $inputs = $request->all();
            $request->validate([
                'company_name' => 'required',
                'phone' => 'required|numeric|regex:/^[6-9]\d{9}$/',
                'city' => 'required',
                'state' => 'required',
                'pincode' => 'required|numeric',
                'website' => 'required|url',
                'vat_gst_no' => 'required',
                'address' => 'required'
            ]);
            $updates = [
                'company_name' => capitalizeFirstLetter($inputs['company_name']),
                'phone' => $inputs['phone'],
                'city' => capitalizeFirstLetter($inputs['city']),
                'state' => $inputs['state'],
                'pincode' => $inputs['pincode'],
                'website' => $inputs['website'],
                'address' => $inputs['address'],
                'vat_gst_no' => $inputs['vat_gst_no'],
            ];
            $result = ChannelPartner::where('id',$inputs['userid'])->update($updates);
            if($result > 0){
                return response()->json(array('type'=>'SUCCESS','message'=>'Channel Partner Company`s details updated successfully!'));
            } else {
                return response()->json(array('type'=>'ERROR','message'=>'Oops! Something went wrong while adding channel partner.'));
            }
        } catch(\Exception $e){
            Log::error('error',['error'=>$e->getMessage()]);
            return response()->json(array('type'=>'ERROR','message'=>'Oops! Something went wrong while adding channel partner.'));
        }
    }

    public function updatePersonal(Request $request){
        try{
            $inputs = $request->all();
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:channel_partners,email,'.$inputs["userid"],
                'mobile' => 'required|numeric|regex:/^[6-9]\d{9}$/',
            ]);
            $updates = [
                'first_name' => capitalizeFirstLetter($inputs['first_name']),
                'last_name' => capitalizeFirstLetter($inputs['last_name']),
                'email' => strtolower($inputs['email']),
                'mobile' => $inputs['mobile'],
            ];
            $result = ChannelPartner::where('id',$inputs['userid'])->update($updates);
            if($result > 0){
                return response()->json(array('type'=>'SUCCESS','message'=>'Channel Partner personal details updated successfully!'));
            } else {
                return response()->json(array('type'=>'ERROR','message'=>'Oops! Something went wrong while adding channel partner.'));
            }
        } catch(\Exception $e){
            Log::error('error',['error'=>$e->getMessage()]);
            return response()->json(array('type'=>'ERROR','message'=>'Oops! Something went wrong while adding channel partner.'));
        }
    }

    public function channelPartnerLeads(ChannelPartnerLeadsDataTable $dataTable){
        return $dataTable->render('channelpartner::leads.index');
    }

    public function channelPartnerLeadsDetails($id){
        $partner = ChannelPartner::where('id',$id)->first();
        return view('channelpartner::modals.leadsDetails',compact('partner'));
    }
}
