<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\EventsRepository;
use App\Payment\PaymentRepository;
use App\Veritrans\MidtransService;

class ApiController extends Controller
{
    protected $event, $payment;
    public function __construct(EventsRepository $event, PaymentRepository $payment) {
        $this->event    = $event;
        $this->payment  = $payment;
    }

    public function checkoutMidtrans(Request $request) {
        $data                   = file_get_contents('php://input');
        $dataJson               = \GuzzleHttp\json_decode($data);
        $register               = $this->event->findInvoice($dataJson->invoice);

        $merchantMakePayment    = $this->payment->makePaymentMidtrans($dataJson->invoice, $dataJson->type);
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
        $result = $this->payment->savePaymentMidtrans($invoice, $request->all());
        return '';
    }

    public function paymentNotificationMidtrans() {
        $midtrans   = new MidtransService();
        $response   = $midtrans->notification();

        if(is_null($response['order_id'])){
            // something error
            return response()->json([
                'status'    => false,
                'message'   => "Something error"
            ]);
        }

        $paymentData    = $this->payment->notifyStatusMidtrans($response);
        if(!$paymentData){
            return response()->json([
                'status'    => false,
                'message'   => "Already success"
            ]);
        }

        if ($response['status_server'] == 'success') {
            $notif_org = file_get_contents("https://importir.org/api/seminar-update/".$response['order_id']."/MTICKET-MIDTRANS?token=syigdfjhagsjdf766et4wff6");
        }

        return response()->json($response);
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