<?php

namespace Modules\ApplyLinks\App\Http\Controllers;

use App\DataTables\ApplyLinksDataTable;
use App\Http\Controllers\Controller;
use App\Models\ApplylinkWithCriteria;
use App\Models\CriteriaList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Modules\ApplyLinks\App\Models\ApplyLink;
use Modules\Banks\App\Models\Banks;

class ApplyLinksController extends Controller
{
    public function index(ApplyLinksDataTable $dataTable)
    {
        return $dataTable->render('applylinks::index');
    }

    public function create()
    {
        $banks = Banks::where('isDelete', 0)->get();
        $criterias = CriteriaList::where('isActive', 1)->where('isDelete', 0)->orderByDesc('id')->get();
        return view('applylinks::modals.addlinks', compact('banks', 'criterias'));
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $request->validate([
            'bankid' => 'required',
            'tenures' => 'required',
            'roi' => 'required',
            'applyurl' => 'required',
            'title' => 'required',
        ], [
            'bankid.required' => 'Please select bank first',
            'tenures.required' => 'Loan Tenure field is required',
            'roi.required' => 'The ROI field is required',
            'applyurl.required' => 'Apply URl field is required',
        ]);
        $result = ApplyLink::create($inputs);
        $insertedId = $result->id;
        for ($i = 0; $i < count($inputs['criteria']); $i++) {
            ApplylinkWithCriteria::create(['applylink_id' => $insertedId, 'criteria_id' => $inputs['criteria'][$i]]);
        }
        $message = 'Apply links added successfully!';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function destroy(Request $request)
    {
        $input = $request->all();
        $result = ApplyLink::where('id', $input['id'])->first();
        if ($result) {
            ApplyLink::where('id', $result['id'])->update(['isDelete' => 1]);
            $message = 'Apply Links deleted successfully!';
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

    public function edit($id)
    {
        $banks = Banks::where('isDelete', 0)->get();
        $result = ApplyLink::where('id', $id)->first();
        $criterias = CriteriaList::where('isActive', 1)->where('isDelete', 0)->orderByDesc('id')->get();
        $checkedCriteria = ApplylinkWithCriteria::where('applylink_id', $id)->pluck('criteria_id')->toArray();
        return view('applylinks::modals.editLinks', compact('banks', 'result', 'criterias', 'checkedCriteria'));
    }

    public function update(Request $request)
    {
        try {
            $inputs = $request->all();
            $request->validate([
                'bankid' => 'required',
                'tenures' => 'required',
                'roi' => 'required',
                'applyurl' => 'required',
                'title' => 'required',
            ], [
                'bankid.required' => 'Please select bank first',
                'tenures.required' => 'Loan Tenure field is required',
                'roi.required' => 'The ROI field is required',
                'applyurl.required' => 'Apply URl field is required',
            ]);
            $updateData = Arr::except($inputs, ['criteria']);
            $updateData['is_recommended'] = $request->has('is_recommended') ? 1 : 0;
            $result = ApplyLink::where('id', $inputs['id'])->update($updateData);
            $message = 'Apply Links updated successfully!';
            ApplylinkWithCriteria::where('applylink_id', $inputs['id'])->delete();
            $res = '';
            for ($i = 0; $i < count($inputs['criteria']); $i++) {
                $res = ApplylinkWithCriteria::create(['applylink_id' => $inputs['id'], 'criteria_id' => $inputs['criteria'][$i]]);
            }
            if ($result || $res) {
                return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['type' => 'ERROR', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['type' => 'ERROR', 'message' => 'Oops! Something went wrong.']);
        }
    }
}
