<?php

namespace Modules\SearchData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserRegistration;
use Illuminate\Http\Request;

class SearchDataController extends Controller
{
    public function index()
    {
        return view('searchdata::index');
    }

    public function searchData(Request $request)
    {
        try {
            $validated = $request->validate([
                'module' => 'required|in:1,2,3',
                'mobile_no' => ['required', 'numeric', 'regex:/^[6-9]\d{9}$/'],
            ]);

            $userData = UserRegistration::where('mobile', $validated['mobile_no'])
                ->where('acc_type', $validated['module'])->where('isDelete', 0)
                ->first();

            $dataHtml = view('searchdata::data_list', compact('userData'))->render();
            $data = '';
            if($userData->isUser == 1 || $userData->isUser == 2 ){
                $data = $userData->id;
                return response()->json(['type' => 'SUCCESS', 'data' => $data, 'html' => $dataHtml]);
            } else {
                return response()->json(['type' => 'ERROR', 'message' => 'User not found!', 'data'=>''], 200);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['type' => 'error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['type' => 'ERROR', 'message' => 'User not found!', 'data'=>''], 200);
        }
    }
}
