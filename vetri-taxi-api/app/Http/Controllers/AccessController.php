<?php

namespace App\Http\Controllers;

use App\Models\Hillstrip;
use App\Models\Localtrip;
use App\Models\Login;
use App\Models\Normaltaxi;
use App\Models\Oneday;

use Carbon\Carbon;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;

use App\Models\Driverlogins;

class AccessController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function get_cars(){
    
        $result = Login::all();
        
        return response()->json([
            'status' => 200,
            'data' => $result,
        ]);
    }
    public function admin_report(){

        $one_day = DB::select("SELECT (SELECT sum(`total`) FROM `onedaytrip_details` WHERE `created_at` BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()) as `days`, SUM(`total`) as `total` FROM `onedaytrip_details`;");
         $taxi = DB::select("SELECT (SELECT sum(`total`) FROM `normaltaxi_details` WHERE `created_at` BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()) as `days`, SUM(`total`) as `total` FROM `normaltaxi_details`;");
         $local = DB::select("SELECT (SELECT sum(`total`) FROM `localtrip_details` WHERE `created_at` BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()) as `days`, SUM(`total`) as `total` FROM `localtrip_details`;");
         $hills = DB::select("SELECT (SELECT sum(`total`) FROM `hillstrip_details` WHERE `created_at` BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()) as `days`, SUM(`total`) as `total` FROM `hillstrip_details`;");
        return response()->json([
            'status' => 200,
            'one_day' => $one_day,
             'taxi' => $taxi,
             'local' => $local,
             'hills' => $hills,
          
        ]);
      }
      public function get_trips($id){
    
        $trips=DB::select("SELECT * FROM ((SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`car_id`,`cus_name`,`mobile`,`trip_type`,`trip_from`,`trip_to`,Null as `distance`,`total`,Null as `w_charge`,Null as `driver_batta`,`created_at` FROM `hillstrip_details`)
        UNION ALL (SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`car_id`,`cus_name`,`mobile`,`trip_type`,Null as `trip_from`,Null as `trip_to`,`distance`,`total`,Null as `w_charge`,Null as `driver_batta`,`created_at` FROM `localtrip_details`)
            UNION ALL (SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`car_id`,`cus_name`,`mobile`,`trip_type`,`from`,`to`,`distance`,`total`,`w_charge`,`driver_batta`,`created_at` FROM `normaltaxi_details`)
            UNION ALL (SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`car_id`,`cus_name`,`mobile`,`trip_type`,Null as `trip_from`,Null as `trip_to`,`distance`,`total`,Null as `w_charge`,Null as `driver_batta`,`created_at` FROM `onedaytrip_details`))
         AS result WHERE `result`.`car_id`=$id ORDER BY `result`.`created_at` DESC;");
    
      
      return response()->json([
          'status' => 200,
          'all' => $trips,
      ]);
    }
    public function car_search(Request $request,$id){
    
      $query = "SELECT * FROM ((SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`car_id`,`cus_name` as customer,`mobile`,`trip_type`,`trip_from`,`trip_to`,Null as `distance`,`total`,Null as `w_charge`,Null as `driver_batta`,`created_at` FROM `hillstrip_details`)
      UNION ALL (SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`car_id`,`cus_name` as Customer,`mobile`,`trip_type`,Null as `trip_from`,Null as `trip_to`,`distance`,`total`,Null as `w_charge`,Null as `driver_batta`,`created_at` FROM `localtrip_details`)
          UNION ALL (SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`car_id`,`cus_name` as Customer,`mobile`,`trip_type`,`from`,`to`,`distance`,`total`,`w_charge`,`driver_batta`,`created_at` FROM `normaltaxi_details`)
          UNION ALL (SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`car_id`,`cus_name` as Customer,`mobile`,`trip_type`,Null as `trip_from`,Null as `trip_to`,`distance`,`total`,Null as `w_charge`,Null as `driver_batta`,`created_at` FROM `onedaytrip_details`))
       AS result where 1  ";
       
    
              if ($request->start_date) { 
                  $query .= " AND DATE_FORMAT(result.created_at, '%Y-%m-%d') >= '".$request->start_date."'";
              }
    
              
              if ($request->end_date) {
                  $query .= " AND DATE_FORMAT(result.created_at, '%Y-%m-%d') <= '".$request->end_date."'";
              }
    
              if ($id) { 
                  $query .= " AND `result`.`car_id` = '".$id."' ";
              }
    
              $query .= " ORDER BY `result`.`created_at` DESC";
    
              $result = DB::select($query);
    
              return response()->json([
              'status' => 200,
              'data' => $result,
              ]);
    }
    public function reports($id){
        
        $loginDetail = Driverlogins::where('car_id', $id)
        ->orderBy('login_date','desc')
        ->orderBy('login_time','desc')
        ->first();
       
        $result = [$loginDetail]; 
        
        if (!empty($loginDetail) && empty($loginDetail['logout_date'])) {
            $result=DB::select("SELECT * FROM ((SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date, `car_id`,`cus_name`,`mobile`,`trip_type`,`trip_from`,`trip_to`,Null as `distance`,`total`,Null as `w_charge`,Null as `driver_batta`,`created_at` FROM `hillstrip_details`)
            UNION ALL (SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,`car_id`,`cus_name`,`mobile`,`trip_type`,Null as `trip_from`,Null as `trip_to`,`distance`,`total`,Null as `w_charge`,Null as `driver_batta`,`created_at` FROM `localtrip_details`)
                UNION ALL (SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,`car_id`,`cus_name`,`mobile`,`trip_type`,`from`,`to`,`distance`,`total`,`w_charge`,`driver_batta`,`created_at` FROM `normaltaxi_details`)
                UNION ALL (SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,`car_id`,`cus_name`,`mobile`,`trip_type`,Null as `trip_from`,Null as `trip_to`,`distance`,`total`,Null as `w_charge`,Null as `driver_batta`,`created_at` FROM `onedaytrip_details`))
             AS result WHERE DATE_FORMAT(`result`.`created_at`,'%Y-%m-%d') >= '$loginDetail[login_date]' ORDER BY `result`.`created_at`DESC;");
        }
        return response()->json([
            'status' => 200,
            'data' => $result,
            ]);
    }  
    public function get_customers(){
    
      $trips=DB::select("SELECT * FROM ((SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`cus_name` as customer,`mobile`,`trip_type`,`trip_from`,`trip_to`,Null as `distance`,`total`,Null as `w_charge`,Null as `driver_batta`,`created_at` FROM `hillstrip_details`)
      UNION ALL (SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`cus_name` as Customer,`mobile`,`trip_type`,Null as `trip_from`,Null as `trip_to`,`distance`,`total`,Null as `w_charge`,Null as `driver_batta`,`created_at` FROM `localtrip_details`)
          UNION ALL (SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`cus_name` as Customer,`mobile`,`trip_type`,`from`,`to`,`distance`,`total`,`w_charge`,`driver_batta`,`created_at` FROM `normaltaxi_details`)
          UNION ALL (SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`cus_name` as Customer,`mobile`,`trip_type`,Null as `trip_from`,Null as `trip_to`,`distance`,`total`,Null as `w_charge`,Null as `driver_batta`,`created_at` FROM `onedaytrip_details`))
       AS result ORDER BY `result`.`created_at` DESC;");
    
    
    return response()->json([
        'status' => 200,
        'all' => $trips,
    ]);
    }
    public function search(Request $request){
    
    $query = "SELECT * FROM ((SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`cus_name` as customer,`mobile`,`trip_type`,`trip_from`,`trip_to`,Null as `distance`,`total`,Null as `w_charge`,Null as `driver_batta`,`created_at` FROM `hillstrip_details`)
    UNION ALL (SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`cus_name` as Customer,`mobile`,`trip_type`,Null as `trip_from`,Null as `trip_to`,`distance`,`total`,Null as `w_charge`,Null as `driver_batta`,`created_at` FROM `localtrip_details`)
      UNION ALL (SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`cus_name` as Customer,`mobile`,`trip_type`,`from`,`to`,`distance`,`total`,`w_charge`,`driver_batta`,`created_at` FROM `normaltaxi_details`)
      UNION ALL (SELECT DATE_FORMAT(`created_at`, '%d-%m-%Y') as date,TIME_FORMAT(`created_at`, '%h:%i %p') as time,`cus_name` as Customer,`mobile`,`trip_type`,Null as `trip_from`,Null as `trip_to`,`distance`,`total`,Null as `w_charge`,Null as `driver_batta`,`created_at` FROM `onedaytrip_details`))
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