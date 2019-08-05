<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'password_resets';
}
