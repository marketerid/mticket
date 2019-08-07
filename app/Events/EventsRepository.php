<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class EventsRepository
{
    public function getEvent()
    {
        return Events::orderBy('id', 'desc')->get();
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
}
