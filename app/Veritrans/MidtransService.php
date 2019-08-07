<?php

namespace App\Veritrans;

use App\Veritrans\Midtrans;
use App\Veritrans\Veritrans;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected $midtransProd, $serverKey;
    public function __construct()
    {
        $this->midtransProd     = env('MIDTRANS_PROD', false);
        $this->serverKey        = env('MIDTRANS_SERVER_KEY');
    }

    public function notification() {

        Veritrans::$isProduction    = $this->midtransProd;
        Veritrans::$serverKey       = $this->serverKey;

        $midtrans = new Veritrans;
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result);
        if($result){
            $notif = $midtrans->status($result->order_id);
        }

        $transaction    = $notif->transaction_status;
        $type           = $notif->payment_type;
        $order_id       = $notif->order_id;
        $fraud          = $notif->fraud_status;
        $status         = 'failed'; // default

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    // echo "Transaction order_id: " . $order_id ." is challenged by FDS";
                    $status = 'success';
                    return [
                        'status'    => true,
                        'order_id'  => $order_id,
                        'type'      => $type,
                        'message'   => '',
                        'status_server' => $status,
                        'dump'      => \GuzzleHttp\json_encode($notif)
                    ];
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    // echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
                    $status = 'success';
                    return [
                        'status'    => true,
                        'order_id'  => $order_id,
                        'type'      => $type,
                        'message'   => '',
                        'status_server' => $status,
                        'dump'      => \GuzzleHttp\json_encode($notif)
                    ];
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            //echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
            $status = 'success';
            return [
                'status'    => true,
                'order_id'  => $order_id,
                'type'      => $type,
                'message'   => '',
                'status_server' => $status,
                'dump'      => \GuzzleHttp\json_encode($notif)
            ];
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            // echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
            $status = 'pending';
            return [
                'status'    => false,
                'order_id'  => $order_id,
                'type'      => $type,
                'message'   => '',
                'status_server' => $status,
                'dump'      => \GuzzleHttp\json_encode($notif)
            ];
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            //echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
            $status = 'deny';
            return [
                'status'    => false,
                'order_id'  => $order_id,
                'type'      => $type,
                'message'   => '',
                'status_server' => $status,
                'dump'      => \GuzzleHttp\json_encode($notif)
            ];
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            // echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
            $status = 'expire';
            return [
                'status'    => false,
                'order_id'  => $order_id,
                'type'      => $type,
                'message'   => '',
                'status_server' => $status,
                'dump'      => \GuzzleHttp\json_encode($notif)
            ];
        } else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            // echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
            $status = 'cancel';
            return [
                'status'    => false,
                'order_id'  => $order_id,
                'type'      => $type,
                'message'   => '',
                'status_server' => $status,
                'dump'      => \GuzzleHttp\json_encode($notif)
            ];
        }

        return [
            'status'    => false,
            'order_id'  => $order_id,
            'type'      => $type,
            'message'   => 'Not Found',
            'status_server' => $status,
            'dump'      => \GuzzleHttp\json_encode($notif)
        ];
    }

    public function getSnapTokens($invoice = '', $amount = 0)
    {
        Midtrans::$isProduction = $this->midtransProd;
        Midtrans::$serverKey = $this->serverKey;
        // Midtrans::$isSanitized = true;
        // Midtrans::$is3ds = true;

        $midtrans = new Midtrans;
        $complete_request = [
            "transaction_details" => [
                "order_id"      => $invoice,
                "gross_amount"  => (int)$amount
            ],
            "item_details"  => [
                [
                    "id"    => $invoice,
                    "price" => (int)$amount,
                    "quantity"  => 1,
                    "name"      => "Pembayaran Seminar",
                    "category"  => "Event",
                    "merchant_name" => "Mticket.asia"
                ]
            ]
        ];
        $snap_token = $midtrans->getSnapToken($complete_request);

        return $snap_token;
    }
}