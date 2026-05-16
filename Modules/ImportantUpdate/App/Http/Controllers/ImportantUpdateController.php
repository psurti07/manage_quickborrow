<?php

namespace Modules\ImportantUpdate\App\Http\Controllers;

use App\DataTables\ImportantUpdateDataTable;
use App\Http\Controllers\Controller;
use App\Models\ImportantUpdate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pages\App\Models\InfoPages;

class ImportantUpdateController extends Controller
{
    public function index(ImportantUpdateDataTable $dataTable){
        return $dataTable->render('importantupdate::index');
    }

    public function create()
    {
        return view('importantupdate::modals.addUpdates');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'tags' => 'required',
            'descriptions' => 'required',
        ]);
        $result = ImportantUpdate::create($input);
        $message = 'Important updates addes successfully!';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function statusChange(Request $request)
    {
        $input = $request->all();
        $result = ImportantUpdate::where('id', $input['id'])->first();
        ImportantUpdate::where('id', $result['id'])->update(['isActive' => $input['status'] == 1 ? 0 : 1]);
        $message = 'Status changed successfully';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }


    public function destroy(Request $request)
    {
        $input = $request->all();
        $result = ImportantUpdate::where('id', $input['id'])->first();
        if ($result) {
            ImportantUpdate::where('id', $result['id'])->update(['isDelete' => 1]);
            $message = 'Important update record deleted successfully!';
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function edit($id)
    {
        $result = ImportantUpdate::where('id', $id)->first();
        return view('importantupdate::modals.editUpdates', [
            'data' => $result,
        ]);
    }


    public function update(Request $request)
    {
        $input = $request->all();
        $oldResult = ImportantUpdate::where('id', $input['id'])->first();
        $request->validate([
            'tags' => 'required',
            'descriptions' => 'required'
        ]);
        $result = ImportantUpdate::where('id', $input['id'])->update($input);
        $message = 'Important update updated successfully!';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }
}
