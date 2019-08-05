@extends('auth.auth-layout')

@section('title')
    Set Ulang Kata Sandi
@endsection
@section('js')
    <script>
        (function ($) {
            "use strict";
        })(jQuery);
    </script>
@endsection
@section('content')
    <div class="login-content">
        @if(Session::has('alert-class'))
            <a class="notification-alert" data-type="{{ (Session::get('alert-class') == "success") ? "success" : "danger" }}" data-from="top" data-align="center" data-title="" data-message="{{ Session::get('status') }}">
            </a>
        @endif
        <!-- Login -->
        <div class="nk-block {{ (empty($page) OR (!empty($page) AND $page == 'login')) ? 'toggled' : '' }}" id="l-verification">
            {{ Form::open(['url' => url('auth/change-password-process'), 'autocomplete' => true]) }}
            <div class="nk-form">
                <p>
                    Anda berhasil memvalidasi kode, silahkan masukan password baru Anda
                </p>
                <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }} mg-t-15">
                    <span class="input-group-addon nk-ic-st-pro">
                        <i class="fa fa-key"></i>
                    </span>
                    <div class="nk-int-st">
                        <input type="password" name="password" class="form-control" value="" placeholder="Password Baru" required>
                    </div>
                    @if($errors->has('password'))
                        <p class="help-block">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="input-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} mg-t-15">
                    <span class="input-group-addon nk-ic-st-pro">
                        <i class="fa fa-key"></i>
                    </span>
                    <div class="nk-int-st">
                        <input type="password" name="password_confirmation" class="form-control" value="" placeholder="Ulangi Password Baru (Konfirmasi)" required>
                    </div>
                    @if($errors->has('password_confirmation'))
                        <p class="help-block">{{ $errors->first('password_confirmation') }}</p>
                    @endif
                </div>
                <br/>
                <br/>
                <div class="input-group mg-t-15">
                    <button type="submit" class="btn btn-login btn-success">
                        <i class="fa fa-check"></i>
                        Kirim
                    </button>
                </div>
            </div>

            <div class="nk-navigation nk-lg-ic">
                <a href="{{ url('auth/login') }}" data-ma-block="#l-register"><i class="fa fa-user"></i> <span>Login</span></a>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection