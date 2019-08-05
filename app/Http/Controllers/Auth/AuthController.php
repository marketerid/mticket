<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\RegisterUserRequest;
use App\MailChimp\MailChimpService;
use App\MailJet\MailJetService;
use App\Order\OrderRepository;
use App\SmsGateway\ZenzivaService;
use App\User\PhoneNumberService;
use App\User\UserRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\AdminUsers\AdminUserRepository;
use App\Notifications\MailResetPasswordToken;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    protected $loginView    = 'admin.auth.login';
    protected $guard        = 'web';
    protected $redirectTo   = null;

    protected $user, $order, $sms, $mailchimp, $email;
    public function __construct(UserRepository $user)
    {
        $this->user        = $user;
        // $this->order    = new OrderRepository();
        $this->sms      = new ZenzivaService();
        // $this->mailchimp    = new MailChimpService();
        $this->email        = new MailJetService();
    }

    public function login(Request $request)
    {
        $page       = 'login';
        $asOperator = $request->get('as_operator', 0);

        return view('auth.login', compact('page', 'asOperator'));
    }

    public function authenticate(Request $request)
    {
        $credentials    = [
            'user'      => $request->get('user'),
            'password'  => $request->get('password')
        ];
        $loginAsOperator    = $request->get('as_operator', 0);
        $authenticate        = $this->user->userLogin($credentials, $loginAsOperator);
        if (!$authenticate) {
            alertNotify(false, 'Invalid email or password', $request);

            return redirect('auth/login' . ($loginAsOperator ? '?as_operator=1' : ''));
        }

        $user           = Auth::guard('web')->user();
        // if login as operator
        if ($user->is_operator) {
            return redirect(url('dashboard'));
        }


        if (is_null($user->activated)) {
            alertNotify(false, "Harap verifikasi nomor handphone Anda", $request);
            return redirect(url('auth/resend-verification-process'));
        }

        $hasUnpaidOrder       = $this->order->hasActiveOrderUnpaid($user->id);
        if ($hasUnpaidOrder) {
            alertNotify(false, "Anda mempunyai order aktif belum lunas, silahkan melakukan pembayaran", $request);
            return redirect(url('dashboard/user/order-detail/' . $hasUnpaidOrder->id));
        }

        return redirect()->intended('dashboard');
    }

    public function logout(Request $request)
    {
        $checkLogin = Auth::guard('web')->check();
        if (!$checkLogin) {
            alertNotify(false, "Anda belum masuk", $request);
            return redirect(url('auth/login'));
        }

        alertNotify(true, "Anda berhasil keluar", $request);
        Auth::guard('web')->logout();

        return redirect('auth/login');
    }

    public function logoutOp(Request $request)
    {
        $checkLogin = Auth::guard('operator')->check();
        if (!$checkLogin) {
            alertNotify(false, "Anda belum masuk", $request);
            return redirect(url('auth/login-op'));
        }

        alertNotify(true, "Anda berhasil keluar", $request);
        Auth::guard('operator')->logout();

        return redirect('auth/login-op');
    }

    public function forgotPass(Request $request)
    {
        $page   = 'forgot';
        return view('auth.login', compact('page'));
    }


    public function forgotPassProcess(Request $request)
    {
        $phone  = $request->get('phone');
        $user   = $this->user->findByPhone($phone);
        if (!$user) {
            alertNotify(false, 'User tidak ditemukan', $request);

            return redirect()->back();
        }
        $validate   = $this->user->validateResendAttempt($user->id);
        if ($validate['status'] == false) {
            alertNotify(false, $validate['message'], $request);
            return redirect()->back();
        }

        $token  = $this->user->generateTokenForgotPassword($user);

        session(['forgot_pass_user_id'  => $user->id]);
        alertNotify(true, 'Forgot password success sent, silahkan periksa SMS di handphone Anda (-+5 menit)', $request);
        $this->sms->send('Hallo, Kode Lupas Sandi Anda adalah ' . $token . ', akan expired dalam 30 menit, by WASEND.ID', $user->phone);

        return redirect(url('auth/phone-forgot-verification'));
    }

    public function phoneForgotVerification(Request $request)
    {
        $userId     = session('forgot_pass_user_id');
        if (is_null($userId)) {
            alertNotify(false, "Anda tidak berhasil mengirimkan kode sms, silahkan coba lagi", $request);
            return redirect(url('auth/forgot-password'));
        }

        $checkLogin = Auth::guard('web')->check();
        if ($checkLogin) {
            alertNotify(false, "Anda telah login", $request);
            return redirect(url('dashboard'));
        }

        $user       = $this->user->find($userId);

        return view('auth.phone-forgot-verification', compact('user'));
    }

    public function phoneResetToken(Request $request)
    {
        $userId = session('forgot_pass_user_id');
        $token  = $request->get('token');
        $reset  = $this->user->validateUserByToken($userId, $token);
        $user   = $this->user->find($userId);
        if (!$reset['status']) {
            alertNotify(false, $reset['message'], $request);
            return view('auth.phone-forgot-verification', compact('user'));
        }
        alertNotify(true, 'Verifikasi berhasil, silahkan tuliskan password baru Anda', $request);

        session(['forgot_pass_user_id'  => $userId, 'pass_token' => $token]);
        return view('auth.forgot-change-pass', compact('token', 'user'));
    }

    public function changePhonePass(ChangePasswordRequest $request)
    {
        $userId     = session('forgot_pass_user_id');
        $token      = session('pass_token');

        $reset      = $this->user->validateUserByToken($userId, $token);
        $newPass    = $request->get('password');
        if (!$reset) {
            alertNotify(false, 'Token salah/expired', $request);

            return redirect('auth/login');
        }

        $user   = $this->user->changePassword($userId, $newPass);

        session(['forgot_pass_user_id'  => null, 'pass_token' => null]);
        alertNotify(true, "Password berhasil dirubah, silahkan login menggunakan password baru Anda", $request);
        $this->sms->send('Password anda berhasil dirubah, by WASEND.ID', $user->phone);

        return redirect(url('auth/login'));
    }

    public function register(Request $request)
    {
        $page       = 'login';
        $utm        = $request->get('utm', '');
        $packageId  = $request->get('package_id', '');
        if ($packageId) {
            $package    = $this->order->findPackage($packageId);
            if ($package) {
                $package    = $package->slug;
            }
        }
        $name       = $request->get('name', '');
        $phone      = $request->get('phone', '');
        $email      = $request->get('email', '');

        return view('auth.register', compact('utm', 'package', 'name', 'phone', 'email', 'page'));
    }

    public function registerProcess(RegisterUserRequest $request)
    {
        $utm        = $request->get('utm', '');
        $packageSlug    = $request->get('package', '');
        $name       = $request->get('name', '');
        $phone      = $request->get('phone', '');
        $email      = $request->get('email', '');
        $password   = $request->get('password');

        // send email
        $result     = $this->user->register($name, $phone, $email, $password, $utm);
        if (!$result['status']) {
            alertNotify(false, $result['message'], $request);
            return redirect()->back();
        }
        $user   = $result['data'];

        // mailchimp
        $this->mailchimp->subscribe($email, $name, $phone);
        $this->email->send($email, $name, "Email Pendaftaran WASEND", "Hallo " . $name . ", Terimakasih telah mendaftar di <a href='wasend.id'>wasend.id</a>");


        if ($packageSlug) {
            // make order
            $resultPackage  = $this->order->orderPackage($user, $packageSlug);
            $addTag         = $this->mailchimp->addTag($email, 'package_' . $packageSlug);
        }

        // send email and sms
        $message        = "Kode aktivasi Anda " . $user->activate_code . " akan expired pada 60 menit. jangan dibalas by WASEND.ID";
        $this->sms->send($message, $user->phone);

        Auth::guard('web')->login($user);

        alertNotify(true, "Silahkan check sms kode verifikasi di handphone Anda", $request);
        return redirect(url('auth/phone-verification'));
    }

    public function phoneVerification(Request $request)
    {
        $checkLogin = Auth::guard('web')->check();
        if (!$checkLogin) {
            return redirect(url('auth/login'));
        }

        $user       = Auth::guard('web')->user();

        return view('auth.phone-verification', compact('user'));
    }

    public function phoneVerificationProcess(Request $request)
    {
        $checkLogin = Auth::guard('web')->check();
        if (!$checkLogin) {
            alertNotify(false, "Anda belum terdaftar", $request);
            return redirect(url('auth/register'));
        }

        $user       = Auth::guard('web')->user();
        if (!is_null($user->activated)) {
            alertNotify(false, "Akun Anda telah teraktivasi, silahkan login", $request);
            return redirect(url('dashboard'));
        }

        $activateCode   = $request->get('activate_code');
        $result         = $this->user->activatePhone($activateCode, $user);
        if (!$result['status']) {
            alertNotify(false, $result['message'], $request);
            return redirect()->back();
        }

        // create operator
        $hasOwnOperator = $this->user->findOperatorByEmailAndUserId($user->email, $user->id);
        if (!$hasOwnOperator) {
            // create new Operator for himself
            $inputs = [
                'name'  => $user->name,
                'email' => $user->email,
                'phone' => $user->phone
            ];
            $this->user->saveOperator(null, $inputs, $user);
        }

        $hasUnpaidOrder       = $this->order->hasActiveOrderUnpaid($user->id);
        if ($hasUnpaidOrder) {
            alertNotify(true, "Anda berhasil konfirmasi nomor HP, dan berikut detail order Anda", $request);
            return redirect(url('dashboard/user/order-detail/' . $hasUnpaidOrder->id));
        }

        alertNotify(true, $result['message'], $request);
        return redirect(url('dashboard'));
    }

    public function resendVerificationCodeProcess(Request $request)
    {
        $checkLogin = Auth::guard('web')->check();
        if (!$checkLogin) {
            alertNotify(false, "Anda belum terdaftar", $request);
            return redirect(url('auth/register'));
        }

        $user       = Auth::guard('web')->user();
        if (!is_null($user->activated)) {
            alertNotify(false, "Akun Anda telah teraktivasi, silahkan login", $request);
            return redirect(url('dashboard'));
        }

        if ($user->activate_resend_attempt >= 5 and Carbon::parse($user->updated_at)->addMinutes('10')->toDateTimeString() > date("Y-m-d H:i:s")) {
            alertNotify(false, "Anda terlalu banyak request verifikasi kode, harap tunggu 10 menit kedepan", $request);
            return redirect()->back();
        }

        if ($user->activate_resend_attempt >= 5) {
            $user->activate_resend_attempt  = 0;
        }
        $user->activate_resend_attempt += 1;
        $user->save();

        $message        = "Kode aktivasi Anda " . $user->activate_code . " akan expired pada 60 menit. jangan dibalas by WASEND.ID";
        $this->sms->send($message, $user->phone);


        alertNotify(true, "Kode verifikasi berhasil dikirim, silahkan check sms Anda", $request);
        return redirect(url('auth/phone-verification'));
    }

    public function phoneChangeProcess(Request $request)
    {
        $checkLogin = Auth::guard('web')->check();
        if (!$checkLogin) {
            alertNotify(false, "Anda belum terdaftar", $request);
            return redirect(url('auth/register'));
        }

        $user       = Auth::guard('web')->user();
        if (!is_null($user->activated)) {
            alertNotify(false, "Akun Anda telah teraktivasi", $request);
            return redirect(url('dashboard'));
        }


        if (($user->activate_resend_attempt >= 5  or $user->activate_attempt >= 5)
            and Carbon::parse($user->updated_at)->addMinutes('10')->toDateTimeString() > date("Y-m-d H:i:s")
        ) {
            alertNotify(false, "Anda terlalu banyak request verifikasi kode, harap tunggu 10 menit kedepan", $request);
            return redirect()->back();
        }

        $phone  = $request->get('phone');

        $phoneService   = new PhoneNumberService();
        $phone          = $phoneService->standardPhone($phone);
        if (!$phone) {
            alertNotify(false, "Nomor handphone tidak valid silahkan menggunakan nomor handphone lainya", $request);
            return redirect()->back();
        }

        $checkUserExist = $this->user->findByPhone($phone);
        if ($checkUserExist and $checkUserExist->id != $user->id) {
            alertNotify(false, "Nomor handphone telah digunakan User lain, silahkan login menggunakan nomor tersebut atau menggunakan nomor handphone lainya", $request);
            return redirect()->back();
        }

        if ($user->activate_resend_attempt >= 5) {
            $user->activate_resend_attempt  = 1;
        }

        if ($user->activate_attempt >= 5) {
            $user->activate_attempt  = 1;
        }

        $user->phone            = $phone;
        $user->activate_code    = random_int(10000, 99999);
        $user->save();

        // send sms
        $message        = "Kode aktivasi Anda " . $user->activate_code . " akan expired pada 60 menit. jangan dibalas by WASEND.ID";
        $this->sms->send($message, $user->phone);

        alertNotify(true, "Nomor telah dirubah, Silahkan check sms kode verifikasi di handphone Anda", $request);
        return redirect(url('auth/phone-verification'));
    }

    public function loginOperatorForm(Request $request)
    {
        $userId = $request->get('site_id'); // user ID
        $asOperator = true;

        return view('auth.login-operator', compact('asOperator', 'userId'));
    }

    public function authenticateOperator(Request $request)
    {
        $credentials    = [
            'user'      => $request->get('user'),
            'password'  => $request->get('password')
        ];
        $loginAsOperator    = 1;
        $authenticate        = $this->user->userLogin($credentials, $loginAsOperator);
        if (!$authenticate) {
            alertNotify(false, 'Invalid email or password', $request);

            return redirect('auth/login-op' . ($loginAsOperator ? '?as_operator=1' : ''));
        }

        $user           = Auth::guard('operator')->user();

        // if login as operator
        if ($user->is_operator) {
            return redirect(url('operator'));
        }

        return redirect()->intended('operator');
    }
}
