@extends('auth.auth-layout')

@section('title')
    Verifikasi nomor handphone
@endsection
@section('js')
    <script>
        (function ($) {
            "use strict";

            $("body").on("click", "[data-ma-action]", function(e) {
                e.preventDefault();
                var $this = $(this),
                    action = $(this).data("ma-action");
                switch (action) {
                    case "nk-login-switch":
                        var loginblock = $this.data("ma-block"),
                            loginParent = $this.closest(".nk-block");
                        loginParent.removeClass("toggled"), setTimeout(function() {
                            $(loginblock).addClass("toggled")
                        });
                        break;
                    case "print":
                        window.print();
                        break;
                }
            });
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
            {{ Form::open(['url' => url('auth/phone-verification-process'), 'autocomplete' => true]) }}
            <div class="nk-form">
                <p>
                    Kode verifikasi sms telah dikirim ke <b>{{ $user->phone }}</b>, ganti nomor? <a href="#" data-ma-action="nk-login-switch" data-ma-block="#l-change-phone">Klik Disini</a>
                </p>
                <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }} mg-t-15">
                    <span class="input-group-addon nk-ic-st-pro">
                        <i class="fa fa-code"></i>
                    </span>
                    <div class="nk-int-st">
                        <input type="text" name="activate_code" class="form-control" value="{{ old('activate_code') }}" placeholder="Kode verifikasi sms" required>
                    </div>
                    @if($errors->has('activate_code'))
                        <p class="help-block">{{ $errors->first('activate_code') }}</p>
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
                <a href="{{ url('auth/resend-verification-process') }}" data-ma-block="#l-register"><i class="fa fa-phone"></i> <span>Kirim Kode</span></a>
                <a href="{{ url('auth/logout') }}" data-ma-block="#l-register"><i class="fa fa-close"></i> <span>Logout</span></a>
                <a href="#" data-ma-action="nk-login-switch" data-ma-block="#l-change-phone"><i class="fa fa-mobile-phone"></i> <span>Ganti Nomor</span></a>
            </div>
            {{ Form::close() }}
        </div>

        <!-- Forgot Password -->
        <div class="nk-block {{ (!empty($page) AND $page == 'change-phone') ? 'toggled' : '' }}" id="l-change-phone">
            {{ Form::open(['url' => url('auth/phone-change-process'), 'autocomplete' => true]) }}
            <div class="nk-form">
                <p class="text-left">
                    Silahkan masukan <b>nomor handphone terbaru</b> Anda untuk dikirim kode verifikasi, atau jika ingin membatalkan dan kembali ke input kode verifikasi, <a href="#" data-ma-action="nk-login-switch" data-ma-block="#l-verification">Klik Disini</a>
                </p>

                <div class="input-group{{ $errors->has('phone') ? ' has-error' : '' }} ">
                    <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-phone"></i></span>
                    <div class="nk-int-st">
                        <input type="text" name="phone" class="form-control" placeholder="Nomor Handphone" required>
                        @if($errors->has('phone'))
                            <p class="help-block">{{ $errors->first('phone') }}</p>
                        @endif
                    </div>
                </div>
                <br/>
                <br/>
                <div class="input-group mg-t-15">
                    <button type="submit" class="btn btn-login btn-success">
                        <i class="fa fa-check"></i>
                        Ganti Nomor HP
                    </button>
                </div>
            </div>


            <div class="nk-navigation nk-lg-ic">
                <a href="{{ url('auth/resend-verification-process') }}" data-ma-block="#l-register"><i class="fa fa-phone"></i> <span>Kirim Kode</span></a>
                <a href="{{ url('auth/logout') }}" data-ma-block="#l-register"><i class="fa fa-reply"></i> <span>Logout</span></a>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection