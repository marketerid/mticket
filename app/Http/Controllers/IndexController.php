<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\EventsRepository;
use App\Payment\PaymentRepository;
use App\Veritrans\MidtransService;

class IndexController extends Controller
{
    protected $event;
    public function __construct(EventsRepository $event)
    {
        $this->event = $event;
    }

    public function index(Request $request)
    {
        $event = $this->event->getEvent();
        return view('front.index', compact('event'));
    }

    public function allEvent(Request $request)
    {
        $event = $this->event->getEvent();
        return view('front.allevent', compact('event'));
    }

    public function listevent(Request $request, $type = null)
    {
        $event = $this->event->getEventByType($type);
        if (!$event->count()) {
            return 'no event';
        }
        return view('front.listevent', compact('event'));
    }

    public function viewEvent($type = null, $id = null)
    {
        $event = $this->event->findEvent($id);
        if (!$event) {
            return 'no event';
        } elseif ($event->type !== $type) {
            return 'no type';
        }
        return view('front.viewevent', compact('event'));
    }

    public function registration(Request $request)
    {
        $inputs = $request->all();
        $register = $this->event->registration($inputs);
        if (!$register) {
            alertNotify(false, "Create Failed", $request);
            return redirect()->back();
        }
        return redirect('payment' . '?token=' . encrypt($register->invoice));
    }

    public function payment(Request $request)
    {
        $token  =  $request->get('token');
        $invoice = null;

        try{
            $invoice    = decrypt($token);
        }catch (\Exception $exception){
            return 'no payment';
        }

        $payment = $this->event->findInvoice($invoice);
        if (!$payment) {
            return 'no inv';
        }
        return view('front.payment', compact('payment'));
    }

    public function findInvoice(Request $request)
    {
        $inv = $request->get('inv');
        return view('front.invoice');
    }

    public function resultInvoice()
    {
        $url = 'https://importir.com/api/find-invoice';
    }
}
