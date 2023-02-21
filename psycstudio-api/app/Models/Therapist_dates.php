<?php
#  ***Model Therapist Agenda (therapist appointments)***

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Therapist_dates extends Model
{
    use HasFactory, Notifiable;
    
    protected $table = 'therapist_dates';
    
    protected $fillable = [
        'schedule_status'
    ];
      
    //Relacion de muchos a uno
    public function therapist_dates() {
        return $this->belongsTo('App\Therapist', 'therapist_id');
    }
    
    //Relacion de uno a uno
    public function th_dates_user_dates() {
        return $this->hasOne('App\User_dates');
    } 
    
}
