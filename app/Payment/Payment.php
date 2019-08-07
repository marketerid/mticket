<?php

namespace App\Payment;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    public function registration()
    {
        return $this->belongsTo('App\Events\Registration', 'invoice', 'invoice_id');
    }
}
