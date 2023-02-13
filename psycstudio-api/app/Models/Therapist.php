<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Therapist extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'therapist';
    
    protected $table = 'therapists';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
       
    //relacion uno a muchos therapist -> user
    public function th_patients() {
        return $this->hasMany('App\User', 'therapist_id');
    }
    
    public function th_dates() {
        return $this->hasMany('App\Therapist_dates', 'therapist_id');
    }
    
    
    
}
