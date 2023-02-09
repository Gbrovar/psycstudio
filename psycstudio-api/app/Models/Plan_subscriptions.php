<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan_subscriptions extends Model
{
    use HasFactory;
    
    protected $table = 'plan_subscriptions';
    
    //relacion de uno a muchos plans -> user_plan
    public function plans_user_plan() {
        return $this->hasMany('App\user_subscriptions', 'plan_id');
    }
    
    //relacion de uno a uno user_plan -> plan
    public function user_plan_plans() {
        return $this->hasOne('App\Plan_subscriptions');
    }
}
