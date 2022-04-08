<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localtrip extends Model
{
    use HasFactory;
    protected $table = 'localtrip_details';
    protected $casts = [
      'created_at' => 'datetime:d-m-Y',
  ];
    protected $fillable = [
        
        'car_id',
         'triphr',
         'distance',
         'cus_name',
         'trip_type',
          'mobile',
           'payment',
           'xtrakm',
           'xtra_desc',
            'xtracharge',
            'tollcharge',
            'discount',
           'xtrakmcharge',
             'total',
              
   ];
}
