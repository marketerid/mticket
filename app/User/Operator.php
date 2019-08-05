<?php

namespace App\User;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Operator extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    protected $table = 'operator';

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
        return true;
    }

    public function user(){
        return $this->belongsTo('App\User\User');
    }

    public function getAvatarLinkAttribute(){
        $avatar     = 'https://ui-avatars.com/api/?size=128&rounded=true&name=' . str_replace(' ','+',$this->name);
        if($this->avatar != ''){
            $avatar = $this->avatar;
        }

        return $avatar;
    }

    public function getPhoneWhatsappAttribute(){
        $phone  = str_replace('+','', $this->phone);

        return $phone;
    }

    public function getPhoneTextAttribute(){
        $phone  = str_replace('+','', $this->phone);
        $phone  = str_replace('62','0', $phone);

        return $phone;
    }
}
