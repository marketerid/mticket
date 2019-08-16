<?php

namespace App\GoSMS;

use App\SmsLogs\SmsLogsRepository;
use Illuminate\Support\Facades\Log;

class ZenzivaService
{
    // protected $sms_logs;
    // public function __construct() {
    //     $this->sms_logs = new SmsLogsRepository();
    // }

    public function send($message, $phone, $type = ''){
        $phone      = str_replace('+','',$phone);
        $username   = env('ZENZIVA_USER');
        $password   = env('ZENZIVA_PASS');
        $message    = str_replace(" ","%20", $message);


        $sms_command    = 'https://reguler.zenziva.net/apps/smsapi.php?userkey='. $username .'&passkey='. $password .'&nohp='. $phone .'&pesan=' . $message;

        $send   = null;
        try{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $sms_command);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

            $send = trim(curl_exec($ch));
            curl_close($ch);
        }catch (\Exception $e){
            Log::error("GoSMS Error : " . json_encode($e->getMessage()));

            return [
                'status'    => false,
                'code'      => $send,
                'message'   => 'SMS gagal dikirim',
                'link'      => $sms_command
            ];
        }
        try{
            $xml        = simplexml_load_string($send);
        }catch (\Exception $exception){

            return [
                'status'    => false,
                'code'      => "Error",
                'message'   => 'SMS gagal dikirim'
            ];
        }

        $response   = !empty($xml->message) ? $xml->message->text : false;
        if (strpos($response, 'Success') !== false) {
            // $this->sms_logs->create([
            //     'type'      => $type,
            //     'phone'     => $phone,
            //     'message'   => $message,
            //     'is_sent'   => true,
            //     'report'    => $response
            // ]);

            return [
                'status'    => true,
                'code'      => $response,
                'message'   => 'SMS berhasil dikirim'
            ];
        }
        // default error create error log in DB
        // $this->sms_logs->create([
        //     'type'      => $type,
        //     'phone'     => $phone,
        //     'message'   => $message,
        //     'is_sent'   => true,
        //     'report'    => $response
        // ]);
        return [
            'status'    => false,
            'code'      => $response,
            'message'   => "ERROR : Username dan Password Anda salah atau credit habis."
        ];
    }

    public function billSMS($shippingUser,$bill){
        $sms = "Hi, ".$shippingUser->name.", request impor Anda sudah di-approve oleh Admin. tolong bayar Rp ".number_format($bill->unique_amount,0)." ke BCA 286-160-8281 , a/n FAIZAL AZFAR, sebelum ".date("Y-m-d H:i", strtotime($bill->due_date_time))." dan upload bukti bayar di akun importir.org";
        $this->send($sms, $shippingUser->phone, $type = '');
    }

    public function supplierProcessSMS($shippingUser){
        $sms = "Hi ".$shippingUser->name.", dana Rupiah Anda sudah kami kirimkan ke supplier Anda. Mohon berikan bukti bayar kepada supplier Anda, dan Anda bisa mengecek status pembayaran di importir.org";
        $this->send($sms, $shippingUser->phone, $type = '');
    }
}
