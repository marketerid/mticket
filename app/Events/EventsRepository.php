<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use App\Events\Registration;
use App\Payment\Payment;
use App\CssInliner\CssInliner;
use App\GoSMS\GoSMSService;
use App\Sendgrid\SendgridService;

class EventsRepository
{
    public function getEvent()
    {
        return Events::orderBy('id', 'desc')->get();
    }

    public function getEventByType($type = '')
    {
        return Events::where('type', $type)->get();
    }

    public function findEvent($id = null)
    {
        return Events::with([])->where('source_id', $id);
    }

    public function getEventBySearch($inputs = [])
    {
        $data = Events::with([]);

        if (isset($inputs['q'])) {
            $data   = $data->where('title', 'like', '%' . $inputs['q'] . '%');
        }

        if (isset($inputs['city_id'])) {
            $data   = $data->where('source_id', $inputs['city_id']);
        }

        return $data->orderBy('id', 'DESC')->get();
    }

    public function findRegister($id)
    {
        return Registration::with(['event'])->find($id);
    }

    public function findScheduleByCity($city = null)
    {
        if(is_null($city)){
            return null;
        }

        $event   = Events::with([])->where('city', strtolower($city))
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->where('status', 1)
            ->first();

        if(!$event){
            return null;
        }

        return $event->id;
    }

    public function getScheduleByIdAndStatus($id, $status)
    {
        return Events::with([])->where('source_id', $id)->where("status", $status)->first();
    }

    public function registration($inputs = [])
    {
        $register               = new Registration();
        $event                  = $this->getScheduleByIdAndStatus($inputs['event_id'], 1);
        if(!$event){
            return false;
        }

        $lastInvoice            = $register->orderBy('id', 'desc')->pluck('id')->first();
        $newInvoice             = $lastInvoice + 1;
        $uniquecode             = rand(100, 999);

        $register->event_id     = $inputs['event_id'];
        $register->invoice      = 'MTA0' . $uniquecode . $newInvoice;
        $register->lang         = isset($inputs['lang']) ? $inputs['lang'] : 'id';
        $register->name         = $inputs['name'];
        $register->phone        = $inputs['phone'];
        $register->email        = $inputs['email'];
        $register->city         = $event->city;
        $register->total        = $event->price * $inputs['total'] + $uniquecode;
        $register->session      = $event->type;
        $register->reference    = $inputs['reference'];
        $register->status       = 'PENDING';
        $register->save();

        $user                   = $this->findRegister($register->id);

        $sms                    = new GoSMSService();
        if (!is_null($user->event)) {
            if ($user->event->type == 'seminar') {
                if (!is_null($register->event_id) AND $inputs['total'] > 0 AND ($event AND $event->is_full == 0)) {
                    // manipulate event ID
                    $user->event_id = true;
                    $msg = "Anda trdaftar u/ event ".$event->title.". Pmbyaran Rp" . number_format($user->total, 0) . " harap Trfr sblm 23:59 " . date("m/d/Y") . ",info pembayaran ada pd email Anda, CS: Chat di Web";

                } else {
                    $user->event_id = false;
                    $msg    = "Kota yang Anda daftarkan masih belum ada jadwal seminar atau seminar sudah PENUH, kami akan menghubungi Anda jika terdapat update. Terimakasih";
                }
            } else {
                $msg    = $user->event->before_paid_sms;
                $msg    = $this->replaceDynamicVarEmail($msg, $user, $inputs['total']);
            }
            $sms->sendSMS($user->phone, $user->city, $msg, $user->lang);
        }

        @file_get_contents("https://importir.org/api/custom-seminar-register?name=".$inputs['name']."&email=".$inputs['email']."&phone=".$inputs['phone']."&total=".$inputs['total']."&schedule_id=".$inputs['event_id']."&reference=".$inputs['reference']."&session=".$event->type."");

        return $user;
    }

