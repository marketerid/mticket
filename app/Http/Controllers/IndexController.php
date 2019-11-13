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
            alertNotify(false, 'Event Tidak Tersedia', $request);
            return redirect('event');
        }
        return view('frontend.listevent.index', compact('event', 'city'));
    }

    public function viewEvent(Request $request, $type = null, $id = null)
    {
        $today = date("Y-m-d");
        $event = $this->event->findEvent($id);
        if (!$event) {
            alertNotify(false, 'Event Tidak Tersedia', $request);
            return redirect('event');
        }

        if ($event->type !== $type) {
            alertNotify(false, 'Event Tidak Tersedia', $request);
            return redirect('event');
        }

        if ($today > $event->event_date) {
            $this->event->changeStatusEvent($event->id, 0);
            alertNotify(false, 'Event Tidak Tersedia', $request);
            return redirect('event');
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
        $content   = file_get_contents("https://importir.com/api/search-invoice?invoice=" . $request->input('invoice') . "&email=" . $request->input('email') . "");
        $data  = json_decode($content, true);

        if (isset($data['status'])) {
            alertNotify(false, $data['message'], $request);
            return redirect('search-invoice');
        }
        if ($data['total'] < 109000) {
            $total = 1;
        } else {
            $total = 2;
        }
        $register   = $this->event->registerByInvoice($data, $data['status_paid']);
        // return response()->json($register);die();
        $result     = $this->event->mailRegisterSeminar($register, $total);
        $token      = $this->event->generateTokenTiket($register->invoice);

        if ($data['status_paid'] == 'PAID') {
            alertNotify(true, 'Pembayaran Lunas, Silahkan download ticket Anda', $request);
            return redirect('payment?token=' . $token);
        }
        alertNotify(true, "Invoice found successfully", $request);
        return redirect('payment?token=' . $token);
    }

    public function regId(Request $request, $id)
    {
        return view('frontend.register.index', compact('id'));
    }
}
