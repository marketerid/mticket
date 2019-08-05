<?php

namespace App\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function getIsOperatorAttribute()
    {
        return false;
    }

    public function orders(){
        return $this->hasMany('App\Order\Order', 'user_id')->orderBy('id','desc');
    }

    public function active_order(){
        return $this->belongsTo('App\Order\Order','active_order_id', 'id');
    }

    public function operators(){
        return $this->hasMany('App\User\Operator')->orderBy('id','desc');
    }
}
