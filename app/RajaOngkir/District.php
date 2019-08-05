<?php

namespace App\RajaOngkir;

use Illuminate\Database\Eloquent\Model;

class District extends Model{
    protected $table = 'district';
    public $timestamps = true;

    public function city(){
        return $this->belongsTo('App\RajaOngkir\City','city_id','rajaongkir_id');
    }

    public function province(){
        return $this->belongsTo('App\RajaOngkir\Province','province_id','rajaongkir_id');
    }
}