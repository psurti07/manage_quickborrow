<?php

namespace Modules\AdsContent\App\Http\Controllers;

use App\DataTables\AdvertisementsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Adscontent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdsContentController extends Controller
{

    public function index(AdvertisementsDataTable $dataTable,$type)
    {
        return $dataTable->with('type',$type)->render('adscontent::index',compact('type'));
    }

    public function create($type){
        if($type == 'text'){
            return view('adscontent::modals.text');
        } else {
            return view('adscontent::modals.image');
        }
    }

    public function save(Request $request){
        $input = $request->all();
        $request->validate([
            'ad_content' => 'required'
        ],[
            'ad_content.required' => 'The ad content field is required'
        ]);
        $result = Adscontent::create($input);
        $message = 'Advertisement added successfully!';
        if($result){
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something Went Wrong.', 'data' => []));
        }
    }

    public function destroy(Request $request)
    {
        $input = $request->all();
        $result = Adscontent::where('id', $input['id'])->first();
        if ($result) {
            Adscontent::where('id', $result['id'])->update(['isDelete'=>1]);
            $message = 'Ads content deleted successfully!';
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something Went Wrong.', 'data' => []));
        }
    }

    public function store(Request $request){
        $input = $request->all();
        $request->validate([
            'ad_content' => 'mimes:jpeg,png,jpg|max:1024|required'
        ],[
            'ad_content.mimes' => 'The uploaded file must be a JPG, JPEG or PNG image.',
            'ad_content.uploaded' => 'The uploaded file may not be greater than 1 MB in size.',
        ]);
        if ($request->hasFile('ad_content')) {
            $image = $request->file('ad_content');
            $image_name = time() . '.' . $request->ad_content->extension();
            $path = public_path('upload/ads');
            $dest = $image->move($path, $image_name);
            $input['ad_content'] = $image_name;
        }
        $result = Adscontent::create($input);
        $message = 'Ads added successfully!';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something Went Wrong.', 'data' => []));
        }
    }

}