    public function registerByInvoice($data = [], $status)
    {
        $register               = new Registration();
        $event                  = $this->getScheduleByIdAndStatus($data['schedule_id'], 1);
        if(!$event){
            return false;
        }

        $register->event_id     = $data['schedule_id'];
        $register->name         = $data['name'];
        $register->phone        = $data['phone'];
        $register->email        = $data['email'];
        $register->invoice      = $data['invoice'];
        $register->lang         = isset($inputs['lang']) ? $inputs['lang'] : 'id';
        $register->city         = $data['city'];
        $register->total        = $data['total'];
        $register->session      = isset($event->type) ? $event->type : 1;
        $register->reference    = $data['reference'];
        $register->status       = $status;
        $register->save();

        $user                   = $this->findRegister($register->id);
        $sms                    = new GoSMSService();

        if (!is_null($user->event)) {
            if ($user->event->seminar_type == 'seminar') {
                if ($status == 'PAID') {
                    $msg        = "Pembayaran lunas u/ event ".$event->title.". senilai Rp" . number_format($user->total, 0) . " info lebih lengkap ada pd email Anda, CS: Chat di Web";
                } else {
                    $msg        = "Anda trdaftar u/ event ".$event->title.". Pmbyaran Rp" . number_format($user->total, 0) . " harap Trfr sblm 23:59 " . date("m/d/Y") . ",info pembayaran ada pd email Anda, CS: Chat di Web";
                }
            } else {
                if ($status == 'PAID') {
                    $msg        = $user->event->after_paid_sms;
                    $msg        = $this->replaceDynamicVarEmail($msg, $user, $data['total']);
                } else {
                    $msg        = $user->event->before_paid_sms;
                    $msg        = $this->replaceDynamicVarEmail($msg, $user, $data['total']);
                }
            }
            $sms->sendSMS($user->phone, $user->city, $msg, $user->lang);
        }

        return $user;
    }

    public function findInvoice($invoice = '')
    {
        return Registration::with(['event'])->where('invoice', $invoice)->first();
    }

    public function generateTokenTiket($invoice = ''){
        $register   = $this->findInvoice($invoice);
        if(!$register){
            return false;
        }

        $result = [
            'ip'            => '',
            'invoice'       => $register->invoice
        ];

        return encrypt(json_encode($result));
    }

    public function getTiket($token)
    {
        try {
            $token  = decrypt($token);
        } catch (DecryptException $e) {
            //
            return false;
        }

        $decodeJson = json_decode($token);
        $ip         = $decodeJson->ip;
        $invoice    = $decodeJson->invoice;

        return Registration::with([])
            ->where('invoice', $invoice)
            //->where('ip', $ip)
            ->where('status', 'PAID')
            ->first();
    }

    public function invoiceToPdf($user){
        if(!$user){
            return response('No invoice Data', 404);
        }

        if ($user->lang == 'en') {
            $view = view('invoice.seminar-en', compact('user'));
        } else {
            $view = view('invoice.seminar', compact('user'));
        }

        $mpdf   = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($view);
        $name   = "pdf-" . $user->invoice .".pdf";

        return $mpdf->Output($name, 'I');
    }

