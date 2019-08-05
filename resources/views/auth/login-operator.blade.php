@extends('auth.auth-layout')
@section('title')
    Halaman Login Operator
@endsection
@section('content')
    <div class="login-content">
        @if(Session::has('alert-class'))
            <a class="notification-alert" data-type="{{ (Session::get('alert-class') == "success") ? "success" : "danger" }}" data-from="top" data-align="center" data-title="" data-message="{{ Session::get('status') }}">
            </a>
        @endif
        <!-- Login -->
        <div class="nk-block toggled" id="l-login">
            {{ Form::open(['url' => url('auth/login-op/authenticate'), 'autocomplete' => true]) }}
            <input type="hidden" name="as_operator" value="{{ $asOperator }}">
            <div class="nk-form">
                <h5>
                    Login Operator
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

                    <a href="{{ url('auth/login') }}" class="btn btn-login btn-primary btn-sm"><i class="fa fa-user"></i> <span>Login Admin</span></a>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection