<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\EventsRepository;
use App\Payment\PaymentRepository;
use App\Mail\TrainingRegister as RegisterEmail;
use App\Mail\TestEmail;
use Mail;
use Validator;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{
    protected $register;
    public function __construct(EventsRepository $event) {
        $this->event     = $event;
    }

    public function index(Request $request)
    {
        $inputs = $request->all();
        $register = $this->event->registration($inputs);
        $total  = isset($inputs['total']) ? $inputs['total'] : 1;
        if($register != false AND $register->event_id){
            $mail         = $this->event->mailRegisterSeminar($register, $total);
        	$token          = $this->event->generateTokenTiket($register->invoice);

            return redirect('payment?token=' . $token);
        }
        if($register AND !$register->event_id){
            return redirect(url('thank-you-no-schedule'));
        }
        return response()->json(array('error' => 'sorry, system error'), 400);
    }

    public function payment(Request $request)
    {
        $token  =  $request->get('token');
        $invoice = null;

        try{
            $token    = decrypt($token);
        }catch (\Exception $exception){
            return 'no payment';
        }

        $decodeJson = json_decode($token);
        $ip         = $decodeJson->ip;
        $invoice    = $decodeJson->invoice;

        $payment = $this->event->findInvoice($invoice);
        if (!$payment) {
            return 'no inv';
        }
        return view('frontend.payment.index', compact('payment'));
    }

    public function tiketDownload(Request $request){
        $result = $this->event->getTiket($request->get('token'));
        if(!$result){
            if (!empty($result->lang) AND $result->lang == 'id') {
                return view('tiket');
            } else {
                return view('tiket-en');
            }
        }

        return $this->generatePDF($result->invoice);
    }

    public function generatePDF($invoice = ""){
        $user   = $this->event->findInvoice($invoice);

        return $this->event->invoiceToPdf($user);
    }

    public function getInfoUser($invoice = '', Request $request){
        $result = [
                'ip'            => '',
                'invoice'       => $invoice
            ];
        return redirect(url('payment?token=' . encrypt(json_encode($result))));
    }
}
