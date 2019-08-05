<?php

namespace App\RajaOngkir;

use Illuminate\Database\Eloquent\Model;

class Province extends Model{
    protected $table = 'province';
    public $timestamps = true;

    public function cities(){
        return $this->hasMany('App\RajaOngkir\City','rajaongkir_id','city_id');
    }

    public function districts(){
        return $this->hasMany('App\RajaOngkir\District','rajaongkir_id','district_id');
    }
}