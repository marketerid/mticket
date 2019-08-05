<?php

namespace App\User;

use App\Form\FormRepository;
use App\MailJet\MailJetService;
use App\SmsGateway\ZenzivaService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mpdf\Tag\P;

class UserRepository{

    public function userLogin($credentials, $loginAsOperator = 0){
        if($loginAsOperator){
            $user   = $this->findOperatorByEmail($credentials['user']);
            if(!$user){
                $user   = $this->findOperatorByPhone($credentials['user']);
            }

            if($user){
                $credentials['email']   = $user->email;
                unset($credentials['user']);
                if (Auth::guard('operator')->attempt($credentials)) {
                    // Authentication passed...
                    return true;
                }
            }

            return false;
        }


        $user  = $this->findByEmail($credentials['user']);
        if(!$user){
            $user   = $this->findByPhone($credentials['user']);
        }

        if(!$user){
            return false;
        }
        $credentials['email']   = $user->email;
        unset($credentials['user']);

        if (Auth::guard('web')->attempt($credentials)) {
            // Authentication passed...
            return true;
        }

        return false;
    }

    public function findOperatorByEmail($email){
        return Operator::with([])
            ->where('email', $email)
            ->first();
    }

    public function findOperatorByPhone($phone = ''){
        $phoneValid     = new PhoneNumberService();
        $phone          = $phoneValid->standardPhone($phone);

        return Operator::with([])->where('phone',$phone)->first();
    }

    public function findByEmail($email){
        return User::with([])
            ->where('email', $email)
            ->first();
    }

    public function generateTokenForgotPassword($user){
        $resets = new PasswordResets();
        $resets->phone  = $user->phone;
        $resets->token  = random_int(10000,99999);
        $resets->save();

        return $resets->token;
    }

    public function createUpdate($input){
        $phoneValid     = new PhoneNumberService();

        $phone  = $phoneValid->standardPhone($input->phone);
        $user   = $this->findByPhone($phone);
        if(!$user){
            $user   = new User();
            $user->remember_token   = $this->_generateToken();
            $user->password         = '';
        }

        $user->phone    = $phone;
        $user->name     = $input->full_name;
        $user->save();

        return $user;
    }

    public function createUpdateToken($user, $input){
        if(!$user OR empty($input->device_id) OR empty($input->device_hardware)){
            return false;
        }

        $token  = $this->findToken($input->device_id, $input->device_hardware);
        if(!$token){
            return $this->createToken($user, $input->device_id, $input->device_hardware);
        }else{
            $token->updated_at  = date("Y-m-d H:i:s");
            $token->save();

            return $token;
        }
    }

    public function createToken($user, $deviceId, $deviceHW){
        $token  = new Token();
        $token->user_id             = $user->id;
        $token->device_id           = $deviceId;
        $token->device_hardware     = $deviceHW;
        $token->remember_token      = $user->remember_token;
        $token->save();

        return $token;
    }

    public function findToken($deviceId, $deviceHW){
        return Token::with([])->where('device_id', $deviceId)->where('device_hardware', $deviceHW)->first();
    }

    public function findByPhone($phone = ''){
        $phoneValid     = new PhoneNumberService();
        $phone          = $phoneValid->standardPhone($phone);

        return User::with([])->where('phone',$phone)->first();
    }

    public function findByToken($token = ''){
        return User::with([])->where('remember_token',$token)->first();
    }

