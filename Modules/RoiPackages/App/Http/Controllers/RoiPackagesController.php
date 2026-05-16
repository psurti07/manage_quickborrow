<?php

namespace Modules\RoiPackages\App\Http\Controllers;

use App\DataTables\RoiPackagesDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Banks\App\Models\Banks;
use Modules\RoiPackages\App\Models\RoiPackage;

class RoiPackagesController extends Controller
{
    public function index(RoiPackagesDataTable $dataTable){
        return $dataTable->render('roipackages::index');
    }

    public function create(){
        $banks = Banks::where(['isDelete'=>0,'isActive'=>1])->get();
        return view('roipackages::modals.addroi',compact('banks'));
    }

    public function store(Request $request){
        $inputs = $request->all();
        $request->validate([
            'bankid' => 'required',
            'roi' => 'required|regex:/^\d+\.\d{2}$/',
            'termsyears' => 'required|regex:/^\d+\.\d{2}$/',
            'termsmonths' => 'required|regex:/^\d+\.\d{2}$/'
        ],[
            'bankid.required' => 'Please select bank first',
            'roi.required' => 'ROI field is required',
            'termsyears.required' => 'Terms Years field is required',
            'termsmonths.required' => 'Terms Months field is required'
        ]);
        $result = RoiPackage::create($inputs);
        $message = 'ROI Packages added successfully!';
        if($result){
            return response()->json(array('type'=>'SUCCESS','message'=>$message,'data'=>[]));
        } else {
            return response()->json(array('type'=>'ERROR','message'=>'Oops! Something went wrong.','data'=>[]));
        }
    }

    public function destroy(Request $request){
        $input = $request->all();
        $result = RoiPackage::where('id', $input['id'])->first();
        if ($result) {
            RoiPackage::where('id', $result['id'])->update(['isDelete'=>1]);
            $message = 'ROI packages deleted successfully!';
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function edit($id){
        $banks = Banks::where(['isDelete'=>0,'isActive'=>1])->get();
        $result = RoiPackage::where('id', $id)->first();
        return view('roipackages::modals.editroi',compact('banks','result'));
    }

    public function update(Request $request){
        $inputs = $request->all();
        $request->validate([
            'bankid' => 'required',
            'roi' => 'required|regex:/^\d+\.\d{2}$/',
            'termsyears' => 'required|regex:/^\d+\.\d{2}$/',
            'termsmonths' => 'required|regex:/^\d+\.\d{2}$/'
        ],[
            'bankid.required' => 'Please select bank first',
            'roi.required' => 'ROI field is required',
            'termsyears.required' => 'Terms Years field is required',
            'termsmonths.required' => 'Terms Months field is required'
        ]);
        $result = RoiPackage::where('id', $inputs['id'])->update($inputs);
        $message = 'ROI Packages updated successfully!';
        if($result){
            return response()->json(array('type'=>'SUCCESS','message'=>$message,'data'=>[]));
        } else {
            return response()->json(array('type'=>'ERROR','message'=>'Oops! Something went wrong.','data'=>[]));
        }
    }
}
