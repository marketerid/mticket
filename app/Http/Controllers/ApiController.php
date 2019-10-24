<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\EventsRepository;
use App\Payment\PaymentRepository;
use App\Veritrans\MidtransService;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    protected $event, $payment;
    public function __construct(EventsRepository $event, PaymentRepository $payment)
    {
        $this->event    = $event;
        $this->payment  = $payment;
    }

    public function checkoutMidtrans(Request $request)
    {
        $data                   = file_get_contents('php://input');
        $dataJson               = \GuzzleHttp\json_decode($data);
        $register               = $this->event->findInvoice($dataJson->invoice);

        $merchantMakePayment    = $this->payment->makePaymentMidtrans($dataJson->invoice, $dataJson->type);
        if (!$merchantMakePayment) {
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

    public function savePaymentMidtrans($invoice, Request $request)
    {
        $result = $this->payment->savePaymentMidtrans($invoice, $request->all());
        return '';
    }

    public function paymentNotificationMidtrans(Request $request)
    {
        $midtrans   = new MidtransService();
        $response   = $midtrans->notification();
        Log::error("Midtrans Notif: " . response()->json($request->all()));

        if (is_null($response['order_id'])) {
            // something error
            return response()->json([
                'status'    => false,
                'message'   => "Something error"
            ]);
        }

        $bmo = substr($response['order_id'], 0, 3);
        if ($response['status_server'] == 'success' && $bmo == 'BMO') {
            // $this->payment->savePaymentFromNotify($response);
            $input = file_get_contents('php://input');
            $ch = curl_init(env('IMPORTIR_URL_MIDTRANS'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            return response()->json($result);
        }

        $paymentData    = $this->payment->notifyStatusMidtrans($response);
        if (!$paymentData) {
            return response()->json([
                'status'    => false,
                'message'   => "Already success"
            ]);
        }

        if ($response['status_server'] == 'success') {
            $this->event->updateStatusRegister($response, 'PAID');
            $notif_org = file_get_contents("https://importir.org/api/seminar-update/" . $response['order_id'] . "/MTICKET-MIDTRANS?token=syigdfjhagsjdf766et4wff6");
        }

        return response()->json($response);
    }

    public function getSeminar()
    {
        $data = file_get_contents("https://importir.com/api/seminar-json?key=faizalganteng");
        $array = json_decode($data, true);
        if ($array) {
            $this->event->insertSeminar($array);
        }

        $json['message'] = 'success';
        return response()->json($json);
    }

    public function changeStatusEvent()
    {
        $events = $this->event->getEvent();
        foreach ($events as $event) {
            $events = $event->event_date;
            if (strtotime($event->event_date) >= time()) {
                $status = 1;
            } else {
                $status = 0;
            }
            $this->event->changeStatusEvent($event->id, $status);
        }
        $json['message'] = 'success';
        return response()->json($json);
    }
}
