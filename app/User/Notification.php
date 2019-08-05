<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'notification';
    use SoftDeletes;

    public function user(){
        return $this->belongsTo('App\User\User');
    }
}
