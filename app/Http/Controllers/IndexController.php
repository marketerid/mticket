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
        if ($request->ajax()) {
            return view('front.load', compact('event'));
        }
        return view('front.index', compact('event'));
    }

    public function allEvent(Request $request)
    {
        $event = $this->event->getEvent();
        if ($request->ajax()) {
            return view('front.load', compact('event'));
        }
        return view('front.layout', compact('event'));
    }

    public function listevent(Request $request, $type = null)
    {
        $event = $this->event->findType($type);
        $type = ucfirst($type);
        if (!$event->count()) {
            return abort(404);
        }
        if ($request->ajax()) {
            return view('frontend.listevent.load', compact('event'));
        }
        return view('frontend.listevent.index', compact('type', 'event'));
    }

    public function viewEvent($type = null, $id = null)
    {
        $event = $this->event->findEvent($id);
        if (!$event) {
            return 'no event';
        } elseif ($event->type !== $type) {
            return abort(404);
        }
        return view('frontend.event.index', compact('event'));
    }

    public function registration(Request $request)
    {
        $inputs = $request->all();
        $register = $this->event->registration($inputs);
        if (!$register) {
            alertNotify(false, "Create Failed", $request);
            return redirect()->back();
        }
        return redirect(url('payment' . '?inv=' . $register->invoice));
    }

    public function payment(Request $request)
    {
        $inv = $request->get('inv');
        $payment = $this->event->findInvoice($inv);
        if (!$payment) {
            return 'no inv';
        }
        return view('frontend.payment.index', compact('payment'));
    }
}
