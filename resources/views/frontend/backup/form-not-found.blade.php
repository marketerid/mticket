@extends('dashboard.form-layout')

@section('title')
    Form tidak ditemukan
@endsection
@section('css_top')
    <link rel="stylesheet" href="{{ url('frontend/css/themesaller-forms.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/summernote/summernote.css') }}">
    <style>
        .title{
            height: 45px;
            background-color: #00c292;
            color: white;
            text-align: center;
            padding-top: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
                @if(Session::has('alert-class'))
                    <div class="alert alert-{{ (Session::get('alert-class') == "success") ? "success" : "danger" }} alert-dismissible alert-mg-b-0" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="notika-icon notika-close"></i></span>
                        </button>
                        {{ Session::get('status') }}
                    </div>
                @endif
                <hr/>
                <h4 class="text-center">
                    Form tidak ditemukan, jika Anda admin wasend.id, silahkan check form Anda dan dapatkan link form Anda di dashboard wasend.id
                </h4>
            </div>
        </div>
    </div>
@endsection