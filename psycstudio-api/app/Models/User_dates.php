<?php
#  ***Model User Agenda (user appointments)***
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_dates extends Model
{
    use HasFactory;
    
    protected $table = 'user_dates';
      
    //Relacion de muchos a uno
    public function User_dates() {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    //Relacion de uno a uno
    public function user_dates_ther_dates() {
        return $this->hasOne('App\Therapist_dates', 'date_id'); 
    } 
    
}
