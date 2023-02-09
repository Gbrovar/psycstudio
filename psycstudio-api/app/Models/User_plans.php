<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_plans extends Model
{
    use HasFactory;
    
    protected $table = 'user_plans';
    
    //relaciuon de uno a muchos, users -> plans
    public function user_plan() {
        return $this->hasMany('App\User', 'user_id');
    }
    
    //relacion de uno a uno user_plan -> plan
    public function user_plan_plans() {
        return $this->hasOne('App\Plans');
    }
}
