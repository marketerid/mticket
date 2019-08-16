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

    public function store(Request $request)
    {
        $inputs = $request->all();
        $register = $this->event->registration($inputs);
        $total  = isset($inputs['total']) ? $inputs['total'] : 1;
        if($register != false AND $register->event_id){
            $message        = $register->event->before_paid_email;
            $message        = $this->event->replaceDynamicVarEmail($message, $register, $total);
            $result         = $this->event->mailRegisterSeminar($register, $message);
        	$token          = $this->event->generateTokenTiket($register->invoice);

            return redirect('payment?token=' . $token);
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

    public function index(Request $request)
    {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $last               = $this->register->getLastID();
        $data['name']       = $request->get('nama');
        $data['phone']      = $request->get('notelp');
        $data['session']    = "Gathering"; //$request->get('sesi');
        $data['total']      = 1;//$request->get('tp');
        $data['email']      = $request->get('email');
        $data['city']       = $request->get('lokasi');
        $data['reference']  = $request->get('ref');
        $data['ip']         = $ip;
        $data['ref_ad']     = null;
        $data['schedule_id']     = null;


        $user = $this->register->registerNew($last,$data);
        if($user != false AND $user->schedule_id){
            Mail::to($user)->send(new RegisterEmail($user));

            return response()->json(true);
        }

        return response()->json(false);
    }

    public function getInfoUser($invoice = '', Request $request){
        $result = [
                'ip'            => '',
                'invoice'       => $invoice
            ];
        return redirect(url('payment?token=' . encrypt(json_encode($result))));
    }

    public function acceptPaymentApi($invoice = "", $payment = "", Request $request){
        $tokenOrg   = $request->get('token');
        if($tokenOrg != env('TOKEN_ORG')){
            return response()->json([
                'status'    => false,
                'message'   => "Token Invalid"
            ]);
        }

        $resend     = $request->get('resend', 0);

        $user    = $this->register->acceptPaymentInvoice($invoice, $payment, $resend);
        if($user != false){

            $result = [
                'ip'            => $user->ip,
                'invoice'       => $user->invoice
            ];
            $download   = url('tiket?token=' . encrypt(json_encode($result)));

            if($user->total >= 600000){
                // DS
                $message    =  view('mail.training.paid-ds', compact('user','download'));

            }else{
                if ($user->lang == 'en') {
                    $message = view('mail.training.paid-en', compact('user', 'download'));
                } else {
                    $message = view('mail.training.paid', compact('user', 'download'));
                }

            }
            // disable for a while
            Mail::to($user)->send(new TrainingPaid($user));
            return $message;
        }

        return response()->json(false);
    }

    public function doPayment(Request $request){
        $email          = $request->get('email');
        $redirectLink   = $this->register->getPaymentQuery($email);
        $redirectLink   = ($redirectLink) ? $redirectLink->payment_link : url('');

        return redirect($redirectLink);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_old(RegisterRequest $request)
    {
        $verified = checkCaptcha($request->all());
        if (!$verified) {
            alertNotify(false, 'Please complete the Captcha', $request);
            return redirect()->back()->withInput($request->all());
        }

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $request_data = $request->all();
        $request_data['ip'] = $ip;
        $last       = $this->register->getLastID();
        $user       = $this->register->registerNew($last, $request_data);
        if($user != false AND $user->schedule_id){
           
            try {
                Mail::to($user)->send(new RegisterEmail($user));
            } catch (\Exception $e) {
                Log::error("Register seminar error" . $e->getMessage());
            }

            if($user->schedule->one_person_fee == 0){
                return redirect(url('thank-you-no-schedule?fee=' . $user->schedule->one_person_fee));
            }

            return redirect($user->payment_link);
        }

        if($user AND !$user->schedule_id OR $user->schedule->one_person_fee == 0){
            return redirect(url('thank-you-no-schedule?fee=' . $user->total));
        }

        return response()->json(array('error' => 'sorry, system error'), 400);
    }

    public function thankYou($invoiceID = ""){
        $user       = $this->register->findByInvoice($invoiceID);
        return view("thank-you", compact('user'));
    }

    public function noSchedule(Request $request){
        $fee    = $request->get('fee');
        return view("thank-you-no-schedule", compact('user','fee'));
    }

    public function payment_old(Request $request)
    {   
        $status = $request->get('status');
        $result = $this->register->payment($request);
        if ($result['success']) {
            $orgRegistration   = $result['message'];
            if ($orgRegistration->status_paid == 'PAID') {
                //return redirect(url('thank-you/' . $orgRegistration->invoice));
            }

            $province = null;
            $state = null;
            $city = null;
            $payo = null;
            if($orgRegistration->lang !='id'){
                $province = \App\State\Provinces::where('country_code', 'ph')->orderBy('name', 'asc')->get();
                if($orgRegistration->dump !=null){
                    $state = json_decode($orgRegistration->dump);
                    $city = \App\State\City::where('provinces_id', $state->state)->get();

                    $provinceName = \App\State\Provinces::find($state->state);
                    $cityName = \App\State\City::find($state->city);
                }
            }

            if($orgRegistration->invoice_response !=null){
                $getPayo = new \App\Payo\PayoService();
                $getPayo = $getPayo->status($orgRegistration->invoice);
                if($getPayo['status']){
                    $resPayo = $getPayo['data'];
                    if($resPayo['success']){
                        $payo = $resPayo;
                    }   
                }
            }
            return view('payment.index', 
                        compact('orgRegistration', 
                                'status', 
                                'province', 
                                'state', 
                                'city',
                                'provinceName',
                                'cityName',
                                'payo'
                        ));
        } else {
            return view('payment.failed');
        }
    }

    public function tiket(Request $request){
        $download   = url('tiket-download?token=' . $request->get('token'));
        $result     = $this->register->getTiket($request->get('token'));

        $hasTiket   = false;
        if($result){
            $hasTiket   = true;
        }

        if (!empty($result->lang) AND $result->lang == 'id') {
            return view('tiket', compact('download', 'hasTiket','result'));
        } else {
            return view('tiket-en', compact('download', 'hasTiket','result'));
        }
    }

    public function paymentMemberOrg(Request $request)
    {
        $result = $this->register->paymentMemberOrg($request);
        if ($result['success']) {
            $mo   = $result['message'];
            return view('payment.member.index', compact('mo'));
        } else {
            Log::error("error payment member page " . json_encode($result['message']));
            return view('payment.member.failed');
        }
    }

    public function saveInfoMidtrans($id, Request $request)
    {
        $result = $this->register->saveInfoMidtrans($id, $request->all());
        return '';
    }

    public function cancelPayment($id)
    {
        $this->register->cancelPaymentInv($id);
        return redirect(url()->previous());
    }

    public function getCityByState($state)
    {
        $city = \App\State\City::where('provinces_id', $state)->get();
        return response()->json($city);
    }
}
