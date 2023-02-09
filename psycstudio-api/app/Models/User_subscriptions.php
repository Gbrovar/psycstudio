<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_subscriptions extends Model
{
    use HasFactory;
    
    protected $table = 'user_subscriptions';
    
    //relaciuon de uno a uno, user_subscriptions -> unser
    public function user_subscriptions_user() {
        return $this->hasOne('App\User', 'user_id');
    }
    
    //relacion de muchos a uno user_subscriptions -> plan_subscriptions
    public function user_subscriptions_plans() {
        return $this->belongsTo('App\Plans', 'plan_id');
    }
}
