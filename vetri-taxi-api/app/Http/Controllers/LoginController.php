<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    
    public function check_login(Request $request){

        $login_request = Login::where('car_no','=',$request->name)->where('password','=',$request->password)->get()->first();

        if ($login_request) { 
            return response()->json([
                'status' => 200,
                'message' => 'Login Success',
                'data' => $login_request,
            ]);
        }
        else{
            return response()->json([
                'status' => 'fail',
                'message' => 'Username and password incorrect',
            ]);
        }
        
    }

}
