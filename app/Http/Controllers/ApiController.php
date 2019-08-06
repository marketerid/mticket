<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\EventsRepository;
use App\Payment\PaymentRepository;
use App\Veritrans\MidtransService;

class ApiController extends Controller
{
    protected $event;
    public function __construct(EventsRepository $event) {
        $this->event    = $event;
    }

    public function checkoutMidtrans(Request $request) {
        $data                   = file_get_contents('php://input');
        $dataJson               = \GuzzleHttp\json_decode($data);
        $register               = $this->event->findInvoice($dataJson->invoice);

        $payment                = new PaymentRepository();
        $merchantMakePayment    = $payment->makePaymentMidtrans($dataJson->invoice, $dataJson->type);
        if(!$merchantMakePayment){
            return response()->json([
                'status'    => false,
                'message'   => "Payment Not Available"
            ]);
        }

        $midtrans   = new MidtransService();
        $result     = $midtrans->getSnapTokens($register->invoice, $register->total);
        return response()->json([
            'token' => $result
        ]);
    }

    public function savePaymentMidtrans($invoice, Request $request) {
        $payment = new PaymentRepository();
        $result = $payment->savePaymentMidtrans($invoice, $request->all());
        return '';
    }

    public function paymentNotificationMidtrans() {
        $midtrans   = new MidtransService();
        $response   = $midtrans->notification();

        /*Log::error("Midtrans paymentNotificationMidtrans: " . json_encode([$response]));*/
        if(is_null($response['orderId'])){
            // something error
            return response()->json([
                'status'    => false,
                'message'   => "Something error"
            ]);
        }


        $paymentRepo            = new PaymentRepository();
        $paymentData            = $paymentRepo->notifyStatusMidtrans($response['orderId'], $response['status_server']);

        if(!$paymentData){
            return response()->json([
                'status'    => false,
                'message'   => "Already paid"
            ]);
        }

        // process here
        if ($paymentData->transaction_status == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $paymentData->setPending();
                } else {
                    $paymentData->setSuccess();
                }
            }
        } else if ($paymentData->transaction_status == 'settlement') {
            $paymentData->setSuccess();
        } else if ($paymentData->transaction_status == 'pending') {
            $donation->setPending();
        } else if ($paymentData->transaction_status == 'deny') {
            $donation->setFailed();
        } else if ($paymentData->transaction_status == 'expire') {
            $donation->setExpired();
        } else if ($paymentData->transaction_status == 'cancel') {
            $donation->setFailed();
        }

        return response()->json([
            'status'    => false,
            'message'   => "Pembayaran pending"
        ]);
    }

    public function getEvents() {
        $data = file_get_contents("https://importir.com/api/seminar-json?key=faizalganteng");
        $array = json_decode($data, true);
        if ($array) {
            $this->event->getEvents($array);
        }
        
        $json['message'] = 'success';
        return response()->json($json);
    }
}