<?php

namespace App\RajaOngkir;

use Illuminate\Database\Eloquent\Model;

class City extends Model{
    protected $table = 'city';
    public $timestamps = true;

    public function province(){
        return $this->belongsTo('App\RajaOngkir\Province','province_id','rajaongkir_id');
    }

    public function districts(){
        return $this->hasMany('App\RajaOngkir\District','rajaongkir_id','district_id');
    }
}