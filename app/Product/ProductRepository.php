<?php

namespace App\Product;

use Illuminate\Support\Facades\Auth;

class ProductRepository{
    public function createUpdateProduct($id = null, $siteId = null, $userId, $inputs){
        $data   = $this->findProductById($id);
        if(!$data){
            $data   = new Product();
        }else{
            if($data->user_id != $userId){
                abort(403);
            }
        }

        $data->user_id      = $userId;
        $data->site_id      = $siteId;

        $data->title            = $inputs['title'];
        $data->description      = $inputs['description'];
        $data->price_original   = numFormat($inputs['price_original']);
        $data->price_discount   = numFormat($inputs['price_discount']);
        $data->save();

        return $data;
    }

    public function findProductById($id = null){
        return Product::with(['user_order_details.order','site'])->find($id);
    }

    public function getProductBySiteId($siteId = null){
        return Product::with(['user_order_details.order','site'])->where('site_id', $siteId)->get();
    }

    public function getProducts($filters = []){
        $data   = Product::with(['user_order_details.order']);
        if(!empty($filters['user_id'])){
            $data->where('user_id', $filters['user_id']);
        }
        return $data->paginate(25);
    }
}