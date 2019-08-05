@extends('auth.auth-layout')

@section('title')
    Verifikasi Kode Lupas Sandi
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
            {{ Form::open(['url' => url('auth/token-password-process'), 'autocomplete' => true]) }}
            <div class="nk-form">
                <p>
                    Kode verifikasi lupa sandi sms telah dikirim ke <b>{{ $user->phone }}</b>
                </p>
                <div class="input-group{{ $errors->has('token') ? ' has-error' : '' }} mg-t-15">
                    <span class="input-group-addon nk-ic-st-pro">
                        <i class="fa fa-code"></i>
                    </span>
                    <div class="nk-int-st">
                        <input type="text" name="token" class="form-control" value="{{ old('token') }}" placeholder="Kode verifikasi sms" required>
                    </div>
                    @if($errors->has('token'))
                        <p class="help-block">{{ $errors->first('token') }}</p>
                    @endif
                </div>
                <br/>
                <br/>
                <div class="input-group mg-t-15">
                    <button type="submit" class="btn btn-login btn-success">
                        <i class="fa fa-check"></i>
                        Verifikasi
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