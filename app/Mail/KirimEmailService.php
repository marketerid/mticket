<?php

namespace App\Mail;


use GuzzleHttp\Client;
use Mockery\Exception;

class KirimEmailService{
    protected $userName,$token, $client, $headers;
    public function __construct() {
        $this->userName = env('KIRIMEMAIL_USERNAME', '');
        $this->token    = env('KIRIMEMAIL_TOKEN', '');

        // this is basic header, unless you fill this, it will always return Bad Request
        $time = time();
        $this->headers  = [
            "Auth-Id" => $this->userName,
            "Auth-Token" => hash_hmac("sha256",
                $this->userName ."::". $this->token ."::".$time,
                $this->token),
            "Timestamp" => $time
        ];
        $this->client   = new Client(["base_uri"=> "https://aplikasi.kirim.email/api/v3/", 'headers' => $this->headers]);
    }

    public function sendSubscriber($email, $phone, $name){

        try{
            $this->client->request('POST', 'subscriber',[
                    'exceptions' => false,
                    'headers'       => $this->headers,
                    'form_params'=> [
                        'full_name' =>$name,
                        'fields[no_hp]' => $phone,
                        'email' => $email,
                        'lists' => [25328],
                    ]
                ]
            );
            return true;
        }catch (Exception $exception){
            return false;
        }
    }
}