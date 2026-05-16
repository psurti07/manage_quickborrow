<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SyncDataController extends Controller
{
    
    public function syncData(Request $request)
    {
        try {
            $request->validate([
                'start_date' => 'required|date',
                'end_date'   => 'required|date',
                'product'    => 'required',
            ]);
            
            $fetchData = $this->getInvoiceData($request);
            
            if (empty($fetchData)) {
    			return response()->json([
    			    'type' => 'ERROR',
    			    'message' => 'No invoice data found for given criteria'
			    ], Response::HTTP_UNPROCESSABLE_ENTITY);
    		}
    		
    		$api_response = sendOrderData(json_encode($fetchData), 'manual_api');
    		return response()->json([
				'type'        => 'SUCCESS',
				'local_data'    => $fetchData,
				'parent_result' => $api_response
			], Response::HTTP_OK); // 200
        } catch (ValidationException $e) {
            return response()->json([
                'type'   => 'VALIDATION_ERROR',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422
    
        } catch (\Exception $e) {
            return response()->json([
                'type'    => 'ERROR',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR); // 500
        }
    }
    
    public function getInvoiceData($fields){
        try{
            switch($fields->product){
                case 'SELF APPLY':
                    $accType = 1;
                    break;
                case 'HIRE AGENT':
                    $accType = 2;
                    break;
                default:
                    $accType = 0;
                    break;
            }
            $data = DB::table('invoices as i')
                ->selectRaw("CONCAT(u.first_name,' ', u.last_name) as fullname, 
                             u.email, 
                             u.mobile, 
                             u.city, 
                             u.state, 
                             m.card_number, 
                             i.rec_date, 
                             i.inv_prefix, 
                             i.inv_number, 
                             i.inv_date, 
                             i.inv_price, 
                             i.inv_cgst, 
                             i.inv_sgst, 
                             i.inv_igst, 
                             i.inv_grandtotal, u.acc_type")
                ->leftJoin('user_registrations as u','u.id','=','i.userid')
                ->leftJoin('membership_orders as m','m.id','=','i.cardid')
                ->whereBetween('i.rec_date',[$fields->start_date.' 00:00:00', $fields->end_date.' 23:59:59'])
                ->where('u.acc_type', $accType)
                ->where('u.isUser', 2)
                ->where('u.isDelete', 0)
                ->where('i.isdelete', 0)
                ->get()
                ->map(function ($row) {
                    return [
                        'customer_name'     => $row->fullname,
                        'customer_email'    => $row->email,
                        'customer_mobile'   => $row->mobile,
                        'city'              => $row->city,
                        'state'             => $row->state,
                        'card_number'       => $row->card_number,
                        'rec_date'          => $row->rec_date,
                        'inv_prefix'        => $row->inv_prefix,
                        'inv_number'        => $row->inv_number,
                        'inv_date'          => $row->inv_date,
                        'inv_price'         => $row->inv_price,
                        'inv_cgst'          => $row->inv_cgst,
                        'inv_sgst'          => $row->inv_sgst,
                        'inv_igst'          => $row->inv_igst,
                        'inv_grandtotal'    => $row->inv_grandtotal,
                        // custom fields
                        'company_code'      => 'KREBZ1234',
                        'company_local_ip'  => '190.92.174.183',
                        'product_code'      => (($row->acc_type == 1) ? 'SELF APPLY' : 'HIRE AGENT'),
                    ];
                });
            
            return $data;
        } catch (\Exception $e) {
            return response()->json([
                'type'    => 'ERROR',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR); // 500
        }
    }
    
    
    
    
}
