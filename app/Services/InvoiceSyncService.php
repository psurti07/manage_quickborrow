<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceSyncService
{
    public function syncInvoiceData($startDate, $endDate, $productCode)
    {
        $tableMap = [

            'SELFAPPLY' => [
                'user_table'  => 'user_registration',
                'order_table' => 'membership_order',
                'inv_for'     => 'SA_'
            ],

            'HIREAGENT' => [
                'user_table'  => 'user_registration',
                'order_table' => 'membership_order',
                'inv_for'     => 'LA_'
            ],

            'default' => [
                'user_table'  => 'user_registration',
                'order_table' => 'membership_order',
                'inv_for'     => ''
            ]
        ];

        // CHECK PRODUCT CODE
        if (!isset($tableMap[$productCode])) {
            return [
                'error' => 'Invalid product code'
            ];
        }

        $orderTable = $tableMap[$productCode]['order_table'];
        $userTable  = $tableMap[$productCode]['user_table'];
        $inv_prefix     = $tableMap[$productCode]['inv_prefix'];

        $data = DB::table('invoice as i')
            ->select(
                'u.fullname as customer_name',
                'u.email as customer_email',
                'u.mobile as customer_mobile',
                'u.id as userid',
                'u.city',
                'u.state',
                'so.card_number as card_number',
                'i.rec_date',
                'i.inv_for',
                'i.inv_prefix',
                'i.inv_number',
                'i.inv_date',
                'i.inv_price',
                'i.inv_cgst',
                'i.inv_sgst',
                'i.inv_igst',
                'i.inv_grandtotal'
            )
            ->leftJoin("$orderTable as so", 'so.userid', '=', 'i.userid')
            ->leftJoin("$userTable as u", 'u.id', '=', 'i.userid')
            ->whereBetween('i.rec_date', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ])
            ->whereIn('i.inv_prefix', $inv_prefix)
            ->where('u.isDelete', 0)
            ->where('u.isUser', 2)
            ->where('i.isDelete', 0)
            ->orderBy('i.rec_date', 'DESC')
            ->get()
            ->map(function ($row) use ($productCode) {

                $row->company_code     = config('constants.company_code');
                $row->company_local_ip = config('constants.local_ip');
                $row->product_code     = $productCode;

                return $row;

            })
            ->toArray();

        Log::info('syc invoice resonse true'); 
        return $data;
    }
}