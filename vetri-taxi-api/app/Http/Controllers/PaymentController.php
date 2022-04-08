<?php

namespace App\Http\Controllers;

use App\Mail\QuoteMail;
use App\Models\Hillstrip;
use App\Models\Localtrip;
use Illuminate\Support\Facades\DB;
use App\Models\Normaltaxi;
use App\Models\Oneday;
use App\Models\Driverlogins;
use App\Models\Caronedaytrip;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Sendsms;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public $sendSms;
    

    public function add_day_trip(Request $request){

        // $url = 'http://pay4sms.in';
        // $token = '3ced1c7a756b049bfa9e228de5c13695';
        // $credit = '2';
        // $sender = 'VETRlT';
        // $message = 'Dear'.$request->input('cus_name').' Your Safe Journey With Car:'.$request->input('car_no').' Your Amount for this Day Rent is '.$request->input('total').' initial Pay:1800 Total:'.$request->input('distance').'Kms,Rs='.$request->input('distance_charge').' Extra Amount:'.$request->input('xtra_desc').',Rs='.$request->input('xtracharge').' Tolls/Parking:'.$request->input('tollcharge').' Discount:'.$request->input('discount').' CT:8015551777 THANK YOU Have a nice day !​VETRI CALL TAXI';
        // $number = $request->input('mobile');  
        // $this->sendSms = new Sendsms($url,$token);
        // try {
        //     $message_id = $this->sendSms->sendmessage($credit,$sender,$message,$number);
        //     $dlr_status = $this->sendSms->checkdlr($message_id);
        //     $available_credit = $this->sendSms->availablecredit($credit);
        // }
        //     catch (\Exception $e) {
        //     echo $e->getMessage();
        // } 



        $details = [
            'name' => $request->input('cus_name'),
            'mobile' => $request->input('mobile'),
            'type' => 'Day Trip',
            'amount' => $request->input('total')
        ];

        /*Mail::to("kanism33@gmail.com")->send(new QuoteMail($details));*/
        
        $daytrip = new Oneday();
        $daytrip->cus_name = $request->input('cus_name');
        $daytrip->car_id = $request->input('car_id');
        $daytrip->mobile = $request->input('mobile');
        $daytrip->trip_type = "Day trip";
        $daytrip->distance = $request->input('distance');

        $daytrip->xtra_desc = $request->input('xtra_desc');
        $daytrip->xtracharge = $request->input('xtracharge');
        $daytrip->tollcharge = $request->input('tollcharge');
        $daytrip->discount = $request->input('discount');

        $daytrip->total = $request->input('total');
        
        $daytrip->save();

        return response()->json([
            'status' => 200,
            'message' => 'One day trip details sended',
        ]);
    }

    public function add_local_trip(Request $request){

        $url = 'http://pay4sms.in';
        $token = '3ced1c7a756b049bfa9e228de5c13695';
        $credit = '2';
        $sender = 'VETRlT';
        $message = 'Dear'.$request->input('cus_name').' Your Safe Journey With Car:'.$request->input('car_no').' Your Amount for this Hours Trip is '.$request->input('total').' Total:'.$request->input('triphr').'Hrs,Rs='.$request->input('payment').' Extra :'.$request->input('xtrakm').'Kms,Rs='.$request->input('xtrakmcharge').' Extra Amount:'.$request->input('xtra_desc').',Rs='.$request->input('xtracharge').' Tolls/Parking:'.$request->input('tollcharge').' Discount:'.$request->input('discount').' THANK YOU Have a nice day ! VETRI CALL TAXI';
        $number = $request->input('mobile');  
        $this->sendSms = new Sendsms($url,$token);
        try {
            $message_id = $this->sendSms->sendmessage($credit,$sender,$message,$number);
            $dlr_status = $this->sendSms->checkdlr($message_id);
            $available_credit = $this->sendSms->availablecredit($credit);
        }
            catch (\Exception $e) {
            echo $e->getMessage();
        } 

        $details = [
            'name' => $request->input('cus_name'),
            'mobile' => $request->input('mobile'),
            'type' => 'Local Trip',
            'amount' => $request->input('total')
        ];

       /* Mail::to("kanism33@gmail.com")->send(new QuoteMail($details));*/
        
        $daytrip = new Localtrip();
        $daytrip->cus_name = $request->input('cus_name');
        $daytrip->car_id = $request->input('car_id');
        $daytrip->mobile = $request->input('mobile');
        $daytrip->trip_type = "Local trip";
        $daytrip->triphr = $request->input('triphr');
        $daytrip->distance = $request->input('tripkms');
        $daytrip->payment = $request->input('payment');

        $daytrip->xtra_desc = $request->input('xtra_desc');
        $daytrip->xtracharge = $request->input('xtracharge');
        $daytrip->tollcharge = $request->input('tollcharge');
        $daytrip->discount = $request->input('discount');

        $daytrip->xtrakm = $request->input('xtrakm');
        $daytrip->xtrakmcharge = $request->input('xtrakmcharge');
        $daytrip->total = $request->input('total');
        
        $daytrip->save();

        return response()->json([
            'status' => 200,
            'message' => 'Local trip details sended',
        ]);
    }

    public function add_hills_trip(Request $request){

        $url = 'http://pay4sms.in';
        $token = '3ced1c7a756b049bfa9e228de5c13695';
        $credit = '2';
        $sender = 'VETRlT';
        $message = 'Dear'.$request->input('cus_name').' Your Safe Journey With Car:'.$request->input('car_no').' Your Amount for this Hills trip is '.$request->input('total').' Trip pay :'.$request->input('trip_to').',Rs='.$request->input('payment').' Driver beta :'.$request->input('driver_batta').' Days :'. $request->input('trip_days').' Extra Amount:'.$request->input('xtra_desc').',Rs='.$request->input('xtracharge').' Tolls/Parking:'.$request->input('tollcharge').' Discount:'.$request->input('discount').' THANK YOU Have a nice day! VETRI CALL TAXI';
        $number = $request->input('mobile');  
        $this->sendSms = new Sendsms($url,$token);
        try {
            $message_id = $this->sendSms->sendmessage($credit,$sender,$message,$number);
            $dlr_status = $this->sendSms->checkdlr($message_id);
            $available_credit = $this->sendSms->availablecredit($credit);
        }
            catch (\Exception $e) {
            echo $e->getMessage();
        } 

        $details = [
            'name' => $request->input('cus_name'),
            'mobile' => $request->input('mobile'),
            'type' => 'Hills Trip',
            'amount' => $request->input('total')
        ];

       /* Mail::to("kanism33@gmail.com")->send(new QuoteMail($details));*/
        
        $daytrip = new Hillstrip();
        $daytrip->cus_name = $request->input('cus_name');
        $daytrip->car_id = $request->input('car_id');
        $daytrip->mobile = $request->input('mobile');
        $daytrip->trip_type = "Hills trip";
        $daytrip->trip_from = $request->input('trip_from');
        $daytrip->trip_to = $request->input('trip_to');
        $daytrip->members = $request->input('members');
        $daytrip->xtra_desc = $request->input('xtra_desc');
        $daytrip->xtracharge = $request->input('xtracharge');
        $daytrip->tollcharge = $request->input('tollcharge');
        $daytrip->discount = $request->input('discount');

        $daytrip->payment = $request->input('payment');
        $daytrip->trip_days = $request->input('trip_days');
        $daytrip->driver_batta = $request->input('driver_batta');
        $daytrip->total = $request->input('total');
        
        $daytrip->save();

        return response()->json([
            'status' => 200,
            'message' => 'Hills trip details sended',
        ]);

    }

    public function add_taxi_trip(Request $request){

        $url = 'http://pay4sms.in';
        $token = '3ced1c7a756b049bfa9e228de5c13695';
        $credit = '2';
        $sender = 'VETRlT';
        $message = 'Dear '.$request->input('cus_name').' Your Amount for this Normal Taxi is '.$request->input('total').' Total:'.$request->input('distance').'Kms,Rs='.$request->input('distance_charge').' Waiting Charge:'.$request->input('w_hour').'Hr,Rs='.$request->input('w_charge').' Driver beta :'.$request->input('driver_batta').' Extra Amount:'.$request->input('xtra_desc').',Rs='.$request->input('xtracharge').' Tolls/Parking:'.$request->input('tollcharge').' Discount:'.$request->input('discount').' THANK YOU Have a nice day! VETRI CALL TAXI';
        $number = $request->input('mobile'); 
        $this->sendSms = new Sendsms($url,$token);
        try {
            $message_id = $this->sendSms->sendmessage($credit,$sender,$message,$number);
            $dlr_status = $this->sendSms->checkdlr($message_id);
            $available_credit = $this->sendSms->availablecredit($credit);
        }
            catch (\Exception $e) {
            echo $e->getMessage();
        } 

        $details = [
            'name' => $request->input('cus_name'),
            'mobile' => $request->input('mobile'),
            'type' => 'Taxi Trip',
            'amount' => $request->input('total')
        ];

       /* Mail::to("kanism33@gmail.com")->send(new QuoteMail($details));*/
        
        $taxitrip = new Normaltaxi();
        $taxitrip->from = $request->input('from');
        $taxitrip->to = $request->input('to');
        $taxitrip->car_id = $request->input('car_id');
        $taxitrip->cus_name = $request->input('cus_name');
        $taxitrip->mobile = $request->input('mobile');
        $taxitrip->trip_type = "Normal trip";
        $taxitrip->distance = $request->input('distance');

        $taxitrip->xtra_desc = $request->input('xtra_desc');
        $taxitrip->xtracharge = $request->input('xtracharge');
        $taxitrip->tollcharge = $request->input('tollcharge');
        $taxitrip->discount = $request->input('discount');

        $taxitrip->w_hour = $request->input('w_hour');
        $taxitrip->w_charge = $request->input('w_charge');
        $taxitrip->driver_batta = $request->input('driver_batta');
        $taxitrip->total = $request->input('total');
        
        $taxitrip->save();

        return response()->json([
            'status' => 200,
            'message' => 'Taxi trip details sended',
        ]);
    }

    public function drivers_logins(Request $request){
       
        $drivers_logins = new Driverlogins();
        $drivers_logins->car_id = $request->input('car_id');
        $drivers_logins->login_date=$request->input('date');
        $drivers_logins->login_time = $request->input('time');
        $drivers_logins->login_kilometer = $request->input('kilometer');
       
        $drivers_logins->save();

        return response()->json([
            'status' => 200,
            'message' => 'login success',
        ]);
    }
    public function hanshake(Request $request,$car_id){
       
        $results = Driverlogins::where('car_id', $car_id)
            ->orderBy('login_date','desc')
            ->orderBy('login_time','desc')
            ->first();

        return response()->json([
            'status' => 200,
            'data' => $results,
            'message' => 'success',
        ]);
    }    

    public function logout(Request $request ,$car_id){
       
        $drivers_logins = Driverlogins::where('car_id', $car_id)
        ->orderBy('id','desc')
        ->first();
        $drivers_logins->logout_date = $request->input('date');
        $drivers_logins->logout_time = $request->input('time');
        $drivers_logins->logout_kilometer = $request->input('kilometer');
        $drivers_logins->update();
        
       
        return response()->json([
            'status' => 200,
            'message' => 'logout success',
        ]);
    }
    
    public function Caronedaytrip(Request $request){

        // $url = 'http://pay4sms.in';
        // $token = '3ced1c7a756b049bfa9e228de5c13695';
        // $credit = '2';
        // $sender = 'VETRlT';
        // $message = 'Dear'.$request->input('cus_name').' Your Safe Journey With Car:'.$request->input('car_no').' Your Amount for this Day Rent is '.$request->input('total').' initial Pay:1800 Total:'.$request->input('distance').'Kms,Rs='.$request->input('distance_charge').' Extra Amount:'.$request->input('xtra_desc').',Rs='.$request->input('xtracharge').' Tolls/Parking:'.$request->input('tollcharge').' Discount:'.$request->input('discount').' CT:8015551777 THANK YOU Have a nice day !​VETRI CALL TAXI';
        // $number = $request->input('mobile');  
        // $this->sendSms = new Sendsms($url,$token);
        // try {
        //     $message_id = $this->sendSms->sendmessage($credit,$sender,$message,$number);
        //     $dlr_status = $this->sendSms->checkdlr($message_id);
        //     $available_credit = $this->sendSms->availablecredit($credit);
        // }
        //     catch (\Exception $e) {
        //     echo $e->getMessage();
        // } 



        $details = [
            'name' => $request->input('cus_name'),
            'mobile' => $request->input('mobile'),
            'type' => 'Day Trip',
            'amount' => $request->input('total')
        ];

        /*Mail::to("kanism33@gmail.com")->send(new QuoteMail($details));*/
        
        $seater = new Caronedaytrip();
        $seater->cus_name = $request->input('cus_name');
        $seater->car_id = $request->input('car_id');
        $seater->mobile = $request->input('mobile');
        $seater->kmrupees = $request->input('kmrupees');
        $seater->tollcharge = $request->input('tollcharge');
        $seater->distance = $request->input('distance');
        $seater->xtra_desc = $request->input('xtra_desc');
        $seater->xtracharge = $request->input('xtracharge');
        $seater->discount = $request->input('discount');
        $seater->total = $request->input('total');
        
        $seater->save();

        return response()->json([
            'status' => 200,
            'message' => 'One day trip details sended',
        ]);
    }
    public function get_seaters(){

        $trips=DB::select("SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`cus_name` as Customer,`mobile`,`kmrupees`,`distance`,`tollcharge`,`xtra_desc`as Extra_desc,`xtracharge`as Extra_Charge,`discount`as Discount,`total`,`created_at` FROM `7seater_details`
         AS result ORDER BY `result`.`created_at` DESC;");

      
      return response()->json([
          'status' => 200,
          'all' => $trips,
      ]);
  }

  public function get_search(Request $request){

    $query = "SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`cus_name` as Customer,`mobile`,`kmrupees`,`distance`,`tollcharge`,`xtra_desc`as Extra_desc,`xtracharge`as Extra_Charge,`discount`as Discount,`total`,`created_at` FROM `7seater_details`
     AS result where 1";

        if ($request->start_date) { 
            $query .= " AND DATE_FORMAT(result.created_at, '%Y-%m-%d') >= '".$request->start_date."'";
        }

        if ($request->end_date) {
            $query .= " AND DATE_FORMAT(result.created_at, '%Y-%m-%d') <= '".$request->end_date."'";
        }
   
        $query .= " ORDER BY `result`.`created_at` DESC";
    
        $result = DB::select($query);
  
    return response()->json([
        'status' => 200,
        'data' => $result,
    ]);
}



}