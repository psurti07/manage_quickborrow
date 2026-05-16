<?php

namespace Modules\Career\App\Http\Controllers;

use App\DataTables\CareerEnquiryDataTable;
use App\DataTables\CareersDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Career\App\Models\Careers;
use Modules\Career\App\Models\CareerEnquiry;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CareersDataTable $dataTable)
    {
        return $dataTable->render('career::index');
    }

    public function create()
    {
        return view('career::modals.addCareer');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'title' => 'required',
            'descriptions' => 'required'
        ]);
        $result = Careers::create($input);
        $message = 'Career added successfully!';
        if($result){
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Oops! Something went wrong..', 'data' => []));
        }
    }

    public function statusChange(Request $request){
        $input = $request->all();
        $result = Careers::where('id', $input['id'])->first();
        Careers::where('id', $result['id'])->update(['isActive'=>$input['status']==1?0:1]);
        $message = 'Status changed successfully!';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function destroy(Request $request)
    {
        $input = $request->all();
        $result = Careers::where('id', $input['id'])->first();
        if ($result) {
            Careers::where('id', $result['id'])->update(['isDelete'=>1]);
            $message = 'Career deleted successfully';
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function edit($id){
        $result = Careers::where('id', $id)->first();
        $rec['data'] = $result;
        return view('career::modals.editCareer')->with($rec);
    }

    public function update(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'title' => 'required',
            'descriptions' => 'required',
        ]);
        $result = Careers::where('id', $input['id'])->update($input);
        $message = 'Careers updated successfully!';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function enquiry(CareerEnquiryDataTable $dataTable){
        return $dataTable->render('career::layouts.enquiry');
    }

    public function enquiryremove(Request $request){
        $input = $request->all();
        $result = CareerEnquiry::find($input['id']);
        if ($result) {
            CareerEnquiry::where('id', $input['id'])->update(['isDelete'=> 1]);
            $message = 'Career enquiry remove successfully!';
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }
}
