<?php

namespace Modules\SiteOptions\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Modules\Pages\App\Models\InfoPages;
use App\DataTables\InteraktSettingsDataTable;

class SiteOptionsController extends Controller
{
    public function welcomeMessage(){
        $result = InfoPages::where('slug', 'welcome-message')->first();
        $rec['data'] = $result;
        return view('siteoptions::layouts.welcomemessage')->with($rec);
    }

    public function welcomeMessageUpdate(Request $request){
        try{
            $input = $request->all();
            $request->validate([
                'welcomemessage' => 'required'
            ]);
            $result = InfoPages::where('slug', $input['slug'])->update(['content'=>$input['welcomemessage'],'status'=>$input['status']]);
            $message = 'Welcome message updated successfully!';
            if ($result) {
                return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result), 200);
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Nothing to be change!'), 200);
            }
        } catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['type'=>'ERROR','errors'=>$e->errors()], 422);
        } catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.'],200);
        }
    }

    /*  Axccount Message section  */
    public function accountMessage(){
        $sa = InfoPages::where('slug', 'self-apply')->pluck('content')->first();
        $la = InfoPages::where('slug', 'loan-agent')->pluck('content')->first();
        return view('siteoptions::layouts.accountmessage',compact('sa','la'));
    }

    public function accountMessageUpdate(Request $request){
        try{
            $input = $request->all();
            $slug = str_ireplace('-','_',$input['slug']);

            /*$request->validate([
                'accountmessage_'.$slug => 'required'
            ],[
                'accountmessage_'.$slug.'.required' => 'This field is required'
            ]);*/
            $result = InfoPages::where('slug', $input['slug'])->update(['content'=>$input['accountmessage_'.$slug]]);
            $message = ucwords(str_ireplace('_',' ',$slug)).' message updated successfully!';
            if ($result) {
                return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result), 200);
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Nothing to be change!'), 200);
            }
        } catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['type'=>'ERROR','errors'=>$e->errors()], 422);
        } catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.'],200);
        }
    }

    /* Site settings section */
    public function siteSettings(){
        $fbdomain = $this->searchRecords('facebookdomain');
        $fbpixel = $this->searchRecords('facebookpixelkey');
        $fbaccesstoken = $this->searchRecords('facebookaccesstoken');
        $fbevntnm = $this->searchRecords('facebookeventname');
        $fbevntid = $this->searchRecords('facebookeventid');

        $loanfbdomain = $this->searchRecords('la_facebookdomain');
        $loanfbpixel = $this->searchRecords('la_facebookpixelkey');
        $loanfbaccesstoken = $this->searchRecords('la_facebookaccesstoken');
        $loanfbevntnm = $this->searchRecords('la_facebookeventname');
        $loanfbevntid = $this->searchRecords('la_facebookeventid');
        
        return view('siteoptions::index')->with([
            'fbDomain' => $fbdomain,
            'fbPixelKey' => $fbpixel,
            'fbAccessToken' => $fbaccesstoken,
            'fbEventName' => $fbevntnm,
            'fbEventId' => $fbevntid,
            'loanfbDomain' => $loanfbdomain,
            'loanfbPixelKey' => $loanfbpixel,
            'loanfbAccessToken' => $loanfbaccesstoken,
            'loanfbEventName' => $loanfbevntnm,
            'loanfbEventId' => $loanfbevntid
        ]);
    }

    public function searchRecords($searchTerm)
    {
        return InfoPages::select('content')->where('slug', 'LIKE', '%' . $searchTerm . '%')->first()->content;
    }

    public function updateKey(Request $request){
        $input = $request->all();
        $request->validate([
            'fbdomainid' => 'required',
            'fbpixelkey' => 'required'
        ],[
            'fbdomainid.required' => 'Facebook domain id field is required',
            'fbpixelkey.required' => 'Facebook pixel key is required'
        ]);
        $result1 = InfoPages::where('slug','sa_facebookdomain')->update(['content'=> $input['fbdomainid']]);
        $result2 = InfoPages::where('slug','sa_facebookpixelkey')->update(['content'=>$input['fbpixelkey']]);
        $message = 'Facebook key changed successfully';
        if($result1 || $result2){
            Session::flash('success', $message);
            return redirect()->route('manage.site-settings');
        } else {
            Session::flash('success', $message);
            return redirect()->route('manage.site-settings');
        }
    }

    public function updateEvent(Request $request){
        $input = $request->all();
        $request->validate([
            'fbaccesstoken' => 'required',
            'fbeventname' => 'required',
            'fbeventid' => 'required'
        ],[
            'fbaccesstoken.required' => 'Facebook access token field is required',
            'fbeventname.required' => 'Facebook event name field is required',
            'fbeventid.required' => 'Facebook event id field is required',
        ]);
        $result1 = InfoPages::where('slug','sa_facebookaccesstoken')->update(['content'=>$input['fbaccesstoken']]);
        $result2 = InfoPages::where('slug','sa_facebookeventname')->update(['content'=>$input['fbeventname']]);
        $result3 = InfoPages::where('slug','sa_facebookeventid')->update(['content'=>$input['fbeventid']]);
        $message = 'Facebook Events changed successfully';
        if($result1 || $result2 || $result3){
            Session::flash('success', $message);
            return redirect()->route('manage.site-settings');
        } else {
            Session::flash('success', 'Updated');
            return redirect()->route('manage.site-settings');
        }
    }

    public function loanUpdateKey(Request $request){
        $input = $request->all();
        $request->validate([
            'loanfbdomainid' => 'required',
            'loanfbpixelkey' => 'required'
        ],[
            'loanfbdomainid.required' => 'Facebook domain id field is required',
            'loanfbpixelkey.required' => 'Facebook pixel key is required'
        ]);
        $result1 = InfoPages::where('slug','la_facebookdomain')->update(['content'=>$input['loanfbdomainid']]);
        $result2 = InfoPages::where('slug','la_facebookpixelkey')->update(['content'=>$input['loanfbpixelkey']]);
        $message = 'Loan agent key changed successfully';
        if($result1 || $result2){
            Session::flash('success', $message);
            return redirect()->route('manage.site-settings');
        } else {
            Session::flash('success', 'Updated');
            return redirect()->route('manage.site-settings');
        }
    }

    public function loanUpdateEvent(Request $request){
        $input = $request->all();
        $request->validate([
            'loanfbaccesstoken' => 'required',
            'loanfbeventname' => 'required',
            'loanfbeventid' => 'required'
        ],[
            'loanfbaccesstoken.required' => 'Facebook access token field is required',
            'loanfbeventname.required' => 'Facebook event name field is required',
            'loanfbeventid.required' => 'Facebook event id field is required',
        ]);
        $result1 = InfoPages::where('slug','la_facebookaccesstoken')->update(['content'=>$input['loanfbaccesstoken']]);
        $result2 = InfoPages::where('slug','la_facebookeventname')->update(['content'=>$input['loanfbeventname']]);
        $result3 = InfoPages::where('slug','la_facebookeventid')->update(['content'=>$input['loanfbeventid']]);
        $message = 'Loan agent Events changed successfully';
        if($result1 || $result2 || $result3){
            Session::flash('success', $message);
            return redirect()->route('manage.site-settings');
        } else {
            Session::flash('success', 'Updated');
            return redirect()->route('manage.site-settings');
        }
    }

    public function whatsappSettings(){
        $options = InfoPages::whereIn('slug', ['sa-wp-remarketing','sa-wp-getoffer','sa-wp-payment-success','sa-wp-username-password','la-wp-remarketing','la-wp-getoffer','la-wp-payment-success','la-wp-username-password'])->get();
        return view('siteoptions::whatsappSettings',compact('options'));
    }

    public function whatsappSettingsUpdate(Request $request){
        try{
            $inputs = $request->all();
            $request->validate([
                $inputs['slug'] => 'required'
            ],[
                'sa-wp-remarketing.required' => 'Whatsapp remarketing field is required',
                'sa-wp-getoffer.required' => 'Whatsapp get offer field is required',
                'sa-wp-payment-success.required' => 'Whatsapp payment success field is required',
                'sa-wp-username-password.required' => 'Whatsapp username-password field is required',
                'la-wp-remarketing.required' => 'Whatsapp remarketing field is required',
                'la-wp-getoffer.required' => 'Whatsapp get offer field is required',
                'la-wp-payment-success.required' => 'Whatsapp payment success field is required',
                'la-wp-username-password.required' => 'Whatsapp username password field is required',
            ]);
            $field = $inputs['slug'];
            $message = getMessageWhatsappSettings($inputs['slug']);
            $res = InfoPages::where('slug',$inputs['slug'])->update(['content'=>$inputs[$field]]);
            if($res){
                return response()->json(['type'=>'SUCCESS','message'=>$message],200);
            } else {
                return response()->json(['type'=>'ERROR','message'=>'Nothing to be changed!'],200);
            }
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['type'=>'ERROR','errors'=>$e->errors()], 422);
        } catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.'],200);
        }
    }
    
    public function smsSettings(){
        $options = InfoPages::whereIn('slug', ['sa-senderid', 'sa-senderid-otp', 'la-senderid', 'la-senderid-otp', 'common-senderid', 'lat-senderid', 'lat-senderid-otp'])->get();
        return view('siteoptions::smsSettings',compact('options'));
    }
    
    public function smsSettingsUpdate(Request $request){
        try{
            $inputs = $request->all();
            $request->validate([
                $inputs['slug'] => 'required'
            ],[
                'sa-senderid.required' => 'Self Apply SenderId field is required',
                'sa-senderid-otp.required' => 'Self Apply OTP SenderId field is required',
                'la-senderid.required' => 'Loan Agent SenderId field is required',
                'la-senderid-otp.required' => 'Loan Agent OTP SenderId field is required',
                'common-senderid.required' => 'Common SenderId field is required'
            ]);
            $field = $inputs['slug'];
            $message = getMessageSettings($inputs['slug']);
            $res = InfoPages::where('slug',$inputs['slug'])->update(['content'=>$inputs[$field]]);
            if($res){
                return response()->json(['type'=>'SUCCESS','message'=>$message],200);
            } else {
                return response()->json(['type'=>'ERROR','message'=>'Nothing to be changed!'],200);
            }
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['type'=>'ERROR','errors'=>$e->errors()], 422);
        } catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.'],200);
        }
    }
    
    /* interakt settings */
    public function interaktSettings(InteraktSettingsDataTable $dataTable){
        return $dataTable->render('siteoptions::interakt');
    }
    
    public function interaktSettingsEdit($id){
        $data = DB::table('interakt_settings')->where('id',$id)->first();
        return view('siteoptions::modals.edit',compact('data'));
    }
    
    public function interaktSettingsUpdate(Request $request){
        try{
            $request->validate([
                'template_name'=>'required',
                'img_url' => 'required',
                'api_key' => 'required'
            ]);
            $updData = array(
                'template_name' => $request->template_name,    
                'img_url' => $request->img_url,    
                'api_key' => $request->api_key,    
            );
            $res = DB::table('interakt_settings')->where('id', $request->id)->update($updData);
            return response()->json(['type'=>'SUCCESS','message'=>'Interakt key settings updated successfully']);
        } catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['type'=>'ERROR','errors'=>$e->errors()],422);
        } catch(\Exception $e){
            return response()->json(['type'=>'ERROR','message'=>'Opps!Something went wrong']);
        }
    }
}
