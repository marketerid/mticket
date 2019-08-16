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
        $city  = $this->event->getCity();
        return view('frontend.index', compact('event', 'city'));
    }

    public function allEvent(Request $request)
    {
        $event = $this->event->getEvent();
        $city  = $this->event->getCity();
        return view('frontend.allevent.index', compact('event', 'city'));
    }

    public function listevent(Request $request, $type = null)
    {
        $event = $this->event->getEventByType($type);
        $city  = $this->event->getCity();
        if (!$event->count()) {
            abort(404);
        }
        return view('frontend.listevent.index', compact('event', 'city'));
    }

    public function viewEvent($type = null, $id = null)
    {
        $event = $this->event->findEvent($id);
        if (!$event) {
            return 'no event';
        } elseif ($event->type !== $type) {
            return 'no type';
        }

        return view('frontend.viewevent.index', compact('event'));
    }

    public function searchEvent(Request $request)
    {
        $inputs = $request->all();
        $event = $this->event->getEventBySearch($inputs);
        $city  = $this->event->getCity();
        return view('frontend.allevent.index', compact('event', 'city'));
    }

    public function searchInvoice(Request $request)
    {
        return view('frontend.invoice.search');
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
            $register   = $this->event->registerByInvoice($data, $data['status_paid']);
            alertNotify(true, 'Pembayaran Lunas, Silahkan download ticket Anda', $request);
            return redirect('payment?token=' . $register);
        }

        $total          = isset($inputs['total']) ? $inputs['total'] : 1;
        $register       = $this->event->registerByInvoice($data, 'PENDING');
        $message        = $register->event->before_paid_email;
        $message        = $this->event->replaceDynamicVarEmail($message, $register, $total);
        $result         = $this->event->mailRegisterSeminar($register, $message);
        $token          = $this->event->generateTokenTiket($register->invoice);

        alertNotify(true, "Invoice found successfully", $request);
        return redirect('payment' . '?token=' . $token);
    }
}
