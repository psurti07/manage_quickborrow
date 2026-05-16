<?php

use App\Models\Cardoffer;
use App\Models\AirpayEntry;
use App\Models\CashfreeEntry;
use App\Models\CipherPayEntry;
use App\Models\LyraEntry;
use App\Models\PaygicEntry;
use App\Models\PhonePeEntry;
use App\Models\Razorpayentry;
use App\Models\VeegahPay;
use App\Models\SabpaisaEntry;
use App\Models\UserRegistration;
use App\Models\ZaakpayEntry;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Auth\App\Models\Administrations;
    
    if(!function_exists('stringCrypt')){
        function stringCrypt( $string, $action = 'encrypt' ) {
            $output = false;
            $encrypt_method = "AES-256-CBC";
            $key = hash( 'sha256', env('SECURE_SALT') );
            $iv = substr( hash( 'sha256', 'wecoder_iv' ), 0, 16 );
         
            if( $action == 'encrypt' ) {
                $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
            }
            else if( $action == 'decrypt' ){
                $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
            }
            return $output;
        }
    }
    
    if(!function_exists('random_code')){
        function random_code($length = 6){
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890123456789abcdefghijklmnopqrstuvwxyz";
            $code = substr( str_shuffle( $chars ), 0, $length );
            return $code;
        }
    }

    if(!function_exists('formatePrice')) {
        function formatePrice($price)
        {
            if (is_numeric($price)) {
                return number_format($price, 0);
            } else {
                if (empty($price)) {
                    return "0.00";
                } else {
                    return $price;
                }
            }
        }
    }

    if(!function_exists('formatePriceIndia')) {
        function formatePriceIndia($num, $decimal = 1) {
            $explrestunits = "";
            $num = preg_replace('/,+/', '', $num);
            $words = explode(".", $num);
            $des = "00";

            if (count($words) <= 2) {
                $num = $words[0];
                if (count($words) >= 2) {
                    $des = $words[1];
                }
                if (strlen($des) < 2) {
                    $des = "$des";
                } else {
                    $des = substr($des, 0, 2);
                }
            }
            if (strlen($num) > 3) {
                $lastthree = substr($num, strlen($num) - 3, strlen($num));
                $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
                $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
                $expunit = str_split($restunits, 2);
                for ($i = 0; $i < sizeof($expunit); $i++) {
                    // creates each of the 2's group and adds a comma to the end
                    if ($i == 0) {
                        $explrestunits .= (int)$expunit[$i] . ","; // if is first value , convert into integer
                    } else {
                        $explrestunits .= $expunit[$i] . ",";
                    }
                }
                $thecash = $explrestunits . $lastthree;
            } else {
                $thecash = $num;
            }

            if ($decimal == 0) {
                return $thecash;
            } else {
                return $thecash . "." . $des;
            }
        }
    }

    if(!function_exists('numberTowords')) {
        function numberTowords($num) {
            $ones = array(
                1 => "one",
                2 => "two",
                3 => "three",
                4 => "four",
                5 => "five",
                6 => "six",
                7 => "seven",
                8 => "eight",
                9 => "nine",
                10 => "ten",
                11 => "eleven",
                12 => "twelve",
                13 => "thirteen",
                14 => "fourteen",
                15 => "fifteen",
                16 => "sixteen",
                17 => "seventeen",
                18 => "eighteen",
                19 => "nineteen"
            );

            $tens = array(
                1 => "ten",
                2 => "twenty",
                3 => "thirty",
                4 => "forty",
                5 => "fifty",
                6 => "sixty",
                7 => "seventy",
                8 => "eighty",
                9 => "ninety"
            );
            $hundreds = array(
                "hundred",
                "thousand",
                "million",
                "billion",
                "trillion",
                "quadrillion"
            ); //limit t quadrillion

            $num = number_format($num, 2, ".", ",");
            $num_arr = explode(".", $num);
            $wholenum = $num_arr[0];
            $decnum = $num_arr[1];
            $whole_arr = array_reverse(explode(",", $wholenum));
            krsort($whole_arr);
            $rettxt = "";
            foreach ($whole_arr as $key => $i) {
                if ($i < 20) {
                    $rettxt .= $ones[$i];
                } elseif ($i < 100) {
                    $rettxt .= $tens[substr($i, 0, 1)];
                    $rettxt .= " " . $ones[substr($i, 1, 1)];
                } else {
                    $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
                    $rettxt .= " " . $tens[substr($i, 1, 1)];
                    $rettxt .= " " . $ones[substr($i, 2, 1)];
                }
                if ($key > 0) {
                    $rettxt .= " " . $hundreds[$key] . " ";
                }
            }
            if ($decnum > 0) {
                $rettxt .= " and ";
                if ($decnum < 20) {
                    $rettxt .= $ones[$decnum];
                } elseif ($decnum < 100) {
                    $rettxt .= $tens[substr($decnum, 0, 1)];
                    $rettxt .= " " . $ones[substr($decnum, 1, 1)];
                }
            }
            return trim($rettxt);
        }
    }

    if(!function_exists('random_code_num')) {
        function random_code_num( $length = 6 ) {
            $chars = "01234567890123456789";
            $code = substr( str_shuffle( $chars ), 0, $length );
            return $code;
        }
    }

    if(!function_exists('displayDate')){
        function displayDate($date) {
            if($date=="0000-00-00") {
                $dis_date = "-";
            } else {
                $dis_date = date("d/m/Y",strtotime($date));
            }
            return $dis_date;
        }
    }

    if(!function_exists('displayTime')){
        function displayTime($time){
            $dis_time = date("h:i A",strtotime($time));
            return $dis_time;
        }
    }

    if(!function_exists('dateDiffInMinutes')){
        function dateDiffInMinutes($date1, $date2) {
            // Calulating the difference in timestamps
            if($date1!="" && $date2!="") {
                $difference = strtotime($date2) - strtotime($date1);
                /*$minutes = floor($difference / 60);
                $out = floor($minutes / 60).':'.($minutes -   floor($minutes / 60) * 60);*/
                $out = abs(round($difference / 60));
            }
            else {
                $out = "-";
            }
            return $out;
        }
    }

    if(!function_exists('fetchRecDate')){
        function fetchRecDate($rec_date) {
            $current_date = date('Y-m-d H:i:s');
        
            if(dateDiffInDays($rec_date, $current_date) <= 7) {
                $date = get_time_ago($rec_date);
            } else {
                $date = displayDate($rec_date);
            }
        
            return $date;
        }
    }

    if(!function_exists('get_time_ago')){
        function get_time_ago($rec_date) {
            // Convert date into strtotime to calculate difference
            if($rec_date != "") {
                $time = strtotime($rec_date);
                $time_difference = time() - $time;
        
                if( $time_difference < 1 ) { return 'less than 1 second ago'; }
                $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                            30 * 24 * 60 * 60       =>  'month',
                            24 * 60 * 60            =>  'day',
                            60 * 60                 =>  'hour',
                            60                      =>  'minute',
                            1                       =>  'second'
                );
        
                foreach( $condition as $secs => $str ) {
                    $d = $time_difference / $secs;
        
                    if( $d >= 1 ) {
                        $t = round( $d );
                        return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
                    }
                }
            }
            else {
                return "Never";
            }
        }
    }

    if(!function_exists('dateDiffInDays')){
        function dateDiffInDays($date1, $date2) {
            // Calulating the difference in timestamps
            if($date1!="" && $date2!="") {
                $difference = strtotime($date2) - strtotime($date1);
                /*$minutes = floor($difference / 60);
                $out = floor($minutes / 60).':'.($minutes -   floor($minutes / 60) * 60);*/
                $out = abs(round($difference / 86400));
            }
            else {
                $out = "-";
            }
            return $out;
        }
    }

    if(!function_exists('loanEmiCalculator')){
        function loanEmiCalculator($principal,$roi,$tenure){
            $emi = 0;
            $roi = ($roi / 12) / 100;
            $emi = ($principal * $roi * pow(1 + $roi, $tenure)) / (pow(1 + $roi, $tenure) - 1);
            return ceil($emi);
        }
    }

    if(!function_exists('getStateOption')){
        function getStateOption($selected_state = ''){
            $states = array("Andaman and Nicobar Islands"=>"Andaman and Nicobar Islands",
                "Andhra Pradesh"=>"Andhra Pradesh",
                "Arunachal Pradesh"=>"Arunachal Pradesh",
                "Assam"=>"Assam",
                "Bihar"=>"Bihar",
                "Chandigarh"=>"Chandigarh",
                "Chhattisgarh"=>"Chhattisgarh",
                "Dadra and Nagar Haveli"=>"Dadra and Nagar Haveli",
                "Daman and Diu"=>"Daman and Diu",
                "Delhi"=>"Delhi",
                "Goa"=>"Goa",
                "Gujarat"=>"Gujarat",
                "Haryana"=>"Haryana",
                "Himachal Pradesh"=>"Himachal Pradesh",
                "Jammu and Kashmir"=>"Jammu and Kashmir",
                "Jharkhand"=>"Jharkhand",
                "Karnataka"=>"Karnataka",
                "Kerala"=>"Kerala",
                "Ladakh"=>"Ladakh",
                "Lakshadweep"=>"Lakshadweep",
                "Madhya Pradesh"=>"Madhya Pradesh",
                "Maharashtra"=>"Maharashtra",
                "Manipur"=>"Manipur",
                "Meghalaya"=>"Meghalaya",
                "Mizoram"=>"Mizoram",
                "Nagaland"=>"Nagaland",
                "Odisha"=>"Odisha",
                "Puducherry"=>"Puducherry",
                "Punjab"=>"Punjab",
                "Rajasthan"=>"Rajasthan",
                "Sikkim"=>"Sikkim",
                "Tamil Nadu"=>"Tamil Nadu",
                "Telangana"=>"Telangana",
                "Tripura"=>"Tripura",
                "Uttar Pradesh"=>"Uttar Pradesh",
                "Uttarakhand"=>"Uttarakhand",
                "West Bengal"=>"West Bengal");
            $option = '';
            foreach($states as $key=>$value){
                $option .= "<option ";
                $option .= " value=\"".$value."\"";
                if ( $selected_state == $value ) {
                    $option .= " selected";
                }
                $option .= " >";
                $option .= $key;
                $option .= "</option>";
            }
            return $option;
        }
    }

    if(!function_exists('getStateAbbreviation')){
        function getStateAbbreviation($state_name = '') {
            $states = array("Andaman and Nicobar Islands"=>"AN",
                "Andhra Pradesh"=>"AP",
                "Arunachal Pradesh"=>"AR",
                "Assam"=>"AS",
                "Bihar"=>"BR",
                "Chandigarh"=>"CH",
                "Chhattisgarh"=>"CT",
                "Dadra and Nagar Haveli"=>"DN",
                "Daman and Diu"=>"DD",
                "Delhi"=>"DL",
                "Goa"=>"GA",
                "Gujarat"=>"GJ",
                "Haryana"=>"HR",
                "Himachal Pradesh"=>"HP",
                "Jammu and Kashmir"=>"JK",
                "Jharkhand"=>"JH",
                "Karnataka"=>"KA",
                "Kerala"=>"KL",
                "Ladakh"=>"LA",
                "Lakshadweep"=>"LD",
                "Madhya Pradesh"=>"MP",
                "Maharashtra"=>"MH",
                "Manipur"=>"MN",
                "Meghalaya"=>"ML",
                "Mizoram"=>"MZ",
                "Nagaland"=>"NL",
                "Odisha"=>"OR",
                "Puducherry"=>"PY",
                "Punjab"=>"PB",
                "Rajasthan"=>"RJ",
                "Sikkim"=>"SK",
                "Tamil Nadu"=>"TN",
                "Telangana"=>"TG",
                "Tripura"=>"TR",
                "Uttar Pradesh"=>"UP",
                "Uttarakhand"=>"UT",
                "West Bengal"=>"WB");
            $statecode = 'GJ';
            foreach($states as $key=>$value){
                if ( $state_name == $key ) {
                    $statecode = $value;
                }
            }
            return $statecode;
        }
    }

    if(!function_exists('capitalizeFirstLetter')){
        function capitalizeFirstLetter($input) {
            return ucwords(strtolower($input));
        }
    }

    if(!function_exists('taskPriority')){
        function taskPriority($priority){
            $msg = '';
            switch ($priority) {
                case 'Low':
                    $msg = '<div class="note-labels"><span class="badge badge-light-success">Low</span></div>';
                    break;
                case 'Medium':
                    $msg = '<div class="note-labels"><span class="badge badge-light-primary">Medium</span></div>';
                    break;
                case 'High':
                    $msg = '<div class="note-labels"><span class="badge badge-light-warning">High</span></div>';
                    break;
                case 'Urgent':
                    $msg = '<div class="note-labels"><span class="badge badge-light-danger">Urgent</span></div>';
                    break;
                default:
                    $msg = '<div class="note-labels"><span class="badge badge-light-success">N/A</span></div>';
                    break;
            }
            return $msg;
        }
    }

    if(!function_exists('taskPriorityOptions')){
        function taskPriorityOptions($priority){
            return '<div class="form-check-size">
                        <div class="form-check form-check-inline radio radio-success">
                          <input class="form-check-input" id="low" type="radio" name="priority" value="Low">
                          <label class="form-check-label mb-0" for="low">Low</label>
                        </div>
                        <div class="form-check form-check-inline radio radio-warning">
                          <input class="form-check-input" id="medium" type="radio" name="priority" value="Medium" checked>
                          <label class="form-check-label mb-0" for="medium">Medium</label>
                        </div>
                        <div class="form-check form-check-inline radio radio-secondary">
                          <input class="form-check-input" id="high" type="radio" name="priority" value="High">
                          <label class="form-check-label mb-0" for="high">High</label>
                        </div>
                        <div class="form-check form-check-inline radio radio-danger">
                          <input class="form-check-input" id="urgent" type="radio" name="priority" value="Urgent">
                          <label class="form-check-label mb-0" for="urgent">Urgent</label>
                        </div>
                      </div>';
        }
    }

    if(!function_exists('taskModulesOptions')){
        function taskModulesOptions($selected_module){
            $modules = array(
                'Admin Panel' => 'Admin Panel',
                'Payment Gateway' => 'Payment Gateway',
                'Landing Designing' => 'Landing Designing',
                'Website Designing' => 'Website Designing',
                'Remarketing Cycle' => 'Remarketing Cycle',
                'SMS' => 'SMS'
            );
            $option = '';
            foreach($modules as $key=>$value){
                $option .= "<option ";
                $option .= " value=\"".$value."\"";
                if ( $selected_module == $value ) {
                    $option .= " selected";
                }
                $option .= " >";
                $option .= $key;
                $option .= "</option>";
            }
            return $option;
        }
    }

    if(!function_exists('projectsOptions')){
        function projectsOptions($project){
            $modules = array(
                'Easyailoans' => 'Easyailoans'
            );
            $option = '';
            foreach($modules as $key=>$value){
                $option .= "<option ";
                $option .= " value=\"".$value."\"";
                if ( $project == $value ) {
                    $option .= " selected";
                }
                $option .= " >";
                $option .= $key;
                $option .= "</option>";
            }
            return $option;
        }
    }

    if(!function_exists('taskGoalOptions')){
        function taskGoalOptions($goal){
            $modules = array(
                'Monthly' => 'Monthly',
                'Long Term' => 'Long Term',
                'Weekly' => 'Weekly',
                'Daily' => 'Daily',
            );
            $option = '';
            foreach($modules as $key=>$value){
                $option .= "<option ";
                $option .= " value=\"".$value."\"";
                if ( $goal == $value ) {
                    $option .= " selected";
                }
                $option .= " >";
                $option .= $key;
                $option .= "</option>";
            }
            return $option;
        }
    }

    if(!function_exists('taskStatus')){
        function taskStatus($status, $id){
            $msg = '';
            $statusBtn = '
                            <span class="badge badge-light-'.($status == 'Open' ? 'info' : ($status == 'Process' ? 'warning' : ($status == 'Hold' ? 'info' : ($status == 'Completed' ? 'success' : 'danger')))).' dropdown-toggle" type="button" data-bs-toggle="dropdown">'.$status.'</span>
                            <div class="dropdown-menu" style="z-index:999!important;">
                                <a class="dropdown-item" href="javascript:;" onclick="statusChange('.$id.',\'Open\')">Open</a>
                                <a class="dropdown-item" href="javascript:;" onclick="statusChange('.$id.',\'Process\')">Process</a>
                                <a class="dropdown-item" href="javascript:;" onclick="statusChange('.$id.',\'Hold\')">Hold</a>
                                <a class="dropdown-item" href="javascript:;" onclick="statusChange('.$id.',\'Completed\')">Completed</a>
                                <a class="dropdown-item" href="javascript:;" onclick="statusChange('.$id.',\'Cancelled\')">Cancelled</a>
                            </div>
                        ';
            return $statusBtn;
        }
    }

    if(!function_exists('taskStatusOptions')){
        function taskStatusOptions($selected_status){
            return '<div class="form-check-size">
                        <div class="form-check form-check-inline radio radio-danger">
                          <input class="form-check-input" id="open" type="radio" name="task_status" value="Open" checked>
                          <label class="form-check-label mb-0" for="open">Open</label>
                        </div>
                        <div class="form-check form-check-inline radio radio-warning">
                          <input class="form-check-input" id="process" type="radio" name="task_status" value="Process">
                          <label class="form-check-label mb-0" for="process">Process</label>
                        </div>
                        <div class="form-check form-check-inline radio radio-info">
                          <input class="form-check-input" id="hold" type="radio" name="task_status" value="Hold">
                          <label class="form-check-label mb-0" for="hold">Hold</label>
                        </div>
                        <div class="form-check form-check-inline radio radio-success">
                          <input class="form-check-input" id="completed" type="radio" name="task_status" value="Completed">
                          <label class="form-check-label mb-0" for="completed">Completed</label>
                        </div>
                        <div class="form-check form-check-inline radio radio-danger">
                          <input class="form-check-input" id="cancelled" type="radio" name="task_status" value="Cancelled">
                          <label class="form-check-label mb-0" for="cancelled">Cancelled</label>
                        </div>
                      </div>';
        }
    }

    if(!function_exists('DateFormatDisplay')){
        function DateFormatDisplay($date) {
            if($date=="0000-00-00" || $date=="") {
                $dis_date = "-";
            } else {
                $dis_date = date("d/m/Y H:i",strtotime($date));
            }
            return $dis_date;
        }
    }

    if(!function_exists('getMessageWhatsappSettings')){
        function getMessageWhatsappSettings($slug){
            switch($slug){
                case 'sa-wp-remarketing':
                    $message = 'SA Whatsapp Remarketing field updated successfully!';
                    break;
                case 'sa-wp-getoffer':
                    $message = 'SA Whatsapp Get Offer field updated successfully!';
                    break;
                case 'sa-wp-payment-success':
                    $message = 'SA Whatsapp Payment Success field updated successfully!';
                    break;
                case 'sa-wp-username-password':
                    $message = 'SA Whatsapp Username Password field updated successfully!';
                    break;
                case 'la-wp-remarketing':
                    $message = 'LA Whatsapp Remarketing field updated successfully!';
                    break;
                case 'la-wp-getoffer':
                    $message = 'LA Whatsapp Get Offer field updated successfully!';
                    break;
                case 'la-wp-payment-success':
                    $message = 'LA Whatsapp Payment Success field updated successfully!';
                    break;
                case 'la-wp-username-password':
                    $message = 'LA Whatsapp Username Password field updated successfully!';
                    break;
                default:
                    $message = 'Something went wrong';
                    break;
            }
            return $message;
        }
    }
    
    if(!function_exists('getMessageSettings')){
        function getMessageSettings($slug){
            switch($slug){
                case 'sa-senderid':
                    $message = 'Self Apply SenderId field updated successfully!';
                    break;
                case 'sa-senderid-otp':
                    $message = 'Self Apply SenderId OTP field updated successfully!';
                    break;
                case 'la-senderid':
                    $message = 'Loan Agent SenderId field updated successfully!';
                    break;
                case 'la-senderid-otp':
                    $message = 'Loan Agent SenderId OTP field updated successfully!';
                    break;
                case 'common-senderid':
                    $message = 'Common SenderId field updated successfully!';
                    break;
                default:
                    $message = 'Something went wrong';
                    break;
            }
            return $message;
        }
    }
    
    
    // if (!function_exists('getPostalDetailsByPincode')) {
    //     function getPostalDetailsByPincode($pincode) {
    //         $api_url = "https://api.postalpincode.in/pincode/" . $pincode;
           
    //         $response = file_get_contents($api_url);
    //         $data = json_decode($response, true);
            
    //         if ($data[0]['Status'] == "Success") {
    //             return [
    //                 'city' => $data[0]['PostOffice'][0]['District'],
    //                 'state' => $data[0]['PostOffice'][0]['State']
    //             ];
    //         } else {
    //             return ['error' => 'Invalid Pincode'];
    //         }
    //     }
    // }

    if (!function_exists('getPostalDetailsByPincode')) {
        function getPostalDetailsByPincode($pincode) {
            $curl = curl_init(); 
            curl_setopt_array($curl, [ 
                CURLOPT_URL => 'https://geoloc.in/api/pincode',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode(['pincode' => $pincode]),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Authorization: Bearer '.env('GEOLOC_KEY')
                ],
            ]);
            $response = curl_exec($curl);
            curl_close($curl);
        
            $data = json_decode($response);
            
            if ($data->status == "success") {
                return [
                    'city' => $data->data[0]->cityname,
                    'state' => $data->data[0]->statename
                ];
            } else {
                return ['error' => 'Invalid Pincode'];
            } 
        }
    }
    

    if(!function_exists('dashboardData')){
        function dashboardData($type){
            $cust = UserRegistration::where('rec_date', 'like', date('Y-m-d').'%')
            ->where('isUser',2)
            ->where('acc_type',$type)
            ->where('isDelete',0)
            ->count();
            
            $lead = UserRegistration::where('update_date', 'like', date('Y-m-d').'%')
            ->where('isUser',1)
            ->where('acc_type',$type)
            ->where('isDelete',0)
            ->count();

            $amount = DB::table('membership_orders as mo')
            ->join('user_registrations as ur', 'ur.id', '=', 'mo.userid')
            ->where('mo.rec_date', 'like', date('Y-m-d').'%')
            ->where(['mo.isActive'=> 1,'mo.isDelete'=> 0])
            ->where(['ur.isUser'=> 2,'ur.acc_type'=> $type])
            ->where(['ur.isActive'=> 1,'ur.isDelete'=> 0])
            ->selectRaw('SUM(mo.amount) as totalAmt')
            ->first();
            
            $days = (($type == 1) ? 7 : (($type == 2) ? 10 : 7));
            $processStep = (($type == 1) ? 6 : (($type == 2) ? 11 : 11));
            
            $openAc = DB::table('user_registrations')
            ->where(['isUser'=>2,'acc_type'=>$type,'isDelete'=>0])
            ->where('process_step', '!=', $processStep)
            ->whereRaw('DATE(rec_date) <= ?', [Carbon::now()->subDays($days)->format('Y-m-d')])->count();
            
            return ['customers'=>$cust, 'leads'=>$lead, 'amount' => $amount->totalAmt, 'openAccounts' => $openAc];
        }
    }

    if(!function_exists('processStepsData')){
        function processStepsData($type, $fromDate, $toDate){
            $ps1 = UserRegistration::whereRaw('DATE(update_date) BETWEEN ? AND ?', [$fromDate, $toDate])
            ->where(['acc_type' => $type, 'process_step'=>1])
            ->where(['isDelete' => 0, 'isActive'=>1])
            ->count();

            $ps2 = UserRegistration::whereRaw('DATE(update_date) BETWEEN ? AND ?', [$fromDate, $toDate])
            ->where(['acc_type' => $type, 'process_step'=>2])
            ->where(['isDelete' => 0, 'isActive'=>1])
            ->count();

            $ps3 = UserRegistration::whereRaw('DATE(update_date) BETWEEN ? AND ?', [$fromDate, $toDate])
            ->where(['acc_type' => $type, 'process_step'=>3])
            ->where(['isDelete' => 0, 'isActive'=>1])
            ->count();

            $ps4 = UserRegistration::whereRaw('DATE(update_date) BETWEEN ? AND ?', [$fromDate, $toDate])
            ->where(['acc_type' => $type, 'process_step'=>4])
            ->where(['isDelete' => 0, 'isActive'=>1])
            ->count();

            $ps5 = UserRegistration::whereRaw('DATE(update_date) BETWEEN ? AND ?', [$fromDate, $toDate])
            ->where(['acc_type' => $type, 'process_step'=>5])
            ->where(['isDelete' => 0, 'isActive'=>1])
            ->count();
            
            $ps6 = UserRegistration::whereRaw('DATE(update_date) BETWEEN ? AND ?', [$fromDate, $toDate])
            ->where(['acc_type' => $type, 'process_step'=>6])
            ->where(['isDelete' => 0, 'isActive'=>1])
            ->count();
            
            $ps7 = UserRegistration::whereRaw('DATE(update_date) BETWEEN ? AND ?', [$fromDate, $toDate])
            ->where(['acc_type' => $type, 'process_step'=>7])
            ->where(['isDelete' => 0, 'isActive'=>1])
            ->count();
            
            $ps8 = UserRegistration::whereRaw('DATE(update_date) BETWEEN ? AND ?', [$fromDate, $toDate])
            ->where(['acc_type' => $type, 'process_step'=>8])
            ->where(['isDelete' => 0, 'isActive'=>1])
            ->count();
            
            $ps9 = UserRegistration::whereRaw('DATE(update_date) BETWEEN ? AND ?', [$fromDate, $toDate])
            ->where(['acc_type' => $type, 'process_step'=>9])
            ->where(['isDelete' => 0, 'isActive'=>1])
            ->count();
            
            $ps10 = UserRegistration::whereRaw('DATE(update_date) BETWEEN ? AND ?', [$fromDate, $toDate])
            ->where(['acc_type' => $type, 'process_step'=>10])
            ->where(['isDelete' => 0, 'isActive'=>1])
            ->count();
            
            $ps11 = UserRegistration::whereRaw('DATE(update_date) BETWEEN ? AND ?', [$fromDate, $toDate])
            ->where(['acc_type' => $type, 'process_step'=>11])
            ->where(['isDelete' => 0, 'isActive'=>1])
            ->count();
            
            return ['processOne'=>$ps1, 'processTwo'=>$ps2, 'processThree'=>$ps3, 'processFour'=>$ps4, 'processFive'=>$ps5, 'processSix'=>$ps6, 'processSeven'=>$ps7, 'processEight'=>$ps8, 'processNine'=>$ps9, 'processTen'=>$ps10, 'processEleven'=>$ps11];
        }
    }

    if(!function_exists('paymentGatewayPayments')){
        function paymentGatewayPayments(){
            // Self Apply Payment Gateway Statestics
            $razorPaySA = Razorpayentry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['6', '7', '8', '9', '11', '21', '31'])
                ->whereNotNull('referenceid')
                ->where('txstatus','100')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt;
            $zaakPaySA = ZaakpayEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['6', '7', '8', '9', '11', '21', '31'])
                ->whereNotNull('transactionid')
                ->where('statuscode','100')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt;
            $paygicPGSA = PaygicEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['6', '7', '8', '9', '11', '21', '31'])
                ->whereNotNull('referenceid')
                ->where('txstatus','SUCCESS')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt;
            $lyraPGSA = LyraEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['6', '7', '8', '9', '11', '21', '31'])
                ->whereNotNull('transactionid')
                ->where('statuscode','PAID')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt;
            $sabpaisaPGSA = SabpaisaEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['6', '7', '8', '9', '11', '21', '31'])
                ->whereNotNull('referenceid')
                ->where('txstatus','SUCCESS')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt;
            /* $cipherPaySA = CipherPayEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['6', '7', '8', '9', '11', '21', '31'])
                ->whereNotNull('referenceid')
                ->where('txstatus','1')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt; */
            $phonePeSA = PhonePeEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['6', '7', '8', '9', '11', '21', '31'])
                ->whereNotNull('referenceid')
                ->where('txstatus','PAYMENT_SUCCESS')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt;
            /* $airpaySA = AirpayEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['6', '7', '8', '9', '11', '21', '31'])
                ->whereNotNull('transactionid')
                ->where('statuscode','200')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt; */
            /* $cashfreeSA = CashfreeEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['6', '7', '8', '9', '11', '21', '31'])
                ->whereNotNull('referenceid')
                ->where('txstatus','SUCCESS')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt; */

            // Loan Agent Payment Gateway Statestics
            $razorPayLA = Razorpayentry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['3', '4', '5', '10', '12', '22','32'])
                ->whereNotNull('referenceid')
                ->where('txstatus','100')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt;

            $zaakPayLA = ZaakpayEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['3', '4', '5', '10', '12', '22','32'])
                ->whereNotNull('transactionid')
                ->where('statuscode','100')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt;
            $paygicLA = PaygicEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['3', '4', '5', '10', '12', '22','32'])
                ->whereNotNull('referenceid')
                ->where('txstatus','SUCCESS')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt;
            $lyraPGLA = LyraEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['3', '4', '5', '10', '12', '22','32'])
                ->whereNotNull('transactionid')
                ->where('statuscode','PAID')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt;
            $sabpaisaPGLA = SabpaisaEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['3', '4', '5', '10', '12', '22','32'])
                ->whereNotNull('referenceid')
                ->where('txstatus','SUCCESS')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt;
            /* $cipherPayLA = CipherPayEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['3', '4', '5', '10', '12', '22','32'])
                ->whereNotNull('referenceid')
                ->where('txstatus','1')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt; */
            $phonePeLA = PhonePeEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['3', '4', '5', '10', '12', '22','32'])
                ->whereNotNull('referenceid')
                ->where('txstatus','PAYMENT_SUCCESS')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt;
            /* $airpayLA = AirpayEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['3', '4', '5', '10', '12', '22','32'])
                ->whereNotNull('transactionid')
                ->where('statuscode','200')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt; */
            /* $cashfreeLA = CashfreeEntry::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->whereIn('entryfor', ['3', '4', '5', '10', '12', '22','32'])
                ->whereNotNull('referenceid')
                ->where('txstatus','SUCCESS')
                ->selectRaw('SUM(orderamount) as totalAmt')
                ->first()->totalAmt; */
            
            return [
                'zaakPaySA'=>$zaakPaySA,'paygicSA'=>$paygicPGSA,'lyraSA'=>$lyraPGSA,'sabpaisaSA'=>$sabpaisaPGSA,'phonePeSA'=>$phonePeSA,'razorPaySA'=>$razorPaySA,
                'zaakPayLA'=>$zaakPayLA,'paygicLA'=>$paygicLA,'sabpaisaLA'=>$sabpaisaPGLA,'phonePeLA'=>$phonePeLA,'razorPayLA'=>$razorPayLA
            ];
        }
    }

    if(!function_exists('offerPageStatistics')){
        function offerPageStatistics($offerId){
            $offerUserCount = Cardoffer::where('rec_date', 'like', Carbon::now()->toDateString().'%')
                ->where('offerpage',$offerId)->whereNotNull('card_number')->whereNotNull('paymentid')->where(['isActive'=>1,'isDelete'=>0])->count();
            return $offerUserCount;
        }
    }

    if(!function_exists('assignAgent')){
        function assignAgent(){
            $lastAgentId = DB::table('site_options')->where('option_key','last_agent_id')->first()->option_value;
            $agentIds = Administrations::where('role', 2)->where(['isActive' => 1, 'isDelete' => 0])->pluck('id')->toArray();
            
            $nextAgentId = 0;
            
            if (!empty($agentIds)) {
                if ($lastAgentId > 0 && in_array($lastAgentId, $agentIds)) {
                    $lastIndex = array_search($lastAgentId, $agentIds);
                    $nextIndex = ($lastIndex + 1) % count($agentIds);
                    $nextAgentId = $agentIds[$nextIndex];
                } else {
                    // First time assignment or invalid lastAgentId
                    $nextAgentId = $agentIds[0]; // Start with the first agent
                }
                
                $staff = Administrations::where('id', $nextAgentId)
                    ->limit(1)
                    ->first();
                
                if ($staff) {
                    DB::table('site_options')
                        ->where('option_key', 'last_agent_id')
                        ->update(['option_value' => $nextAgentId]);
                    return $staff;
                }
            }
            
            // If no agent found or $staff is null, return 0
            return 0;
        }
    }
    
    if (!function_exists('assignAgentSelf')) {
    function assignAgentSelf() {
        $lastAgentIdRow = DB::table('site_options')->where('option_key', 'last_self_agent_id')->first();
        $lastAgentId = $lastAgentIdRow ? $lastAgentIdRow->option_value : 0;

        $agentIds = Administrations::where('role', 5)->where(['isActive' => 1, 'isDelete' => 0])->pluck('id')->toArray();

        $nextAgentId = 0;

        if (!empty($agentIds)) {
            if ($lastAgentId > 0 && in_array($lastAgentId, $agentIds)) {
                $lastIndex = array_search($lastAgentId, $agentIds);
                $nextIndex = ($lastIndex + 1) % count($agentIds);
                $nextAgentId = $agentIds[$nextIndex];
            } else {
                $nextAgentId = $agentIds[0]; // Start with the first agent
            }

            $staff = Administrations::where('id', $nextAgentId)
                ->limit(1)
                ->first();

            if ($staff) {
                DB::table('site_options')
                    ->where('option_key', 'last_self_agent_id')
                    ->update(['option_value' => $nextAgentId]);
                return $staff;
            }
        }

        // If no agent found or $staff is null, return 0
        return 0;
    }
}

    if(!function_exists('sendBrevoHtmlMail2')){
        function sendBrevoHtmlMail2($maildata, $subject = '', $message = '', $sendmail = '', $attachments = []){
            $data['sender']['name'] = env('APP_NAME');
            $data["sender"]["email"] = 'info@easyailoans.com';
    
            $user_res["name"] = $maildata["fullname"];
            $user_res["email"] = $maildata["email"];
            $userdata[] = $user_res;
            $data["to"] = $userdata;
    
            $data["subject"] = $subject;
            $data["htmlContent"] = $message;
    
            /*$base64File = base64_encode($attachmentPath);

        $data["attachment"] = [
            [
                "content" => $base64File,
                "name" => 'Invoice.pdf'
            ]
        ];*/

        // Attachments (already base64 encoded)
        if (!empty($attachments)) {
            $data['attachment'] = $attachments;
        }
    
            // Turn Data to JSON
            $data_json = json_encode($data);
    
            $curl = curl_init();
            curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.brevo.com/v3/smtp/email",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data_json,
                    CURLOPT_HTTPHEADER => [
                        "Accept: application/json",
                        "Content-Type: application/json",
                        "api-key: ".env('BREVO_API_KEY')
                    ],
                )
            );
            $response = curl_exec($curl);
            $err = curl_error($curl);
    
            curl_close($curl);
    
            return true;
        }
    }

    if(!function_exists('sendBrevoHtmlMail')){
        function sendBrevoHtmlMail($maildata, $subject = '', $message = '', $sendmail = '', $attachmentPath = ''){
            $data['sender']['name'] = env('APP_NAME');
            $data["sender"]["email"] = 'info@easyailoans.com';
    
            $user_res["name"] = $maildata["fullname"];
            $user_res["email"] = $maildata["email"];
            $userdata[] = $user_res;
            $data["to"] = $userdata;
    
            $data["subject"] = $subject;
            $data["htmlContent"] = $message;
            if ($attachmentPath && file_exists($attachmentPath)) {
                $fileData = file_get_contents($attachmentPath);
                $fileName = basename($attachmentPath);
                $base64File = base64_encode($fileData);
    
                $data["attachment"] = [
                    [
                        "content" => $base64File,
                        "name" => $fileName
                    ]
                ];
            }
    
            // Turn Data to JSON
            $data_json = json_encode($data);
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.brevo.com/v3/smtp/email",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data_json,
                    CURLOPT_HTTPHEADER => [
                        "Accept: application/json",
                        "Content-Type: application/json",
                        "api-key: ".env('BREVO_API_KEY')
                    ],
                )
            );
            $response = curl_exec($curl);
            
            $err = curl_error($curl);
    
            curl_close($curl);
    
            return true;
        }
    }

    if(!function_exists('sendChangePasswordEmail')){
        function sendChangePasswordEmail($fullname, $email, $mobile, $password){
            if($email!=''){
                $subject = "Your Password Has Been Changed Successfully";
                $content = view('mail.changePassword',compact('fullname','mobile','password'))->render();
                if($content != '') {
                    $maildata = array(
                        'fullname' => $fullname,
                        'email' => $email,
                        'mobile' => $mobile
                    );
                    $mailresponse = sendBrevoHtmlMail($maildata, $subject, $content, 5);
                }
            }
            return TRUE;
        }
    }
?>
