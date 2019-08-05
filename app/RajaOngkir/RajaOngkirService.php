<?php

namespace App\RajaOngkir;

use App\Crowdfund\CrowdfundRepository;
use Illuminate\Http\Request;
use Auth;

class RajaOngkirService
{
    protected $endpoint, $key;
    public function __construct() {
        $this->endpoint = "https://pro.rajaongkir.com/api/";
        $this->key      = env('RAJA_ONGKIR_KEY', false);
    }

    public function getProvinces()
    {
        $url        = $this->endpoint . "province";
        $response   = json_decode(file_get_contents($url . "?key=" . $this->key));
        $result     = !empty($response->rajaongkir->results) ? $response->rajaongkir->results : [];

        return $result;
    }

    public function getCities($province = '')
    {
        $url        = $this->endpoint . "city";
        $response   = json_decode(file_get_contents($url . "?key=" . $this->key . "&province=" . $province));
        $result     = !empty($response->rajaongkir->results) ? $response->rajaongkir->results : [];

        $ids        = [];
        foreach ($result as $value){
            $ids[]  = $value->city_id;
        }

        $myCities   = City::with([])->whereIn('rajaongkir_id', $ids)->get();
        if($myCities->count() == 0 OR $myCities->count() < count($ids)){
            foreach ($result as $value){
                $myCity     = City::with([])->where('rajaongkir_id', $value->city_id)->first();
                if(!$myCity){
                    $city   = new City();
                    $city->rajaongkir_id    = $value->city_id;
                    $city->province_id      = $value->province_id;
                    $city->title            = $value->city_name;
                    $city->save();
                }
            }
        }
        return $result;
    }

    public function getDistricts($city = '')
    {
        $url        = $this->endpoint . "subdistrict";
        $response   = json_decode(file_get_contents($url . "?key=" . $this->key . "&city=" . $city));
        $result     = !empty($response->rajaongkir->results) ? $response->rajaongkir->results : [];

        $ids        = [];
        foreach ($result as $value){
            $ids[]  = $value->subdistrict_id;
        }

        $myDistricts    = District::with([])->whereIn('rajaongkir_id', $ids)->get();
        if($myDistricts->count() == 0 OR $myDistricts->count() < count($ids)){
            foreach ($result as $value){
                $myDistrict     = District::with([])->where('rajaongkir_id', $value->city_id)->first();
                if(!$myDistrict){
                    $city   = new District();
                    $city->rajaongkir_id    = $value->subdistrict_id;
                    $city->city_id          = $value->city_id;
                    $city->province_id      = $value->province_id;
                    $city->title            = $value->subdistrict_name;
                    $city->save();
                }
            }
        }
        return $result;
    }

    public function getShipments($district = 0 ,$weight = 1, $courier = 'jne:pos:tiki:esl:rpx:indah:wahana:sicepat:jnt:pahala:sap:jet:ninja:lion:idl', $originId = 151 /* Tangerang Default */)
    {
        $postData       = "origin=". $originId ."&originType=city&destination=" . $district . "&destinationType=subdistrict&weight=" . $weight . "&courier=" . $courier;
        $curl           = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->endpoint . "cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key:" . $this->key
            ),
        ));
        $response       = curl_exec($curl);
        $err            = curl_error($curl);

        curl_close($curl);
        $result     = json_decode($response);
        $result     = !empty($result->rajaongkir->results) ? $result->rajaongkir->results : [];

        return $result;
    }
}