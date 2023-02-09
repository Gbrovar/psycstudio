<?php
#  ***Model Therapist Agenda (therapist appointments)***

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Therapist_dates extends Model
{
    use HasFactory;
    
    protected $table = 'therapist_dates';
      
    //Relacion de muchos a uno
    public function therapist_dates() {
        return $this->belongsTo('App\Therapist', 'therapist_id');
    }
    
    //Relacion de uno a uno
    public function th_dates_user_dates() {
        return $this->hasOne('App\User_dates');
    } 
    
}
