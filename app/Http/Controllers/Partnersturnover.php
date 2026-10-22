<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use stdClass;

class Partnersturnover extends Controller
{
    /*public function selfapplyForJune()
    {
        $start = Carbon::createFromDate(2025, 6, 1);
        $end = Carbon::createFromDate(2025, 6, 30);
    
        for ($date = $start; $date->lte($end); $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $response = $this->hireagent($formattedDate);
            Log::info("Self Apply for {$formattedDate}: " . json_encode($response));
        }
    
        return response()->json(['status' => 'success', 'message' => 'Processed all dates in June']);
    }*/
    
    public function selfapply(){
        try{
            $recDate = Carbon::yesterday()->format('Y-m-d');
            //$recDate = Carbon::parse('2025-07-20')->format('Y-m-d');
            // Query
            $data = DB::table('membership_orders AS m')
                ->selectRaw('COUNT(DISTINCT i.userid) AS totalusers, IFNULL(SUM(i.inv_price), 0) AS totalamount')
                ->join('user_registrations AS r', 'r.id', '=', 'm.userid')
                ->join('invoices AS i', 'i.cardid', '=', 'm.id')
                ->whereIn('i.inv_prefix', ['SA_'])
                ->whereBetween(DB::raw('DATE(m.rec_date)'), [$recDate, $recDate])
                ->where([
                    'r.acc_type' => 1,
                    'm.isActive' => 1,
                    'm.isDelete' => 0,
                    'r.isUser' => 2,
                    'r.isActive' => 1,
                    'r.isDelete' => 0,
                    'i.isdelete' => 0,
                ])
                ->first();
        
            // Convert result to array if not null
            $array = (array) $data;
            // Add extra fields
            $array['inv_date'] = $recDate;
            $array['companycode'] = env('COMPANY_CODE'); // or config('app.company_code')
            $array['product'] = 'SELF APPLY';
        
            // Call submitturnover (assuming it's a method in this controller)
            $response = $this->submitturnover($array);
            // Output
            return 0;    
        } catch(\Exception $e){
            Log::info('An error occured in self turnover - ' . $e->getMessage());
            return response()->json(['type'=>'ERROR', 'message'=>'Oops!Something went wrong'],400);
        }
    }
    
    public function hireagent(){
        try{
            $recDate = Carbon::yesterday()->format('Y-m-d');
            //$recDate = Carbon::parse('2025-07-20')->format('Y-m-d');

            // Query
            $data = DB::table('membership_orders AS m')
                ->selectRaw('COUNT(DISTINCT i.userid) AS totalusers, IFNULL(SUM(i.inv_price), 0) AS totalamount')
                ->join('user_registrations AS r', 'r.id', '=', 'm.userid')
                ->join('invoices AS i', 'i.cardid', '=', 'm.id')
                ->whereIn('i.inv_prefix', ['LA_'])
                ->whereBetween(DB::raw('DATE(m.rec_date)'), [$recDate, $recDate])
                ->where([
                    'r.acc_type' => 2,
                    'm.isActive' => 1,
                    'm.isDelete' => 0,
                    'r.isUser' => 2,
                    'r.isActive' => 1,
                    'r.isDelete' => 0,
                    'i.isdelete' => 0,
                ])
                ->first();
        
            // Convert result to array if not null
            $array = (array) $data;
        
            // Add extra fields
            $array['inv_date'] = $recDate;
            $array['companycode'] = env('COMPANY_CODE'); // or config('app.company_code')
            $array['product'] = 'HIRE AGENT';
        
            // Call submitturnover (assuming it's a method in this controller)
            $response = $this->submitturnover($array);
        
            // Output
            return 0;    
        } catch(\Exception $e){
            Log::info('An error occured in hire turnover - ' . $e->getMessage());
            return response()->json(['type'=>'ERROR', 'message'=>'Oops!Something went wrong'],400);
        }
    }
    
    public function submitturnover(array $data){
        try{
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://bizfin.indiakarobar.com/api/manage/partners-turnover', $data);
    
            if ($response->successful()) {
                return $response->json(); // Return decoded array
            } else {
                return [
                    'error' => true,
                    'status' => $response->status(),
                    'message' => $response->body(),
                ];
            }
        } catch(\Exception $e){
            Log::info('An error occured in submitutnover - ' . $e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops!Something went wrong']);
        }
    }
}
