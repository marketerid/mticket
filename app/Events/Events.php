<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $guarded = [];

    public function registration()
    {
        return $this->belongsTo('App\Events\Registration');
    }
}
