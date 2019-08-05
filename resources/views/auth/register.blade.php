@extends('auth.auth-layout')
@section('title')
    Halaman Daftar
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
        <div class="nk-block toggled">
            {{ Form::open(['url' => url('auth/register-process'), 'autocomplete' => true]) }}
            <input type="hidden" name="utm" value="{{ $utm }}">
            <div class="nk-form">
                <h4>
                    Daftar Gratis
                </h4>
                @if(!empty($package))
                    <input type="hidden" name="package" value="{{ $package }}">
                @endif
                <div class="input-group{{ $errors->has('name') ? ' has-error' : '' }} mg-t-15">
                    <span class="input-group-addon nk-ic-st-pro">
                        <i class="fa fa-user"></i>
                    </span>
                    <div class="nk-int-st">
                        <input type="text" name="name" class="form-control" value="{{ $name ? $name : old('name') }}" placeholder="Nama Lengkap">
                    </div>
                    @if($errors->has('name'))
                        <p class="help-block">{{ $errors->first('name') }}</p>
                    @endif
                </div>
                <div class="input-group{{ $errors->has('phone') ? ' has-error' : '' }} mg-t-15">
                    <span class="input-group-addon nk-ic-st-pro">
                        <i class="notika-icon notika-phone"></i>
                    </span>
                    <div class="nk-int-st">
                        <input type="text" name="phone" class="form-control" value="{{ $phone ? $phone : old('phone') }}" placeholder="Nomor Handphone">
                    </div>
                    @if($errors->has('phone'))
                        <p class="help-block">{{ $errors->first('phone') }}</p>
                    @endif
                </div>
                <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }} mg-t-15">
                    <span class="input-group-addon nk-ic-st-pro">
                        <i class="notika-icon notika-mail"></i>
                    </span>
                    <div class="nk-int-st">
                        <input type="text" name="email" class="form-control" value="{{ $email ? $email : old('email') }}" placeholder="Alamat Email">
                    </div>
                    @if($errors->has('email'))
                        <p class="help-block">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}  mg-t-15">
                    <span class="input-group-addon nk-ic-st-pro"><i class="fa fa-key"></i></span>
                    <div class="nk-int-st">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    @if($errors->has('password'))
                        <p class="help-block">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="input-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}  mg-t-15">
                    <span class="input-group-addon nk-ic-st-pro"><i class="fa fa-key"></i></span>
                    <div class="nk-int-st">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
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
                        Daftar
                    </button>
                </div>
            </div>

            <div class="nk-navigation nk-lg-ic">
                <a href="{{ url('auth/login') }}" data-ma-block="#l-login"><i class="fa fa-user"></i> <span>Login</span></a>
                <a href="{{ url('auth/forgot-password') }}" data-ma-action="nk-login-switch" data-ma-block="#l-forget-password"><i>?</i> <span>Forgot Password</span></a>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection