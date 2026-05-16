<?php

namespace Modules\Remarks\App\Http\Controllers;

use App\DataTables\RemarksDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Remarks\App\Models\Remark;

class RemarksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RemarksDataTable $dataTable)
    {
        return $dataTable->render('remarks::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = DB::table('loanstatus')
            ->where('isDelete', 0)
            ->pluck('statusname', 'id');
        return view('remarks::modals.addRemarks', compact('statuses'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'title' => 'required',
            'remarks' => 'required',
            'statusid' => 'required',
        ]);
        $result = Remark::create($input);
        $message = 'Remark added successfully!';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function statusChange(Request $request)
    {
        $input = $request->all();
        $result = Remark::where('id', $input['id'])->first();
        Remark::where('id', $result['id'])->update(['statusid' => $input['status'] == 1 ? 0 : 1]);
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
        $result = Remark::where('id', $input['id'])->first();
        if ($result) {
            Remark::where('id', $result['id'])->update(['isDelete' => 1]);
            $message = 'Remark deleted successfully!';
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function edit($id)
    {
        $result = Remark::where('id', $id)->first();
        $statuses = DB::table('loanstatus')
            ->where('isDelete', 0)
            ->pluck('statusname', 'id');

        return view('remarks::modals.editRemarks', [
            'data' => $result,
            'statuses' => $statuses,
        ]);
    }


    public function update(Request $request)
    {
        $input = $request->all();
        $oldResult = Remark::where('id', $input['id'])->first();
        $request->validate([
            'title' => 'required',
            'remarks' => 'required',
            'statusid' => 'required',
        ]);
        $result = Remark::where('id', $input['id'])->update($input);
        $message = 'Remark updated successfully!';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }
}
