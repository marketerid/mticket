<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Requests\SavePasswordRequest;
use App\Http\Requests\SaveUserRequest;
use App\MailJet\MailJetService;
use App\Order\OrderRepository;
use App\SmsGateway\ZenzivaService;
use App\User\UserRepository;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    protected $user, $order, $sms, $mail;
    public function __construct(UserRepository $user, OrderRepository $order){
        $this->user     = $user;
        $this->order    = $order;
        $this->sms      = new ZenzivaService();
        $this->mail     = new MailJetService();
    }

    public function viewProfile(Request $request){
        $user       = Auth::guard('web')->user();
        $user       = $this->user->find($user->id);

        return view('dashboard.user.profile', compact('user'));
    }

    public function formProfile(Request $request){
        $user       = Auth::guard('web')->user();
        $user       = $this->user->find($user->id);

        return view('dashboard.user.form-profile', compact('user'));
    }

    public function saveProfile(SaveUserRequest $request){
        $user   = Auth::guard('web')->user();
        $inputs = $request->all();
        $save   = $this->user->save($user->id, $inputs);

        alertNotify(true, "Profile Sukses Diupdate", $request);

        return redirect(url('dashboard/user'));
    }

    public function formPassword(Request $request){
        $user       = Auth::guard('web')->user();
        $user       = $this->user->find($user->id);

        return view('dashboard.user.form-password', compact('user'));
    }

    public function savePassword(SavePasswordRequest $request){
        $user   = Auth::guard('web')->user();
        $inputs = $request->all();
        $save   = $this->user->savePassword($user->id, $inputs);
        if($save['status'] == false){
            alertNotify(false, $save['message'], $request);
            return redirect()->back();
        }

        alertNotify(true, "Profile Sukses Diupdate", $request);

        return redirect(url('dashboard/user'));
    }

    public function notificationAjax(Request $request){
        try{
            $token     = decrypt($request->get('token'));
        }catch (\Exception $exception){
            return response()->json([
                'status'    => 0,
                'data'      => [],
                'message'   => 'Invalid Token'
            ]);
        }

        $data   = json_decode($token);
        if($data->expired_at < date("Y-m-d H:i:s")){
            return response()->json([
                'status'    => 0,
                'data'      => [],
                'message'   => 'Token Expired'
            ]);
        }
        $userId     = $data->user_id;

        $user       = $this->user->find($userId);
        $filters['user_id'] = $user->id;
        $filters['read_at'] = false;
        $notifications      = $this->user->getNotification($filters,5);

        return response()->json([
            'status'    => 1,
            'html'      => view('dashboard.notification', compact('notifications'))->render(),
            'total'     => $notifications->count()
        ]);
    }

    public function notification(Request $request){
        $userId     = Auth::guard('web')->user()->id;
        $user       = $this->user->find($userId);

        $filters['user_id'] = $user->id;
        $notifications      = $this->user->getNotification($filters,25);

        return view('dashboard.user.notification-list', compact('notifications','user'));
    }

    public function notificationDetail($id = null, Request $request){
        $userId     = Auth::guard('web')->user()->id;
        $user       = $this->user->find($userId);
        $notification   = $this->user->findNotification($id);
        if($notification->user_id != $user->id){
            return abort(403, "Anda tidak mempunyai akses ke halaman ini, [NotificationDetail]");
        }
        $this->user->readNotification($id);

        return view('dashboard.user.notification-detail', compact('notification','user'));
    }
}
