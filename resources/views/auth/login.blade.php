@extends('auth.auth-layout')
@section('title')
    Halaman Login
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
        <div class="nk-block {{ (!empty($page) AND $page == 'login') ? 'toggled' : '' }}" id="l-login">
            {{ Form::open(['url' => url('auth/login-process'), 'autocomplete' => true]) }}
            <input type="hidden" name="as_operator" value="{{ $asOperator }}">
            <div class="nk-form">
                <h5>
                    Login as Admin
                </h5>
                <div class="input-group{{ $errors->has('user') ? ' has-error' : '' }} mg-t-15">
                    <span class="input-group-addon nk-ic-st-pro">
                        <i class="fa fa-user"></i>
                    </span>
                    <div class="nk-int-st">
                        <input type="text" name="user" class="form-control" value="{{ old('user') }}" placeholder="Email/Nomor HP">
                    </div>
                    @if($errors->has('user'))
                        <p class="help-block">{{ $errors->first('user') }}</p>
                    @endif
                </div>
                <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}  mg-t-15">
                    <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-edit"></i></span>
                    <div class="nk-int-st">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    @if($errors->has('password'))
                        <p class="help-block">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <br/>
                <br/>
                <div class="input-group mg-t-15">
                    <button type="submit" class="btn btn-login btn-success">
                        <i class="fa fa-check"></i>
                        Masuk
                    </button>
                </div>
            </div>

            <div class="nk-navigation nk-lg-ic">
                <a href="{{ url('auth/register') }}" data-ma-block="#l-register"><i class="notika-icon notika-plus-symbol"></i> <span>Register</span></a>
                <a href="#" data-ma-action="nk-login-switch" data-ma-block="#l-forget-password"><i>?</i> <span>Forgot Password</span></a>
                <a href="{{ url('auth/login-op') }}" data-ma-block="#l-register"><i class="fa fa-users"></i> <span>Operator</span></a>
            </div>
            {{ Form::close() }}
        </div>

        <!-- Forgot Password -->
        <div class="nk-block {{ (!empty($page) AND $page == 'forgot') ? 'toggled' : '' }}" id="l-forget-password">
            {{ Form::open(['url' => url('auth/forgot-password-process'), 'autocomplete' => true]) }}
            <div class="nk-form">
                <p class="text-left">
                    Silahkan masukan email Anda untuk mengirim konfirmasi perubahan password
                </p>

                <div class="input-group{{ $errors->has('phone') ? ' has-error' : '' }} ">
                    <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-phone"></i></span>
                    <div class="nk-int-st">
                        <input type="text" name="phone" class="form-control" placeholder="Nomor Handphone">
                        @if($errors->has('phone'))
                            <p class="help-block">{{ $errors->first('phone') }}</p>
                        @endif
                    </div>
                </div>
                <br/>
                <br/>
                <div class="input-group mg-t-15">
                    <button type="submit" class="btn btn-login btn-success">
                        <i class="fa fa-mail-forward"></i>
                        Kirim Kode Lupa Sandi
                    </button>
                </div>
            </div>

            <div class="nk-navigation nk-lg-ic rg-ic-stl">
                <a href="{{ url('auth/register') }}" data-ma-block="#l-register"><i class="notika-icon notika-plus-symbol"></i> <span>Register</span></a>
                <a href="#" data-ma-action="nk-login-switch" data-ma-block="#l-login"><i class="notika-icon notika-right-arrow"></i> <span>Sign in</span></a>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection