<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Normaltaxi extends Model
{
    use HasFactory;
    protected $table = 'normaltaxi_details';
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];
    protected $fillable = [
        
        'car_id',
         'from',
         'to',
         'cus_name',
          'mobile',
          'trip_type',
           'distance',
           'w_hour',
           'w_charge',
           'xtra_desc',
            'xtracharge',
            'tollcharge',
            'discount',
            'waiting_hrs',
            'driver_batta',
             'total',
              
   ];
}
