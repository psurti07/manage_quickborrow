<?php

namespace Modules\Offers\App\Http\Controllers;

use App\DataTables\OffersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Cardoffer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class OffersController extends Controller
{
    public function index(OffersDataTable $dataTable, $offerName){
        return $dataTable->with('offerName', $offerName)->render('offers::index', compact('offerName'));
    }

    public function convertOfferUser(Request $request){
        try{
            $inputs = $request->all();
            $status = $inputs['status'] == 0 ? 1 : 0;
            $res = Cardoffer::where('id',$inputs['id'])->update(['isCustomer'=>$status]);
            $msg = $inputs['status'] == 0 ? 'Convert Lead into Customer successfully' : 'Customer convert into lead successfully!';
            if($res){
                return response()->json(array('type'=>'SUCCESS','message'=>$msg));
            } else {
                return response()->json(array('type'=>'ERROR','message'=>$msg));    
            }
        } catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(array('type'=>'ERROR','message'=>'Oops! Something went wrong.'));
        }
    }
}