    public function replaceDynamicVarEmail($message, $user, $total, $lang = 'id')
    {
        $token   = $this->generateTokenTiket($user->invoice);
        $message = str_replace("{{NAMA}}", $user->name, $message);
        $message = str_replace("{{PHONE}}", $user->phone, $message);
        $message = str_replace("{{TITLE}}", $user->event->title, $message);
        $message = str_replace("{{DESKRIPSI}}", $user->event->description, $message);
        $message = str_replace("{{EMAIL}}", $user->email, $message);
        $message = str_replace("{{TIPE}}", $user->event->type, $message);
        $message = str_replace("{{KOTA}}", $user->city, $message);
        $message = str_replace("{{ORANG}}", $total, $message);
        $total      = $user->total;
        $pay        = "PAY";
        if($lang == 'en'){
            $total  = $total / 275;
        }
        $message = str_replace("{{TOTAL}}", number_format($total, 0), $message);
        $message = str_replace("{{LINKTOMBOL}}", '<a href="' . url(env('IMPORTIRORG_API') . '/payment?token=' . $token) . '">'. $pay .'</a>', $message);
        $message = str_replace("{{TOMBOL}}", '<a href="' . url(env('IMPORTIRORG_API') . '/payment?token=' . $token) . '">'. $pay .'</a>', $message);
        $message = str_replace("{{TANGGAL}}", date("d-M-Y", strtotime($user->event->event_date)), $message);
        if (strpos($message, '{{HARI}}') !== false) {
            $timestamp = strtotime($user->event->event_date);
            $day = date('D', $timestamp);
            $dayList = array(
                'Sun' => 'Minggu',
                'Mon' => 'Senin',
                'Tue' => 'Selasa',
                'Wed' => 'Rabu',
                'Thu' => 'Kamis',
                'Fri' => 'Jumat',
                'Sat' => 'Sabtu'
            );
            $message = str_replace("{{HARI}}", $dayList[$day], $message);
        }
        return $message;
    }

    public function mailRegisterSeminar($user, $total)
    {
        if (!is_null($user->event)) {
            if ($user->event->type == 'seminar') {
                if ($user->status == 'PAID') {
                    $title      = "Registration Paid";
                    $view       = view('mail.event.paid', compact('user'));
                } else {
                    $title      = "Registration Success";
                    $view       = view('mail.event.register', compact('user'));
                }
            } else {
                if ($user->status == 'PAID') {
                    $title      = "Registration Paid";
                    $message    = $user->event->after_paid_email;
                    $message    = $this->replaceDynamicVarEmail($message, $user, $total, $user->lang);
                    $view       = view('mail.custom.register', compact('message'));
                } else {
                    $title      = "Registration Success";
                    $message    = $user->event->before_paid_email;
                    $message    = $this->replaceDynamicVarEmail($message, $user, $total, $user->lang);
                    $view       = view('mail.custom.register', compact('message'));
                }
            }
            $arrConOpt  = [
                "ssl"   => [
                    "verify_peer"   => false,
                    "verify_peer_name"  => false
                ]
            ];
            $css        = asset("assets/css/mail.css");
            $view       = new CssInliner($view, file_get_contents($css, false, stream_context_create($arrConOpt)));
            return $this->_sendMailSendGrid($user->email, $view->convert(), $title);
        }
    }

    private function _sendMailSendGrid($email, $view, $title = ''){
        $json_string    = [
            'to'        => [
                'info@mticket.asia',
                $email
            ],
            'category'  => 'mticket.asia'
        ];
        $params = [
            'x-smtpapi' => json_encode($json_string),
            'to'        => $email,
            'subject'   => $title,
            'html'      => $view,
            'from'      => 'info@mticket.asia',
        ];
        $sendgrid       = new SendgridService();
        $result         = $sendgrid->sendBulkSendGrid($params);
        return $result;
    }

