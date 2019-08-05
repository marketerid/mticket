@extends('dashboard.form-layout')

@section('title')
    {{ isset($form) ? $form->title : '' }}
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
        .content-form{
            overflow: auto;
        }
    </style>
@endsection
@section('js')
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
    <script src="{{ asset('frontend/js/dashboard/form-generator.js') }}"></script>
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
                {{ Form::open(['url' => url('form/submit/' . (!is_null($form) ? $form->slug : "")), 'method' => 'POST','autocomplete' => true]) }}
                    <input type="hidden" name="campaign" value="{{ $campaign }}">
                    <div class="title">
                        <h4>
                            {{ $form->title }}
                        </h4>
                    </div>
                    <div class="normal-table-list">
                        <div class="content-form">
                            {!! $form->description !!}
                        </div>
                        <br/>
                        <div class="content-form">
                            <input type="hidden" id="generator" value="{{ $form->generator }}">
                            <div id="editor-render"></div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection