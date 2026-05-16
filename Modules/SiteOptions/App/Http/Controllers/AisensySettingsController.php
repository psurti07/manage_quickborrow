<?php

namespace Modules\SiteOptions\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\DataTables\AisensySettingsDataTable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class AisensySettingsController extends Controller
{
    public function index(AisensySettingsDataTable $dataTable){
        return $dataTable->render('siteoptions::aisensy');
    }
    
    public function edit($id){
        $data = DB::table('aisensy_settings')->where('id',$id)->first();
        return view('siteoptions::modals.aisensyEdit',compact('data'));
    }
    
    public function update(Request $request){
        try{
            $request->validate([
                'api_key'=>'required',
                'campaign_name'=>'required',
                'media_url' => 'required',
                'media_filename' => 'required'
            ]);
            $updData = array(
                'api_key' => $request->api_key,    
                'campaign_name' => $request->campaign_name,    
                'media_url' => $request->media_url,    
                'media_filename' => $request->media_filename,    
            );
            $res = DB::table('aisensy_settings')->where('id', $request->id)->update($updData);
            return response()->json(['type'=>'SUCCESS','message'=>'AiSensy key settings updated successfully']);
        } catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['type'=>'ERROR','errors'=>$e->errors()],422);
        } catch(\Exception $e){
            return response()->json(['type'=>'ERROR','message'=>'Opps!Something went wrong']);
        }
    }
}
