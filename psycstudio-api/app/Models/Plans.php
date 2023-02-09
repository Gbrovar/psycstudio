<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{
    use HasFactory;
    
    protected $table = 'plans';
    
    //relacion de uno a muchos plans -> user_plan
    public function plans_user_plan() {
        return $this->hasMany('App\User_plan', 'plan_id');
    }
}
