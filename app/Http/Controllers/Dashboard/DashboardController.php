<?php

namespace App\Http\Controllers\Dashboard;

use App\CsRotate\CsRotateRepository;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // protected $wa;
    // public function __construct()
    // {
    //     $this->wa   = new CsRotateRepository();
    // }

    public function index(Request $request)
    {
        return view('dashboard.index');
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
