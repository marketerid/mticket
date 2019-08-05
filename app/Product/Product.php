<?php

namespace App\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    protected $table = 'product';
    public $timestamps = true;

    public function user_order_details(){
        return $this->hasMany('App\UserOrder\UserOrderDetail')->orderBy('id','desc')->limit(25);
    }

    public function site(){
        return $this->belongsTo('App\Site\Site');
    }
}