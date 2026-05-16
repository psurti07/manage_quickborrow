<?php
    /* get user details by id */

use Illuminate\Support\Facades\DB;
use Modules\ApplyLinks\App\Models\ApplyLink;

    if(!function_exists('userDetails')){
        function userDetails($userId){
            $userDetails = \App\Models\UserRegistration::where('id',$userId)->first();
            return $userDetails;
        }
    }

    /* get latest invoice no */
    if(!function_exists('getSiteKeyValue')){
        function getSiteKeyValue($keyname){
            $invoiceNo = \Modules\SiteOptions\App\Models\SiteOption::select('option_value')->where('option_key',$keyname)->first();
            return $invoiceNo->option_value;
        }
    }

    /* selfapply url for front */
    if(!function_exists('selfapplyurl')){
        function selfapplyurl($steps){
            $redirectUrl = '';
            switch($steps){
                case 2:
                    $redirectUrl = 'front.selfapply.personalDetails';
                    break;
                case 3:
                    $redirectUrl = 'front.selfapply.getOffers';
                    break;
                default:
                    $redirectUrl = 'front.selfapply.loanDetails';
                    break;
            }
            return $redirectUrl;
        }
    }

    /* loan gent url for front */
    if(!function_exists('loanagenturl')){
        function loanagenturl($steps){
            $redirectUrl = '';
            switch($steps){
                case 2:
                    $redirectUrl = 'front.loan-agent.personalDetails';
                    break;
                case 3:
                    $redirectUrl = 'front.loan-agent.getOffers';
                    break;
                default:
                    $redirectUrl = 'front.loan-agent.loanDetails';
                    break;
            }
            return $redirectUrl;
        }
    }

    /* Application status buttons manage */
    if(!function_exists('applicationButtons')){
        function applicationButtons($status,$appId){
            switch($status){
                case 5:
                    echo "<span class='alert alert-info m-r-5'>This application is reopen again for processing.</span>";
                    echo "<a href='".route("manage.selfapply.loan.application.status.add.status",['applicationId'=>$appId])."' class='btn btn-outline-primary m-r-5'>Add Status</a>";
                    echo "<a href='javascript:;' onclick='applicationStatus(2,".$appId.")' class='btn btn-outline-success m-r-5'>Approve Application</a>";
                    echo "<a href='javascript:;' onclick='applicationStatus(3,".$appId.")' class='btn btn-outline-danger m-r-5'>Reject Application</a>";
                    echo "<a href='javascript:;' onclick='applicationStatus(4,".$appId.")' class='btn btn-outline-warning m-r-5'>Query Process</a>";
                    break;
                case 4:
                    echo "<span class='alert alert-warning m-r-5'>This application is under query processing.</span>";
                    echo "<a href='".route("manage.selfapply.loan.application.status.add.status",['applicationId'=>$appId])."' class='btn btn-outline-primary m-r-5'>Add Status</a>";
                    echo "<a href='javascript:;' onclick='applicationStatus(2,".$appId.")' class='btn btn-outline-success m-r-5'>Approve Application</a>";
                    echo "<a href='javascript:;' onclick='applicationStatus(3,".$appId.")' class='btn btn-outline-danger m-r-5'>Reject Application</a>";
                    break;
                case 3:
                    echo "<span class='text-start m-r-5 alert alert-danger'>This application has been completely rejected.</span>";
                    echo "<a href='javascript:;' onclick='applicationStatus(5,".$appId.")' class='btn btn-outline-secondary m-r-5'>Reopen Application</a>";
                    echo "<a href='javascript:;' onclick='applicationStatus(2,".$appId.")' class='btn btn-outline-success m-r-5'>Re-approve Application</a>";
                    echo "<a href='javascript:;' onclick='applicationStatus(4,".$appId.")' class='btn btn-outline-warning m-r-5'>Query Application</a>";
                    break;
                case 2:
                    echo "<span class='alert alert-success m-r-5'>This application has been approved.</span>";
                    echo "<a href='".route("manage.selfapply.loan.application.status.add.status",['applicationId'=>$appId])."' class='btn btn-outline-primary m-r-5'>Add Status</a>";
                    echo "<a href='javascript:;' onclick='applicationStatus(4,".$appId.")' class='btn btn-outline-warning m-r-5'>Query Process</a>";
                    echo "<a href='javascript:;' onclick='applicationStatus(3,".$appId.")' class='btn btn-outline-danger m-r-5'>Reject Application</a>";
                    break;
                case 1:
                    echo "<a href='".route("manage.selfapply.loan.application.status.add.status",['applicationId'=>$appId])."' class='btn btn-outline-primary m-r-5'>Add Status</a>";
                    echo "<a href='javascript:;' onclick='applicationStatus(2,".$appId.")' class='btn btn-outline-success m-r-5'>Approve Applications</a>";
                    echo "<a href='javascript:;' onclick='applicationStatus(4,".$appId.")' class='btn btn-outline-warning m-r-5'>Query Process</a>";
                    echo "<a href='javascript:;' onclick='applicationStatus(3,".$appId.")' class='btn btn-outline-danger m-r-5'>Reject Application</a>";
                    break;
                default:
                    break;
            }
        }
    }

    /* application details with basic user information */
    if(!function_exists('appDetailsWithUser')){
        function appDetailsWithUser($appId){
            $details = DB::table('loan_applications AS a')
                ->select('a.*', 'r.id as userid', 'r.first_name', 'r.last_name', 'r.mobile', 'r.email','r.staff_id')
                ->join('user_registrations AS r','a.userid','=','r.id')
                ->where(['a.isDelete' => 0, 'a.id' => $appId])->first();
            return $details;
        }
    }

    /* get user process */
    if(!function_exists('updateUserProcess')){
        function updateUserProcess($statusId){
            $data2 = array();
            switch ($statusId) {
                case '1':
                    $data2 = array(
                        'update_date' => date('Y-m-d H:i:s'),
                        'process_step' => 11
                    );
                    break;
                case '2':
                    $data2 = array(
                        'update_date' => date('Y-m-d H:i:s'),
                        'process_step' => 10
                    );
                    break;
                case '3':
                    $data2 = array(
                        'update_date' => date('Y-m-d H:i:s'),
                        'process_step' => 7
                    );
                    break;
                case '4':
                    $data2 = array(
                        'update_date' => date('Y-m-d H:i:s'),
                        'process_step' => 8
                    );
                    break;
                case '5':
                    $data2 = array(
                        'update_date' => date('Y-m-d H:i:s'),
                        'process_step' => 9
                    );
                    break;
                case '6':
                    $data2 = array(
                        'update_date' => date('Y-m-d H:i:s'),
                        'process_step' => 5
                    );
                    break;
                default:
                    break;
            }
            return $data2;
        }
    }

    /* reject status */
    if(!function_exists('userProcessStep')){
        function userProcessStep($status){
            $data2 = array();
            switch ($status) {
                case '2':
                    $data2 = array(
                        'update_date' => date('Y-m-d H:i:s'),
                        'process_step' => 11
                    );
                    break;
                case '3':
                    $data2 = array(
                        'update_date' => date('Y-m-d H:i:s'),
                        'process_step' => 10
                    );
                    break;
                case '4':
                    $data2 = array(
                        'update_date' => date('Y-m-d H:i:s'),
                        'process_step' => 8
                    );
                    break;
                case '5':
                    $data2 = array(
                        'update_date' => date('Y-m-d H:i:s'),
                        'process_step' => 9
                    );
                    break;
                default:
                    break;
            }
            return $data2;
        }
    }

    /* get status with span tag and its color */
    if(!function_exists('getStatus')){
        function getStatus($status){
            switch($status){
                case 2:
                    $data = '- <span class="text-success">APPROVED</span>';
                    $txt = 'Approved Applications';
                    break;
                case 3:
                    $data = '- <span class="text-danger">REJECTED</span>';
                    $txt = 'Rejected Applications';
                    break;
                case 4:
                    $data = '- <span class="text-warning">QUERY PROCESS</span>';
                    $txt = 'Query Process Applications';
                    break;
                case 11:
                    $data = '- <span class="text-info">REAPPLY LOAN</span>';
                    $txt = 'Reapply Loan';
                    break;
                default:
                    $data = '';
                    $txt = 'New Applications';
                    break;
            }
            return ['data' => $data,'txt' => $txt];
        }
    }

    /* get user data */
    if(!function_exists('getUserData')){
        function getUserData($userId,$table){
            $table = $table=='cardoffer' ? '\App\Models\Cardoffer' : 'App\Models\UserRegistration';
            return $table::where('id',$userId)->first();
        }
    }

    /* user payout documents */
    if(!function_exists('userPayoutDoc')){
        function userPayoutDoc($userId){
            return DB::table('user_payout_documents')->where('userid',$userId)->first();
        }
    }

    if(!function_exists('custDashboard')){
        function custDashboard($process){
            switch ($process) {
                case '4':
                    $data = '<div class="fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex align-items-center">
                                <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="40">0</div>
                                %
                            </div>
                            <span class="text-gray-600 fw-semibold fs-5 lh-0">Membership<br/>Purchased</span>';
                    break;
                case '5':
                    $data = '<div class="fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex align-items-center">
                                <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="50">0</div>
                                %
                            </div>
                            <span class="text-gray-600 fw-semibold fs-5 lh-0">User<br/>Verified</span>';
                    break;
                case '6':
                    $data = '<div class="fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex align-items-center">
                                <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="60">0</div>
                                %
                            </div>
                            <span class="text-gray-600 fw-semibold fs-5 lh-0">Documents<br/>Verified</span>';
                    break;
                case '7':
                case '8':
                case '9':
                $data = '<div class="fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex align-items-center">
                                <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="80">0</div>
                                %
                            </div>
                            <span class="text-gray-600 fw-semibold fs-5 lh-0">Application In<br/>Process</span>';
                break;
                case '10':
                    $data = '<div class="fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex align-items-center">
                                <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="100">0</div>
                                %
                            </div>
                            <span class="text-gray-600 fw-semibold fs-5 lh-0">Application<br/>Rejected</span>';
                    break;
                case '11':
                    $data = '<div class="fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex align-items-center">
                                <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="100">0</div>
                                %
                            </div>
                            <span class="text-gray-600 fw-semibold fs-5 lh-0">Application<br/>Approved</span>';
                    break;
                default:
                    $data = '<div class="fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex align-items-center">
                                <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="40">0</div>
                                %
                            </div>
                            <span class="text-gray-600 fw-semibold fs-5 lh-0">Membership<br/>Purchased</span>';
                    break;
            }
            return $data;
        }
    }

    if(!function_exists('isRouteActive')){
        function isRouteActive($routeName){
            return request()->routeIs($routeName) ? 'active' : '';
        }
    }

    /* generate invoice */
    if(!function_exists('generateInvoice')){
        function generateInvoice($invoiceData, $invoiceNo){
            $result = \Modules\Invoice\App\Models\Invoice::create($invoiceData);
            $insertId = $result->id;

            $data2 = array(
                'rec_date' => date('Y-m-d H:i:s'),
                'option_value' => $invoiceNo + 1
            );

            $query = \Modules\SiteOptions\App\Models\SiteOption::where('option_key','newinvoiceno')->update($data2);
            return $insertId;
        }
    }

    /* checkuserdata */
    if(!function_exists('checkuserdata')){
        function checkuserdata($applyid){
            $details = DB::table('loan_applications as a')
                ->selectRaw('r.id as userid, r.rec_date, CONCAT(r.first_name," ",r.last_name) as fullname, r.mobile, r.email, r.city, r.state, r.isUser, r.process_step, a.id, a.loan_type, a.loan_amount, a.monthly_income, a.currentemi')
                ->join('user_registrations as r','r.id','=','a.userid')
                ->where('a.id', $applyid)->where('r.isDelete',0)->first();
            return $details;
        }
    }

    /* checkuserregdata */
    if(!function_exists('checkuserregdata')){
        function checkuserregdata($userid){
            $details = DB::table('loan_applications as a')
                ->selectRaw('r.id as userid, r.rec_date, CONCAT(r.first_name," ",r.last_name) as fullname, r.mobile, r.email, r.city, r.state, r.isUser, r.process_step, a.id, a.loan_type, a.loan_amount, a.monthly_income, a.currentemi')
                ->join('user_registrations as r','r.id','=','a.userid')
                ->where('r.id', $userid)->where('r.isDelete',0)->first();
            return $details;
        }
    }

    /* check membership entry */
    if(!function_exists('checkMembershipEntry')){
        function checkMembershipEntry($paymentId, $userId){
            return DB::table('membership_orders')->where('userid',$userId)->where('paymentid',$paymentId)->where('isDelete',0)->count();
        }
    }

    /* order data */
    if(!function_exists('orderdata')){
        function orderdata($orderid){
            return DB::table('razorpayentry')->where('orderid',$orderid)->first();
        }
    }
    
    if(!function_exists('calEligiblity')){
        function calEligiblity($income, $emi, $apr, $loanamount) {
            $remainamount = floor(((float)$income * 0.40) - (float)$emi);
            $monthlyemi = floor(($loanamount + ($loanamount * ($apr / 100)) * 6) / 72);
            $amount = floor(($loanamount * $remainamount) / $monthlyemi);
    
            if ($amount < 200000) {
                $amount = 195000;
            } else if ($amount > 850000) {
                $amount = 875000;
            }
            return round($amount);
        }
    }
    
    if(!function_exists('offersBankList')){
        function offersBankList($monthlyIncome, $userType, $loanAmount){
            try{
                $criteriaId = 0;
                switch($monthlyIncome) {
                    case ($monthlyIncome >= 0 && $monthlyIncome <= 15000 && $userType == 1):
                        $criteriaId = 1;
                        break;
                    case ($monthlyIncome >= 0 && $monthlyIncome <= 15000 && $userType == 2):
                        $criteriaId = 2;
                        break;
                    case ($monthlyIncome > 15000 && $monthlyIncome <= 25000 && $userType == 1):
                        $criteriaId = 3;
                        break;
                    case ($monthlyIncome > 15000 && $monthlyIncome <= 25000 && $userType == 2):
                        $criteriaId = 4;
                        break;
                    case ($monthlyIncome > 25000 && $userType == 1):
                        $criteriaId = 5;
                        break;
                    case ($monthlyIncome > 25000 && $userType == 2):
                        $criteriaId = 6;
                        break;
                    default:
                        $criteriaId = 0;
                        break;
                }
                
                $applyLinksId = DB::table('applylink_criteria')->where('criteria_id',$criteriaId)->inRandomOrder()->limit(4)->get()->pluck('applylink_id');
            
                $recommended = ApplyLink::with('bank')->where('is_recommended',1)->where('isDelete', 0)->inRandomOrder()->limit(1)->get();
                $nonRecommended = ApplyLink::with('bank')->whereIn('id',$applyLinksId)->where('isDelete', 0)->get();
                
                $banks = $recommended->merge($nonRecommended);
                
                $jsonData = [];
                foreach($banks as $applyLink){
                    $jsonData[] = [
                        'apply_id' => $applyLink->id,
                        'rec_date' => $applyLink->rec_date,
                        'bankid' => $applyLink->bankid,
                        'roi' => $applyLink->roi,
                        'bank_name' => $applyLink->bank->bank_name,
                        'bank_image' => $applyLink->bank->bank_image,
                        'tenures' => $applyLink->tenures,
                        'option1' => $applyLink->option1,
                        'option2' => $applyLink->option2,
                        'option3' => $applyLink->option3,
                        'option4' => $applyLink->option4,
                        'option5' => $applyLink->option5,
                        'title' => $applyLink->title,
                        'applyurl' => $applyLink->applyurl,
                        'loanAmount' => $loanAmount,
                        'is_recommended' => $applyLink->is_recommended
                    ];
                }
                return json_encode($jsonData);
            } catch(\Exception $e){
                dd($e->getMessage());
            }
        }
    }
    
    
    if(!function_exists('event_track')){
        function event_track($postData){
            $curl = curl_init();
            $key = env('HIRE_INTERAKT_KEY');
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.interakt.ai/v1/public/track/events/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($postData),
                CURLOPT_HTTPHEADER => [
                    "Authorization: Basic " . $key,
                    "Content-Type: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            $result = json_decode($response, true);
            return $result;
        }

    }
    
?>
