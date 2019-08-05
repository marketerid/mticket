<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class EventsRepository
{
    //Function find
    public function findEvent($id = null)
    {
        return Events::find($id);
    }

    public function findRegister($id = null)
    {
        return Registration::find($id);
    }

    public function findType($type = '')
    {
        return Events::where('type', $type)->paginate(10);
    }

    public function findSlugByEvent($slug = '')
    {
        return Events::where('slug', $slug)->first();
    }

    public function getEvent()
    {
        return Events::orderBy('id', 'desc')->paginate(10);
    }

    public function registration($inputs = [])
    {
        $event = Events::where('id', $inputs['event_id'])->first();

        $register = new Registration();
        $lastInvoice = $register->orderBy('id', 'desc')->pluck('id')->first();
        $newInvoice = $lastInvoice + 1;
        $uniquecode = rand(100, 999);

        $register->event_id = $inputs['event_id'];
        $register->name = $inputs['name'];
        $register->phone = $inputs['phone'];
        $register->email = $inputs['email'];
        $register->invoice = 'MTA0' . $uniquecode . $newInvoice;
        $register->city = $event->city;
        $register->total = $event->price * $inputs['total'] + $uniquecode;
        $register->reference = $inputs['reference'];
        $register->save();
        return $register;
    }

    public function findInvoice($inv = '')
    {
        return Registration::with(['event'])->where('invoice', $inv)->first();
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

    public function cronjob($id, $events)
    {
        $data = Events::where('source_id', $id)->first();
        if (!$data) {
            $data   = new Events($events);
        }
        return $data->save();
    }

    public function findQuestionBySlug($slug = '')
    {
        return Question::with('lesson.Events')->where('slug', $slug)->firstOrFail();
    }
    public function checkQuestion($slug, $inputs)
    {
        $question = Question::with('answer')->where('slug', $slug)->firstOrFail();
        $result = "http://edutech.local/output/result.php";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $result,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "code={{$inputs['answer']}}",
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($question->answer != $response) {
            $result = false;
        } else {
            $result = true;
        }
        $into = Answer::updateOrCreate(
            ['user_id' => 1],
            [
                'Events_id' => 1,
                'lesson_id' => 1,
                'question_id' => 1,
                'submitted_code' => $inputs['answer'],
                'output' => $response,
                'result' => $result
            ]
        );
        $data = array(
            'finished_at' => false,
            'code_lang' => 'php',
            'output' => $response,
            'eval_output' => bcrypt($response),
            'result' => $result,
            'submitted_code' => $inputs['answer'],
            'message' => $question->message,
            'next_step' => 7,
            'total_step' => 10
        );
        return $data;
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

    public function getLesson()
    {
        return Lesson::all();
    }

    public function lessonStore($inputs = [])
    {
        $data = new Lesson([
            'title'         => $inputs['title'],
            'slug'          => str_slug($inputs['title']),
            'description'   => $inputs['description']
        ]);
        return $data->save();
    }

    public function lessonEdit($id = null)
    {
        return Lesson::findOrFail($id);
    }

    public function lessonUpdate($id = null, $inputs = [])
    {
        $data = [
            'title'         => $inputs['title'],
            'slug'          => str_slug($inputs['title']),
            'description'   => $inputs['description']
        ];
        return Lesson::findOrFail($id)->update($data);
    }
    public function lessonDelete($id = null)
    {
        return Lesson::findOrFail($id)->delete();
    }

    public function getQuestion()
    {
        return Question::all();
    }

    public function QuestionStore($inputs = [])
    {
        $data = new Question([
            'title'         => $inputs['title'],
            'slug'          => str_slug($inputs['title']),
            'description'   => $inputs['description']
        ]);
        return $data->save();
    }
    public function QuestionEdit($id = null)
    {
        return Question::findOrFail($id);
    }
    public function QuestionUpdate($id = null, $inputs = [])
    {
        $data = [
            'title'         => $inputs['title'],
            'slug'          => str_slug($inputs['title']),
            'description'   => $inputs['description']
        ];
        return Question::findOrFail($id)->update($data);
    }
    public function QuestionDelete($id = null)
    {
        return Question::find($id)->delete();
    }
}
