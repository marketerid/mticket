<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\EventsRepository;

class RegistrationController extends Controller
{
    protected $event;
    public function __construct(EventsRepository $event)
    {
        $this->event = $event;
    }

    public function index(Request $request)
    {
        $event = $this->event->getEvent();
        return view('dashboard.event.index', compact('event'));
    }

    // public function index(Request $request){
    //     $user   = Auth::guard('web')->user();
    //     $filters['user_id']     = $user->id;
    //     $filters['date_start']  = Carbon::now()->subDays(30);
    //     $filters['date_end']    = date("Y-m-d H:i:s");

    //     $logs                   = $this->wa->getLogs($filters);

    //     return view('dashboard.index', compact('logs'));
    // }
}
