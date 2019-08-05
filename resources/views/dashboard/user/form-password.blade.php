@extends('dashboard.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcomb-list">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <div class="breadcomb-wp">
                                <div class="breadcomb-icon">
                                    <i class="notika-icon notika-windows"></i>
                                </div>
                                <div class="breadcomb-ctn">
                                    <h2>Form Password</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="pull-right">
                                <a class="btn btn-warning notika-btn-warning waves-effect" href="{{ url('dashboard/user') }}">
                                    <i class="fa fa-backward"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                {{ Form::open(['url' => url('dashboard/user/save-password/') ]) }}
                <div class="form-element-list">
                    @if(Session::has('alert-class'))
                        <div class="alert-list">
                            <div class="alert alert-{{ (Session::get('alert-class') == "success") ? "success" : "danger" }} alert-dismissible alert-mg-b-0" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="notika-icon notika-close"></i></span>
                                </button>
                                {{ Session::get('status') }}
                            </div>
                        </div>
                    @endif
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="nk-int-st">
                                <label for="name">Password Saat Ini</label>
                                <input type="password" name="password" class="form-control" placeholder="Password saat ini" value="" required>
                                @if($errors->has('password'))
                                    <p class="help-block">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password_new') ? ' has-error' : '' }}">
                            <div class="nk-int-st">
                                <label for="password_new">Password Baru</label>
                                <input type="password" name="password_new" class="form-control" placeholder="Password Baru" value="" required>
                                @if($errors->has('password_new'))
                                    <p class="help-block">{{ $errors->first('password_new') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password_new_confirmation') ? ' has-error' : '' }}">
                            <div class="nk-int-st">
                                <label for="password_new_confirmation">Password Baru lagi</label>
                                <input type="password" name="password_new_confirmation" class="form-control" placeholder="Password Baru Lagi" value="" required>
                                @if($errors->has('password_new_confirmation'))
                                    <p class="help-block">{{ $errors->first('password_new_confirmation') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <a href="{{ url('dashboard/user') }}" class="btn btn-default waves-effect">
                                <i class="fa fa-backward"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success notika-btn-success waves-effect">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection