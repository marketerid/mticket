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
                                    <h2>Form Profile</h2>
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
                {{ Form::open(['url' => url('dashboard/user/save-profile/') ]) }}
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
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="nk-int-st">
                                <label for="name">Nama</label>
                                <input type="text" name="name" class="form-control" placeholder="Nama Anda" value="{{ isset($user) ? $user->name : old('name') }}" required>
                                @if($errors->has('name'))
                                    <p class="help-block">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="nk-int-st">
                                <label for="email">Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Email Anda" value="{{ isset($user) ? $user->email : old('email') }}" required>
                                @if($errors->has('email'))
                                    <p class="help-block">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <div class="nk-int-st">
                                <label for="phone">No HP (sementara tidak dapat dirubah)</label>
                                <input type="text" name="phone" class="form-control" placeholder="No HP" value="{{ isset($user) ? $user->phone : old('phone') }}" disabled>
                                @if($errors->has('phone'))
                                    <p class="help-block">{{ $errors->first('phone') }}</p>
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