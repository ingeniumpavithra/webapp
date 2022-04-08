<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Login extends Model
{
    use HasFactory,Notifiable;
    
    protected $table = 'login';
    protected $fillable = [
        
        'car_no',
         'password',
         'driver',
              
   ];

   protected $hidden = [
    'password',
    'remember_token',
];
}
