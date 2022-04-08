<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caronedaytrip extends Model
{
    use HasFactory;
    protected $table = '7seater_details';
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];
    protected $fillable = [
        'car_id',
         'cus_name',
          'mobile',
          'kmrupees',
            'distance',
            'tollcharge',
            'xtra_desc',
            'xtracharge',
            'discount',
             'total',
              
   ];
}
