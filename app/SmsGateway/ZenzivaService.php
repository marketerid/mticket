<?php

namespace App\SmsGateway;

class ZenzivaService{
    protected $cs;
    public function __construct() {
        $this->cs   = "083806439028";
    }

    public function send($message, $phone, $type = ''){
        $phone      = str_replace('+','',$phone);
        $username   = env('ZENZIVA_USER', false);
        $password   = env('ZENZIVA_PASS', false);
        $message    = str_replace(" ","%20", $message);


        $sms_command    = 'https://reguler.zenziva.net/apps/smsapi.php?userkey='. $username .'&passkey='. $password .'&nohp='. $phone .'&pesan=' . $message;

        $send   = null;
        try{
            $send = file_get_contents($sms_command);
        }catch (\Exception $e){
            return [
                'status'    => false,
                'code'      => $send,
                'message'   => 'SMS gagal dikirim'
            ];
        }
        try{
            $xml        = simplexml_load_string($send);
        }catch (\Exception $exception){
            return [
                'status'    => false,
                'code'      => $send,
                'message'   => "Something error."
            ];
        }

        return [
            'status'    => true,
            'code'      => $send,
            'message'   => "Sms berhasil dikirim."
        ];
    }

    public function customSms($user, $message){
        return $this->send($message, $user->phone);
    }
}