<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\EventsRepository;

class EventController extends Controller
{
    protected $event;
    public function __construct(EventsRepository $event)
    {
        $this->event = $event;
    }

    public function index(Request $request)
    {
        $event = $this->event->getEvent()->appends($request->all());
        if ($request->ajax()) {
            return view('dashboard.event.load', compact('event'));
        }
        return view('dashboard.event.index', compact('event'));
    } 

    public function create()
    {
        return view('dashboard.event.create');
    } 

    public function store(Request $request)
    {
        $inputs = $request->all();
        $save = $this->event->eventStore($inputs);
        if ($save == true) {
            alertNotify(true, $inputs['title'], $request);
            return redirect()->route('event.index');
        }
        alertNotify(false, "Create Failed", $request);
        return redirect()->back();
    }

    public function detail($id)
    {
        $event = $this->event->findEvent($id);
        return view('dashboard.event.detail', compact('event'));
    }

    public function edit($id)
    {
        $event = $this->event->findEvent($id);
        return view('dashboard.event.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->all();
        $update = $this->play->lectureUpdate($id, $inputs);
        if ($update == true) {
            alertNotify(true, $inputs['title'] . " Updated", $request);
            return redirect()->route('lecture.index');
        }
        alertNotify(false, "Update Failed", $request);
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $event = $this->event->eventDelete($request->get('id'));
        if ($event == true) {
            alertNotify(true, "ID Deleted", $request);
            return redirect()->route('event.index');
        }
        alertNotify(false, "Delete Failed", $request);
        return redirect()->back();
    }
}
