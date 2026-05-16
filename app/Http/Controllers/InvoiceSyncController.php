<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\InvoiceSyncService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InvoiceSyncController extends Controller
{
    protected $invoiceSyncService;

    public function __construct(InvoiceSyncService $invoiceSyncService)
    {
        $this->invoiceSyncService = $invoiceSyncService;
    }

    public function syncInvoiceData(Request $request)
    {
        if (!$request->has('master_key') || $request->master_key !== config('constants.master_api_key')) {
            return response()->json([
                'error' => 'Unauthorized access'
            ], 403);
        }

        // VALIDATION
        $validator = Validator::make($request->all(), [
            'start_date'   => 'required|date',
            'end_date'     => 'required|date',
            'product_code' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 400);
        }

        $response = $this->invoiceSyncService->syncInvoiceData(
            $request->start_date,
            $request->end_date,
            $request->product_code
        );

        // INVALID PRODUCT CODE
        if (isset($response['error'])) {
            return response()->json([
                'error' => $response['error']
            ], 400);
        }

        // NO DATA FOUND
        if (empty($response)) {
            return response()->json([
                'message' => 'No invoice data found for given criteria'
            ], 404);
        }

        // SEND TO PARENT API
        // $apiResponse = sendOrderData(json_encode($response),'manual_api');

        // return response()->json([
        //     'status'        => 'success',
        //     'local_data'    => $response,
        //     'parent_result' => $apiResponse
        // ], 200);
    }

}
