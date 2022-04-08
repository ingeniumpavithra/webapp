<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oneday extends Model
{
    use HasFactory;
    protected $table = 'onedaytrip_details';
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];
    protected $fillable = [
        'car_id',
         'cus_name',
          'mobile',
          'trip_type',
           'fixed_payment',
            'distance',
            'xtra_desc',
            'xtracharge',
            'tollcharge',
            'discount',
             'total',
              
   ];
}