    public function eventStore($inputs = [])
    {
        $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('assets/img'), $imageName);
        $data = new Events([
            'type'         => $inputs['type'],
            'title'         => $inputs['title'],
            'slug'          => str_slug($inputs['title']),
            'description'   => $inputs['description'],
            'images'         => $imageName,
            'city'         => $inputs['city'],
            'price'         => parseFloatComma($inputs['price']),
            'event_date'         => $inputs['event_date'],
            'before_paid_sms'         => $inputs['before_paid_sms'],
            'after_paid_sms'         => $inputs['after_paid_sms'],
            'before_paid_email'         => $inputs['before_paid_email'],
            'after_paid_email'         => $inputs['after_paid_email'],
        ]);
        return $data->save();
    }

    public function insertSeminar($array)
    {
        foreach($array as $row){
            if($row['seminar_type'] == 'event') {
                $type = 'seminar';
            } else {
                $type = $row['seminar_type'];
            }

            if ($row['seminar_title'] == '') {
               $title = 'Seminar Importir.org - '.$row['city'];
            } else {
                $title = $row['seminar_title'];
            }

            $events = [
                'source_id'             => $row['id'],
                'type'                  => $type,
                'title'                 => $title,
                'description'           => $row['info']['desc'],
                'image'                 => $row['info']['maps'],
                'city'                  => $row['city'],
                'price'                 => $row['info']['one_person_fee'],
                'event_date'            => $row['info']['event_date'],
                'before_paid_sms'       => $row['info']['before_paid_sms'],
                'after_paid_sms'        => $row['info']['after_paid_sms'],
                'before_paid_email'     => $row['info']['before_paid_email'],
                'after_paid_email'      => $row['info']['after_paid_email'],
                'is_full'               => $row['info']['is_full'],
                'status'                => $row['info']['status']
            ];

            $data = Events::where('source_id', $row['id'])->first();
            if ($data) {
              $data->update($events);
            } else {
              $data = Events::create($events);  
            }
        }
    }

    public function EventsStore($inputs = [])
    {
        $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('static/images'), $imageName);
        $data = new Events([
            'title'         => $inputs['title'],
            'description'   => $inputs['description'],
            'image'         => $imageName,
            'slug'          => str_slug($inputs['title'])
        ]);
        return $data->save();
    }

    public function EventsEdit($id = null)
    {
        return Events::findOrFail($id);
    }

    public function EventsUpdate($id = null, $inputs = [])
    {
        $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('static/images'), $imageName);
        $data = [
            'title'         => $inputs['title'],
            'description'   => $inputs['description'],
            'image'         => $imageName,
            'slug'          => str_slug($inputs['title'])
        ];
        return Events::findOrFail($id)->update($data);
    }

    public function eventDelete($id = null)
    {
        return Events::findOrFail($id)->delete();
    }

    public function getCity()
    {
        return Events::select('source_id', 'city')->where('status', 1)->get();
    }

    public function updateStatusRegister($response, $status)
    {
        $total = 1;
        $user = Registration::where('invoice', $response['order_id'])->update(['payment' => $response['type'], 'status' => $status]);
        $sms        = new GoSMSService();
        if (!is_null($user->event)) {
            $token = [
                'ip'        => '',
                'invoice'   => $user->invoice
            ];
            $download = url('tiket?token=' . encrypt(json_encode($token)));
            if ($user->event->seminar_type == 'seminar') {
                if ($register->status == 'PAID') {
                    $title      = "Registration Paid";
                    $message    = view('mail.event.paid', compact('user', 'download'));
                    $msg        = "Pembayaran u/ event ".$event->title.". senilai Rp" . number_format($user->total, 0) . " info lebih lengkap ada pd email Anda, CS: Chat di Web";
                }
            } else {
                $title      = "Registration Paid";
                $message    = $user->event->before_paid_email;
                $message    = $this->replaceDynamicVarEmail($message, $user, $total);
                $message    = view('mail.event.paid', compact('user', 'download'));
            }
            $arrConOpt  = [
                "ssl"   => [
                    "verify_peer"   => false,
                    "verify_peer_name"  => false
                ]
            ];
            $sms->sendSMS($user->phone, $user->city, $message, $user->lang);
            $css        = asset("assets/css/mail.css");
            $view       = new CssInliner($view, file_get_contents($css, false, stream_context_create($arrConOpt)));
            return $this->_sendMailSendGrid($user->email, $view->convert(), $title);
        }
        return '';
    }

    public function changeStatusEvent($id, $status)
    {
        $user = Events::where('id', $id)->update(['status' => $status]);
        return $user;
    }
}
