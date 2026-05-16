<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AssociatePartners extends Controller
{
    public function index(Request $request){
        try{
            $saltkey = $request->header('saltkey');
            
            $request->validate([
                'ip' => 'required',
                'fromdate' => 'required',
                'todate' => 'required',
                'product' => 'required'
            ]);
            
            $decryptKey = stringCrypt($saltkey, 'decrypt');
            
            if($request->ip === env('LOCAL_IP')) {
                if($decryptKey === env('COMPANY_CODE')) {
                    $dateResponse = $this->calculateCountWithAmt($request->fromdate, $request->todate, $request->product, 'date');
                    $yearResponse = $this->calculateCountWithAmt($request->fromdate, $request->todate, $request->product, 'year');
                    $graphResponse = $this->hourBasedCountUser($request->fromdate, $request->todate, $request->product);
                    return response()->json([
                        'date' => $dateResponse,
                        'year' => $yearResponse,
                        'graph' => $graphResponse
                    ]);
                } else {
                    return response()->json(['type'=>'ERROR','message'=>'Unauthorized Access'], 401);    
                }
            } else {
                return response()->json(['type'=>'ERROR','message'=>'Invalid Request Perform'], 400);
            }
            //return response()->json(['type'=>'SUCCESS','data'=>$decryptKey]);
        } catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['type'=>'ERROR', 'errors'=>$e->errors()]);
        } catch(\Exception $e){
            Log::info('An error occured in api.associatespatrners.index - '. $e->getMessage());
            return response()->json(['type'=>'ERROR', 'message' => 'Oops!Something went wrong.While getting turnover.']);
        }
    }
    
    
    public function calculateCountWithAmt($fromDate, $toDate, $type, $dateYear)
    {
        switch ($type) {
            case 'self':
                $mainTable = 'membership_orders AS m';
                $userTable = 'user_registrations AS r';
                $whereIn = ['SA_'];
                $where2 = ['r.acc_type' => 1];
                break;
            
            case 'hire':
                $mainTable = 'membership_orders AS m';
                $userTable = 'user_registrations AS r';
                $whereIn = ['LA_'];
                $where2 = ['r.acc_type' => 2];
                break;
           
            default:
                throw new \InvalidArgumentException('Invalid type');
        }
    
        switch ($dateYear) {
            case 'date':
                $where = "DATE(m.rec_date) BETWEEN '{$fromDate} 00:00:00' AND '{$toDate} 23:59:59'";
                break;
    
            case 'year':
                $year = date('Y');
                $month = date('m');
                $where = "YEAR(m.rec_date) = '{$year}'";
                break;
    
            default:
                throw new \InvalidArgumentException('Invalid date filter');
        }
    
        // Count total records
        $totalRecords = DB::table(DB::raw($mainTable))
            ->join(DB::raw($userTable), 'r.id', '=', 'm.userid')
            ->join('invoices AS i', 'i.cardid', '=', 'm.id')
            ->whereIn('i.inv_prefix', $whereIn)
            ->whereRaw($where)
            ->where($where2)
            ->where([
                'm.isActive' => 1,
                'm.isDelete' => 0,
                'r.isUser' => 2,
                'r.isActive' => 1,
                'r.isDelete' => 0,
                'i.isDelete' => 0,
            ])
            ->count();
    
        $chunkSize = 50;
        $numChunks = ceil($totalRecords / $chunkSize);
    
        $totalAmount = 0;
        $totalUser = 0;
    
        for ($i = 0; $i < $numChunks; $i++) {
            $offset = $i * $chunkSize;
    
            $rows = DB::table(DB::raw($mainTable))
                ->select('i.inv_price AS amount')
                ->join(DB::raw($userTable), 'r.id', '=', 'm.userid')
                ->join('invoices AS i', 'i.cardid', '=', 'm.id')
                ->whereIn('i.inv_prefix', $whereIn)
                ->whereRaw($where)
                ->where($where2)
                ->where([
                    'm.isActive' => 1,
                    'm.isDelete' => 0,
                    'r.isUser' => 2,
                    'r.isActive' => 1,
                    'r.isDelete' => 0,
                    'i.isDelete' => 0,
                ])
                ->offset($offset)
                ->limit($chunkSize)
                ->get();
    
            foreach ($rows as $row) {
                $totalAmount += $row->amount;
                $totalUser++;
            }
        }
    
        return [
            'totalUser' => $totalUser,
            'totalAmount' => $totalAmount,
        ];
    }

    public function hourBasedCountUser($fromdate, $todate, $type){
        try{
            switch ($type) {
                case 'self':
                    $mainTable = 'membership_orders AS m';
                    $userTable = 'user_registrations AS r';
                    $where2 = ['r.acc_type' => 1];
                    $whereIn = ['SA_'];
                    break;
                
                case 'hire':
                    $mainTable = 'membership_orders AS m';
                    $userTable = 'user_registrations AS r';
                    $where2 = ['r.acc_type' => 2];
                    $whereIn = ['LA_'];
                    break;
                
                default:
                    throw new \InvalidArgumentException('Invalid case');
            }
            
            // Raw date range condition
            $fromDateTime = "{$fromdate} 00:00:00";
            $toDateTime = "{$todate} 23:59:59";
            
            // Run the query
            $query = DB::table(DB::raw($mainTable))
                ->selectRaw('DATE_FORMAT(m.rec_date, "%Y-%m-%d %H:%i:00") AS InTime, COUNT(r.id) AS RecordCount')
                ->join(DB::raw($userTable), 'r.id', '=', 'm.userid')
                ->join('invoices AS i', 'i.cardid', '=', 'm.id')
                ->whereIn('i.inv_prefix', $whereIn)
                ->whereBetween('m.rec_date', [$fromDateTime, $toDateTime])
                ->where($where2)
                ->where([
                    'm.isActive' => 1,
                    'm.isDelete' => 0,
                    'r.isUser' => 2,
                    'r.isActive' => 1,
                    'r.isDelete' => 0,
                    'i.isDelete' => 0,
                ])
                ->groupBy(DB::raw('DATE_FORMAT(m.rec_date, "%Y-%m-%d %H:%i:00")'))
                ->orderBy('InTime', 'ASC')
                ->get()
                ->toArray();

            return $query;

        } catch(\Exception $e){
            Log::info('An error occured in hourBasedCountUser - ' . $e->getMessage());
            return response()->json(['type'=>'ERROR','message' => 'Oops!Something went wrong.']);
        }
    }
    
    public function todayRoyalty(Request $request)
    {
        $headers = $request->header('saltkey');
        $decryptKey = stringCrypt($headers, 'decrypt'); // Assuming helper function exists
        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');
        $product = $request->input('product');
        $ip = $request->input('ip'); // Laravel way to get IP
        
        if ($ip === env('LOCAL_IP')) {
            if ($decryptKey === env('COMPANY_CODE')) {
                $royaltyAmount = $this->calculateRoyaltyAmount($product, $fromDate, $toDate);
                return response()->json($royaltyAmount, 200);
            } else {
                return response()->json('Unauthorized Access', 401);
            }
        } else {
            return response()->json('Invalid Request Perform', 400);
        }
    }
    
    public function calculateRoyaltyAmount($product, $fromDate, $toDate)
    {
        switch ($product) {
            case 'hire':
                $mainTable = 'membership_orders AS m';
                $userTable = 'user_registrations AS r';
                $where2 = ['r.acc_type'=>2];
                $whereIn = ['LA_'];
                break;
            
            default:
                $mainTable = 'membership_orders AS m';
                $userTable = 'user_registrations AS r';
                $where2 = ['r.acc_type'=>1];
                $whereIn = ['SA_'];
                break;
        }
    
        $dateCondition = "DATE(m.rec_date) BETWEEN '{$fromDate}' AND '{$toDate}'";
    
        $totalRecords = DB::table(DB::raw($mainTable))
            ->join(DB::raw($userTable), 'r.id', '=', 'm.userid')
            ->join('invoices AS i', 'i.cardid', '=', 'm.id')
            ->whereIn('i.inv_prefix', $whereIn)
            ->whereRaw($dateCondition)
            ->where($where2)
            ->where([
                'm.isActive' => 1,
                'm.isDelete' => 0,
                'r.isUser' => 2,
                'r.isActive' => 1,
                'r.isDelete' => 0,
                'i.isdelete' => 0,
            ])
            ->count();
        $chunkSize = 50;
        $numChunks = ceil($totalRecords / $chunkSize);
        $totalAmount = 0;
    
        for ($i = 0; $i < $numChunks; $i++) {
            $offset = $i * $chunkSize;
    
            $records = DB::table(DB::raw($mainTable))
                ->select('i.inv_price AS amount')
                ->join(DB::raw($userTable), 'r.id', '=', 'm.userid')
                ->join('invoices AS i', 'i.cardid', '=', 'm.id')
                ->whereIn('i.inv_prefix', $whereIn)
                ->whereRaw($dateCondition)
                ->where($where2)
                ->where([
                    'm.isActive' => 1,
                    'm.isDelete' => 0,
                    'r.isUser' => 2,
                    'r.isActive' => 1,
                    'r.isDelete' => 0,
                    'i.isdelete' => 0,
                ])
                ->offset($offset)
                ->limit($chunkSize)
                ->get();
    
            foreach ($records as $record) {
                $totalAmount += $record->amount;
            }
        }
    
        return $totalAmount;
    }
    
}
