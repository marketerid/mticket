<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $guarded = [];

    public function registration()
    {
        return $this->hasMany('App\\Events\\Registration', 'event_id', 'source_id');
    }
}
