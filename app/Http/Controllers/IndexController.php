<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\EventsRepository;
use App\Payment\PaymentRepository;

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

    public function searchEvent(Request $request)
    {
        $inputs = $request->all();
        $event = $this->event->getEventBySearch($inputs);
        return view('front.allevent', compact('event'));
    }

    public function searchInvoice(Request $request)
    {
        return view('front.search-invoice');
    }

    public function searchInvoiceCheck(Request $request)
    {
        $content   = file_get_contents("https://importir.com/api/search-invoice?invoice=".$request->input('invoice')."&email=".$request->input('email')."");
        $data  = json_decode($content, true);

        if (isset($data['status'])) {
            alertNotify(false, $data['message'], $request);
            return redirect('search-invoice');
        }

        if ($data['status_paid'] == 'PAID') {
            $register = $this->event->registerByInvoice($data);
            alertNotify(true, 'Pembayaran Lunas, Silahkan download ticket Anda', $request);
            return redirect('payment' . '?token=' . encrypt($register->invoice));
        }

        $register = $this->event->registerByInvoice($data);

        alertNotify(true, "Invoice found successfully", $request);
        return redirect('payment' . '?token=' . encrypt($register->invoice));
    }
}
