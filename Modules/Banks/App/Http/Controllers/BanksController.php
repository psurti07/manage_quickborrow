<?php

namespace Modules\Banks\App\Http\Controllers;

use App\DataTables\BanksDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Modules\Banks\App\Models\Banks;

class BanksController extends Controller
{
    public function index(BanksDataTable $dataTable)
    {
        return $dataTable->render('banks::index');
    }

    public function create()
    {
        return view('banks::modals.addBanks');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'bank_name' => 'required',
            'order_no' => 'required',
            'bank_image' => 'mimes:jpeg,png,jpg|max:1024|required'
        ], [
            'bank_image.mimes' => 'The uploaded file must be a JPG, JPEG or PNG image.',
            'bank_image.uploaded' => 'The uploaded file may not be greater than 1 MB in size.',
        ]);
        if ($request->hasFile('bank_image')) {
            $image = $request->file('bank_image');
            $image_name = time() . '.' . $request->bank_image->extension();
            $path = public_path('upload/banks');
            $dest = $image->move($path, $image_name);
            $input['bank_image'] = $image_name;
        }
        $result = Banks::create($input);
        $message = 'Banks Successfully Added.';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function destroy(Request $request)
    {
        $input = $request->all();
        $result = Banks::where('id', $input['id'])->first();
        if ($result) {
            Banks::where('id', $result['id'])->update(['isDelete' => 1]);
            $message = 'Bank Deleted Successfully.';
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function edit($id)
    {
        $result = Banks::where('id', $id)->first();
        $rec['data'] = $result;
        return view('banks::modals.editBanks')->with($rec);
    }

    public function update(Request $request)
    {
        $input = $request->all();
        $oldResult = Banks::where('id', $input['id'])->first();
        $request->validate([
            'bank_name' => 'required',
            'order_no' => 'required',
            'bank_image' => 'mimes:jpeg,png,jpg|max:1024'
        ], [
            'bank_image.mimes' => 'The uploaded file must be a JPG, JPEG or PNG image.',
            'bank_image.uploaded' => 'The uploaded file may not be greater than 1 MB in size.',
        ]);
        if ($request->hasFile('bank_image')) {
            $image = $request->file('bank_image');
            $image_name = time() . '.' . $request->bank_image->extension();
            $path = public_path('upload/banks');
            $dest = $image->move($path, $image_name);
            $input['bank_image'] = $image_name;
            $oldimg = public_path('upload/banks/' . $oldResult['bank_image']);
            File::delete($oldimg);
        }
        $result = Banks::where('id', $input['id'])->update($input);
        $message = 'Banks Successfully Updated.';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function statusChange(Request $request)
    {
        try {
            $inputs = $request->all();
            $result = Banks::where('id', $inputs['id'])->update(['isActive' => $inputs['status'] == 1 ? 0 : 1]);
            $message = 'Status changed successfully.';
            if ($result) {
                return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.'));
        }
    }
}
