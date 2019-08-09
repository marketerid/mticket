<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo('App\Events\Events', 'event_id');
    }

    public function payment()
    {
        return $this->hasOne('App\Payment\Payment', 'invoice_id', 'invoice');
    }
}
