<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driverlogins extends Model
{
    use HasFactory;
    protected $table = 'drivers_logins';
    protected $fillable = [
        'car_id',
         'login_date',
          'login_time',
          'login_kilometer',
          'logout_date',
          'logout_time',
          'logout_kilometer',
              
   ];
}
