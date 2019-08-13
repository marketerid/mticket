<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use App\Events\Registration;
use App\Payment\Payment;

class EventsRepository
{
    public function getEvent()
    {
        return Events::orderBy('id', 'desc')->get();
    }

    public function getEventBySearch($inputs = [])
    {
        $data = Events::with([]);

        if (isset($inputs['q'])) {
            $data   = $data->where('title', 'like', '%' . $inputs['q'] . '%');
        }

        if (isset($inputs['city'])) {
            $data   = $data->where('city', 'like', '%' . $inputs['city'] . '%');
        }

        if (isset($inputs['month'])) {
            $data   = $data->where('event_date', 'like', '%' . $inputs['month'] . '%');
        }

        return $data->orderBy('id', 'DESC')->get();
    }

    public function getEventByType($type = '')
    {
        return Events::where('type', $type)->paginate(10);
    }

    public function findEvent($id = null)
    {
        return Events::find($id);
    }

    public function registration($inputs = [])
    {
        $event = Events::where('id', $inputs['event_id'])->first();

        $register               = new Registration();
        $lastInvoice            = $register->orderBy('id', 'desc')->pluck('id')->first();
        $newInvoice             = $lastInvoice + 1;
        $uniquecode             = rand(100, 999);

        $register->event_id     = $inputs['event_id'];
        $register->name         = $inputs['name'];
        $register->phone        = $inputs['phone'];
        $register->email        = $inputs['email'];
        $register->invoice      = 'MTA0' . $uniquecode . $newInvoice;
        $register->city         = $event->city;
        $register->total        = $event->price * $inputs['total'] + $uniquecode;
        $register->session      = $event->type;
        $register->reference    = $inputs['reference'];
        $register->save();
        return $register;
    }

    public function findRegister($id = null)
    {
        return Registration::find($id);
    }

    public function findInvoice($invoice = '')
    {
        return Registration::with(['event', 'payment'])->where('invoice', $invoice)->first();
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

    public function getEvents($array)
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

    public function findQuestionBySlug($slug = '')
    {
        return Question::with('lesson.Events')->where('slug', $slug)->firstOrFail();
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

    public function registerByInvoice($data = [])
    {
        $event = Events::where('source_id', $data['schedule_id'])->first();
        
        $register               = new Registration();
        $register->event_id     = $event->id;
        $register->name         = $data['name'];
        $register->phone        = $data['phone'];
        $register->email        = $data['email'];
        $register->invoice      = $data['invoice'];
        $register->city         = $data['city'];
        $register->total        = $data['total'];
        $register->session      = $event->type;
        $register->reference    = $data['reference'];
        $register->save();
        return $register;
    }

    public function registerPaidUser($data = [])
    {
        $payment                       = new Payment();
        $payment->invoice_id           = $data['invoice'];
        $payment->transaction_time     = date("Y-m-d H:i:s");
        $payment->payment_type         = 'Paid from ORG';
        $payment->gross_amount         = $data['total'];
        $payment->transaction_status   = 'success';
        $payment->fraud_status         = 'accept';
        $payment->paid_by              = 'ORG';
        $payment->save();

        return $this->generateTokenTiketLink($data);
    }

    public function generateTokenTiketLink($register){
        if(!$register){
            return '';
        }
        $result = [
            'ip'            => '',
            'invoice'       => $register['invoice']
        ];
        return encrypt(json_encode($result));
    }
}
