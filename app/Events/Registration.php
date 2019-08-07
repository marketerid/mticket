<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo('App\Events\Events');
    }

    public function payment()
    {
        return $this->hasOne('App\Payment\Payment', 'invoice_id', 'invoice');
    }
}
