<?php

namespace App\GoSMS;

class GoSMSService{
    public function sendSMS($phone, $location, $message = "", $ph = false){
        // set to zenziva
        $zenziva    = new ZenzivaService();
        // $sema       = new SemaphoreService();

        // in case have 62 code
        $phone  = str_replace("+62", "0", $phone);
        $phone  = str_replace("-", "", $phone);
        $phone  = str_replace(" ", "", $phone);

        $gosmsgateway_username	= "faizal.edrus@gmail.com";
        $gosmsgateway_password	= "gosms8812";
        $current_hp				= $phone;
        $auth					= md5($gosmsgateway_username.$gosmsgateway_password.$current_hp);
        $lokasi					= $location;
        if($message == ""){
            $message				= "Anda telah terdaftar u/ mengikuti seminar importir.org di kota ".$lokasi.". Mohon melakukan pembayaran ke rek BCA 5930535305 a/n Margareta Chandra.Mohon untuk cek jadwal.";
        }

        $message = str_replace(" ","%20",$message);
        // if($ph){
        //     return $sema->send($message, $phone);
        // }

        return $zenziva->send($message, $phone);

        $sms_command = "http://api.gosmsgateway.net:88/api/Send.php?username=".$gosmsgateway_username."&mobile=".$current_hp."&message=".$message."&password=gosms8812";

        $send = @file_get_contents($sms_command);

        if ($send=="1701") {
            $response   = [
                "status"    => true,
                "message"   => "Status : Kirim SMS berhasil"
            ];

            return $response;
        }

        if ($send=="1702") {
            $response   = [
                "status"    => false,
                "message"   => "ERROR : Username dan Password Anda salah"
            ];

            return $response;
        }

        $response   = [
            "status"    => false,
            "message"   => "ERROR : Unknown error code=" . $send
        ];

        return $response;
    }

}