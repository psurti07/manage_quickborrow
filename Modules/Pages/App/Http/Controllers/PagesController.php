<?php

namespace Modules\Pages\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pages\App\Models\InfoPages;

class PagesController extends Controller
{
    public function privacyPolicy(){
        $result = InfoPages::where('slug', 'privacy-policy')->first();
        $rec['data'] = $result;
        return view('pages::layouts.privacypolicy')->with($rec);
    }

    public function disclaimer(){
        $result = InfoPages::where('slug', 'disclaimer')->first();
        $rec['data'] = $result;
        return view('pages::layouts.disclaimer')->with($rec);
    }

    public function termsCondition(){
        $result = InfoPages::where('slug', 'terms-conditions')->first();
        $rec['data'] = $result;
        return view('pages::layouts.termsconditions')->with($rec);
    }

    public function refundPolicy(){
        $result = InfoPages::where('slug', 'refund-policy')->first();
        $rec['data'] = $result;
        return view('pages::layouts.refundpolicy')->with($rec);
    }

    public function privacyPolicyUpdate(Request $request){
        try{
            $input = $request->all();
            $request->validate([
                'privacypolicy' => 'required'
            ]);
            $result = InfoPages::where('slug', $input['slug'])->update(['content'=>$input['privacypolicy']]);
            $message = 'Privacy Policy updated successfully!';
            if ($result) {
                return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result), 200);
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Nothing to be change!'), 200);
            }
        } catch(\Illuminate\Validation\ValidationExeption $e){
            return response()->json(['type'=>'ERROR','errors'=>$e->errors()], 422);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.'],200);
        }
    }

    public function refundPolicyUpdate(Request $request){
        try{
            $input = $request->all();
            $request->validate([
                'refundpolicy' => 'required'
            ]);
            $result = InfoPages::where('slug', $input['slug'])->update(['content'=>$input['refundpolicy']]);
            $message = 'Refund Policy updated successfully!';
            if ($result) {
                return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result), 200);
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Nothing to be change!'), 200);
            }
        } catch(\Illuminate\Validation\ValidationExeption $e){
            return response()->json(['type'=>'ERROR','errors'=>$e->errors()], 422);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.'],200);
        }
    }

    public function disclaimerUpdate(Request $request){
        try{
            $input = $request->all();
            $request->validate([
                'disclaimer' => 'required'
            ]);
            $result = InfoPages::where('slug', $input['slug'])->update(['content'=>$input['disclaimer']]);
            $message = 'Disclaimer updated successfully!';
            if ($result) {
                return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result), 200);
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Nothing to be change!'), 200);
            }
        } catch(\Illuminate\Validation\ValidationExeption $e){
            return response()->json(['type'=>'ERROR','errors'=>$e->errors()], 422);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.'],200);
        }
    }

    public function termsConditionUpdate(Request $request){
        try{
            $input = $request->all();
            $request->validate([
                'termsconditions' => 'required'
            ]);
            $result = InfoPages::where('slug', $input['slug'])->update(['content'=>$input['termsconditions']]);
            $message = 'Terms conditions updated successfully!';
            if ($result) {
                return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result), 200);
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Nothing to be change!'), 200);
            }
        } catch(\Illuminate\Validation\ValidationExeption $e){
            return response()->json(['type'=>'ERROR','errors'=>$e->errors()], 422);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.'],200);
        }
    }
}