    private function _generateToken($length = 18){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function createPhoneValidation($user){
        $user->activate_code    = rand(10000,99999);
        $user->activate_code_expired    = date("Y-m-d H:i:s",strtotime('+3 hours'));
        $user->save();

        return $user;
    }

    public function activateUser($user){
        $user->activated    = date("Y-m-d H:i:s");
        $user->save();

        return $user;
    }

    public function getOperator($filters = [], $paginate = 25){
        $users  = Operator::with([]);

        if(!empty($filters['user_id'])){
            $users->where('user_id', $filters['user_id']);
        }

        if(!empty($filters['ids'])){
            $users->whereIn('id', $filters['ids']);
        }

        if(!empty($filters['name'])){
            $users->where('name','like', $filters['name']);
        }

        if(!empty($filters['phone'])){
            $phoneValid     = new PhoneNumberService();

            $phone  = $phoneValid->standardPhone($filters['phone']);
            $users->where('phone','like', $phone);
        }

        $users->orderBy('id','desc');

        if($paginate){
            return $users->paginate($paginate);
        }

        return $users->get();
    }

    public function get($filters = []){
        $users  = User::with([]);

        if(!empty($filters['name'])){
            $users->where('name','like', $filters['name']);
        }

        if(!empty($filters['phone'])){
            $phoneValid     = new PhoneNumberService();

            $phone  = $phoneValid->standardPhone($filters['phone']);
            $users->where('phone','like', $phone);
        }

        return $users->orderBy('id','desc')->paginate(25);
    }

    public function getUserAjax($query){
        return User::with([])->where(function ($q)use($query){
            $q->where('name', 'like', '%'. $query .'%')
                ->orWhere('phone','like','%'. $query .'%');
        })->get();
    }

    public function findOperator($id){
        return Operator::with(['user'])->find($id);
    }

    public function find($id){
        return User::with(['orders.package','active_order.package','operators'])->find($id);
    }

    public function save($id = null, $inputs = []){
        $user   = $this->find($id);
        if(!$user){
            return false;
        }

        $phone          = new PhoneNumberService();
        $user->name     = $inputs['name'];
        $user->email    = $inputs['email'];
        $user->phone    = $phone->standardPhone($inputs['phone']);
        $user->save();

        return $user;
    }

    public function findOperatorByEmailAndUserId($email, $userId){
        return Operator::with([])->where('email', $email)->where('user_id', $userId)->first();
    }

    public function saveOperator($id = null, $inputs = [], $user){
        $operator   = $this->findOperator($id);
        if(!$operator){
            if($user->is_operator){
                return false;
            }

            $operator   = new Operator();
        }

        $phone          = new PhoneNumberService();
        $operator->name     = $inputs['name'];
        $operator->email    = $inputs['email'];
        $operator->remember_token   = '';
        $operator->phone    = $phone->standardPhone($inputs['phone']) ? $phone->standardPhone($inputs['phone']) : '';
        $operator->user_id  = !is_null($operator->user_id) ? $operator->user_id : $user->id;

        if(!empty($inputs['password'])){
            $operator->password   = bcrypt($inputs['password']);
        }
        $operator->save();

        $pass       = !empty($inputs['password']) ? $inputs['password'] : '1234';
        $passText   = ($pass) ? ' pass: ' . $pass : '';
        $sms        = new ZenzivaService();
        $mail       = new MailJetService();

        $isUpdate   = (boolean)$id;
        // send notification
        $message    = "Operator telah " . ($isUpdate ? "Diupdate" : "Ditambahkan") . ' dengan nama ' . $operator->name . ', Anda dapat login sbg Operator di ' . url('auth/login-op') . $passText;
        if($id){
            $sms->send($message, $user->phone);
        }else{
            $sms->send($message, $user->phone);
            $sms->send($message, $operator->phone);
        }
        $mail->send($user->email, $user->name, "Operator " . ($isUpdate ? "Diupdate" : "Ditambahkan") . " bernama " . $operator->name . " WASEND.ID", $message);

        return $operator;
    }

    public function savePasswordOperator($id = null, $inputs = []){
        $user   = $this->findOperator($id);
        if(!$user){
            return [
                'status'    => false,
                'message'   => 'User tidak ditemukan'
            ];
        }

        $check          = Hash::check($inputs['password'], $user->password);
        if(!$check){
            return [
                'status'    => false,
                'message'   => "Password lama salah, harap periksa lagi"
            ];
        }

        $user->password = bcrypt($inputs['password_new']);
        $user->save();

        return [
            'status'    => true,
            'message'   => 'Password berhasil diganti'
        ];
    }

    public function savePassword($id = null, $inputs = []){
        $user   = $this->find($id);
        if(!$user){
            return [
                'status'    => false,
                'message'   => 'User tidak ditemukan'
            ];
        }

        $check          = Hash::check($inputs['password'], $user->password);
        if(!$check){
            return [
                'status'    => false,
                'message'   => "Password lama salah, harap periksa lagi"
            ];
        }

        $user->password = bcrypt($inputs['password_new']);
        $user->save();

        return [
            'status'    => true,
            'message'   => 'Password berhasil diganti'
        ];
    }

    public function updateNote($userId, $note){
        $user   = $this->find($userId);
        if(!$user){
            return false;
        }

        $user->admin_note   = $note;
        $user->save();

        return $user;
    }

    public function getNotification($filters = [], $paginate = 25){
        $data   = Notification::with([]);
        if(!empty($filters['user_id'])){
            $data->where('user_id', $filters['user_id']);
        }

        if(isset($filters['read_at'])){
            $data->where('read_at', $filters['read_at']);
        }

        $data->orderBy('id','desc');
        if($paginate){
            return $data->paginate($paginate);
        }

        return $data->get();
    }

    public function findNotification($id = null){
        return Notification::with([])->find($id);
    }

    public function readNotification($id){
        $data   = $this->findNotification($id);
        if(!$data OR !is_null($data->read_at)){
            return false;
        }

        $data->read_at  = date("Y-m-d H:i:s");
        $data->save();

        return true;
    }

    public function register($name, $phone, $email, $password, $utm = ''){
        $user   = $this->findByEmail($email);
        if($user){
            return [
                'status'    => false,
                'message'   => "Email telah terdaftar sebelumnya, silahkan coba login dengan Akun Anda atau coba email lainya"
            ];
        }

        $phoneValid     = new PhoneNumberService();
        $phone          = $phoneValid->standardPhone($phone);
        if(!$phone){
            return [
                'status'    => false,
                'message'   => "Nomor handphone tidak benar, harap tulis nomor hp dengan benar atau gunakan nomor hp lainya"
            ];
        }

        $user   = $this->findByPhone($phone);
        if($user){
            return [
                'status'    => false,
                'message'   => "Nomor handphone telah terdaftar sebelumnya, silahkan coba login dengan Akun Anda atau coba no hp lainya"
            ];
        }

        $user   = new User();
        $user->name     = $name;
        $user->phone    = $phone;
        $user->email    = $email;
        $user->password = bcrypt($password);
        $user->utm      = ($utm) ? $utm : '';
        $user->activate_code    = random_int(10000,99999);
        $user->save();

        return [
            'status'    => true,
            'message'   => "Pendaftaran berhasil, harap check sms masuk untuk verifikasi",
            'data'      => $user
        ];
    }

    public function activatePhone($activateCode = '', $user){
        if($user->activate_attempt >= 5 AND Carbon::parse($user->updated_at)->addMinutes('10')->toDateTimeString() > date("Y-m-d H:i:s")){
            return [
                'status'    => false,
                'message'   => 'Anda telah salah 5 kali memasukan verifikasi sms, harap coba 10 menit lagi'
            ];
        }

        if($user->activate_code != $activateCode){

            if($user->activate_attempt >= 5){
                $user->activate_attempt  = 0;
            }
            $user->activate_attempt += 1;
            $user->save();

            return [
                'status'    => false,
                'message'   => 'Kode verifikasi sms Anda salah, harap check kembali'
            ];
        }

        $user->activated    = date("Y-m-d H:i:s");
        $user->save();


        return [
            'status'    => true,
            'message'   => 'Kode verifikasi sukses!'
        ];
    }

    public function validateUserByToken($userId, $token = ''){
        $user   = $this->find($userId);
        if(!$user){
            return [
                'status'    => false,
                'message'   => 'user tidak ditemukan, harap coba 10 menit lagi'
            ];
        }

        if($user->activate_attempt >= 5 AND Carbon::parse($user->updated_at)->addMinutes('10')->toDateTimeString() > date("Y-m-d H:i:s")){
            return [
                'status'    => false,
                'message'   => 'Anda telah salah 5 kali memasukan verifikasi sms, harap coba 10 menit lagi'
            ];
        }


        $hasToken   = PasswordResets::with([])
            //->where('token', $token)
            ->where('phone', $user->phone)
            ->orderBy('created_at','desc')
            ->limit(1)
            ->get();

        if(!$hasToken->count() OR $hasToken[0]->token != $token){
            if($user->activate_attempt >= 5){
                $user->activate_attempt  = 0;
            }
            $user->activate_attempt += 1;
            $user->save();

            return [
                'status'    => false,
                'message'   => 'Kode verifikasi sms Anda salah, harap check kembali'
            ];
        }

        return [
            'status'    => true,
            'message'   => 'Token verhasil diverifikasi, silahkan masukan password baru Anda'
        ];
    }

    public function validateResendAttempt($userId){
        $user   = $this->find($userId);

        if($user->activate_resend_attempt >= 5 AND Carbon::parse($user->updated_at)->addMinutes('10')->toDateTimeString() > date("Y-m-d H:i:s")){
            return [
                'status'    => false,
                'message'   => "Anda terlalu banyak request verifikasi kode, harap tunggu 10 menit kedepan"
            ];
        }

        if($user->activate_resend_attempt >= 5){
            $user->activate_resend_attempt  = 0;
        }
        $user->activate_resend_attempt += 1;
        $user->save();
        return [
            'status'    => true,
            'message'   => ""
        ];
    }

    public function changePassword($userId, $newPass){
        $user   = $this->find($userId);
        $user->password     = bcrypt($newPass);
        $user->save();

        return $user;
    }

    public function deleteOp($id = null){
        $operator   = $this->findOperator($id);
        if(!$operator){
            return [
                'status'    => false,
                'message'   => 'Operator tidak ditemukan'
            ];
        }

        $filters['user_id'] = $operator->user_id;
        $operatorAll    = $this->getOperator($filters);
        if($operatorAll->count() <= 1){
            return [
                'status'    => false,
                'message'   => 'Anda harus memiliki setidaknya 1 operator, Anda tidak dapat menghapus 1 operator terakhir Anda'
            ];
        }

        $form                           = new FormRepository();
        $rotateFilters['operator_id']   = $operator->id;
        $rotateOperators                = $form->getFormRotates($rotateFilters);

        foreach ($rotateOperators as $rotateOperator){
            $rotateOperator->delete();
        }

        $operator->delete();

        return [
            'status'    => true,
            'message'   => "Sukses dihapus"
        ];
    }
}