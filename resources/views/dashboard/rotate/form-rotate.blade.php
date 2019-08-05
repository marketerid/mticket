@extends('dashboard.layout')
@section('title')
    Form WA Rotator
@endsection
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
                                    <h2>Form WA Rotator</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="pull-right">
                                <a class="btn btn-warning notika-btn-warning waves-effect" href="{{ url('dashboard/rotate') }}">
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
                <div class="wizard-wrap-int">
                    <div class="wizard-hd">
                        <h2>3 Langkah Setup Whatsapp Rotator</h2>
                    </div>
                    <div id="rootwizard">
                        <div class="navbar">
                            <div class="navbar-inner">
                                <div class="container-pro wizard-cts-st">
                                    <ul class="nav nav-pills">
                                        <li class="active">
                                            <a href="#tab1" data-toggle="tab" aria-expanded="true">1. Judul & Konfigurasi Rotator</a>
                                        </li>
                                        @if(!is_null($rotate))
                                            <li class=""><a href="{{ url('dashboard/rotate/detail-rotate/' . $rotate->id . '?wizard=1') }}">2. Tambahkan Nomor Whatsapp</a></li>
                                        @else
                                            <li class="disabled" data-toggle="tooltip" title="Anda harus klik 'Simpan dan lanjut menambah nomor Whatsapp' dibawah untuk dapat melanjutkan"><a href="#">2. Tambahkan Nomor Whatsapp</a></li>
                                        @endif
                                        <li class=""><a href="#tab3" data-toggle="tab" aria-expanded="false">3. Dapatkan Link</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                {{ Form::open(['url' => url('dashboard/rotate/save-rotate/' . (!is_null($rotate) ? $rotate->id : "")), 'autocomplete' => 'off', 'files' => true ]) }}
                <input type="hidden" name="wizard" value="{{ $wizard }}">
                <div class="form-element-list">
                    <p>
                        Dihalaman ini Anda dapat mengisi judul, template pesan dan konfigurasi Kode Tracking Facebook/Google atau anaytic dan javascript lainya
                    </p>
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
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <div class="nk-int-st">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Judul WA Rotator (cth. CS Tokoku)" value="{{ isset($rotate) ? $rotate->title : old('title') }}" required/>
                                @if($errors->has('title'))
                                    <p class="help-block">{{ $errors->first('title') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                            <div class="nk-int-st">
                                <label for="slug">Slug, Min 3 Karakter Angka dan Nomor saja (harap isi tanpa space atau karakter unik lainya)
                                    <span class="label label-info">
                                        <i class="fa fa-info" data-toggle="tooltip" title="Untuk link unique Anda, jika Anda mengisi 'slug-unik-anda' maka akan menjadi, cth: www.domain.com/slug-unik-anda"></i>
                                    </span>
                                </label>
                                <input type="text" name="slug" class="form-control" placeholder="Slug Pilihan Anda, cth: toko-laris-manis" value="{{ isset($rotate) ? $rotate->slug : old('slug') }}" required/>
                                @if($errors->has('slug'))
                                    <p class="help-block">{{ $errors->first('slug') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                            <div class="nk-int-st">
                                <label for="message">Pesan WA Template</label>
                                <p class="label label-info">Anda bisa menggunakan tag %NAMA_CS% untuk memanggil nama CS di konfigurasi nomor whatsapp di halaman selanjutnya (Sub Akun Whatsapp Rotator)</p>
                                <textarea class="form-control" name="message" placeholder="Cth: Hallo kak %NAMA_CS%, boleh saya order kurma madu nya? berapa total harga termasuk ongkir nya?" required>{{ isset($rotate) ? $rotate->message : old('message') }}</textarea>
                                @if($errors->has('message'))
                                    <p class="help-block">{{ $errors->first('message') }}</p>
                                @endif
                            </div>
                        </div>
                        <br/>
                        <br/>
                        <br/>
                        <h4>
                            Informasi Tracking FB Pixel, Google Analytic dll (Opsional, bisa dikosongkan)
                        </h4>
                        <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target="#form-collapse">
                            <i class="fa fa-folder-open-o"></i> Buka Form Informasi Tracking
                        </button>

                        <div id="form-collapse" class="collapse">
                            <div class="alert alert-danger">
                                Harap <strong>UPGRADE</strong> akun Anda untuk menggunakan fitur dibawah ini, PROMO HANYA <strong>Rp 299.000/tahun</strong>
                                <a href="{{ url('dashboard/user/upgrade') }}" class="btn btn-xs btn-success"><i class="fa fa-money"></i> Klik Disini</a>
                            </div>
                            <span class="label label-danger"></span>
                            <div class="form-group{{ $errors->has('google_analytic') ? ' has-error' : '' }}">
                                <div class="nk-int-st">
                                    <label for="google_analytic">ID Google Analytic Anda</label>
                                    <input type="text" name="google_analytic" class="form-control" placeholder="Harap masukan ID saja, cth: UA-488839938-1" value="{{ isset($rotate) ? $rotate->google_analytic : old('google_analytic') }}" disabled/>
                                    @if($errors->has('google_analytic'))
                                        <p class="help-block">{{ $errors->first('google_analytic') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('facebook_pixel_id') ? ' has-error' : '' }}">
                                <div class="nk-int-st">
                                    <label for="facebook_pixel_id">Facebook Pixel ID Anda</label>
                                    <input type="text" name="facebook_pixel_id" class="form-control" placeholder="Harap masukan ID saja, cth: 18271821721827154" value="{{ isset($rotate) ? $rotate->facebook_pixel_id : old('facebook_pixel_id') }}" disabled/>
                                    @if($errors->has('facebook_pixel_id'))
                                        <p class="help-block">{{ $errors->first('facebook_pixel_id') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('facebook_pixel_event') ? ' has-error' : '' }}">
                                <div class="nk-int-st">
                                    <label for="facebook_pixel_event">Facebook Pixel Track Anda</label>
                                    <input type="text" name="facebook_pixel_event" class="form-control" placeholder="Harap masukan value dari Track nya saja, cth: PageView" value="{{ isset($rotate) ? $rotate->facebook_pixel_event : old('facebook_pixel_event') }}" disabled/>
                                    @if($errors->has('facebook_pixel_event'))
                                        <p class="help-block">{{ $errors->first('facebook_pixel_event') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('javascript') ? ' has-error' : '' }}">
                                <div class="nk-int-st">
                                    <label for="javascript">Custom Javascript (Google Tag Manager atau Script Lainya)</label>
                                    <textarea class="form-control" name="javascript" placeholder="Harap masukan Lengkap termasuk Tag, cth: <sciprt>var myVariable = 'value';</script>, Anda bisa memasukan Google Tag Manager Anda disini" disabled>{{ isset($rotate) ? $rotate->javascript : old('javascript') }}</textarea>
                                    @if($errors->has('javascript'))
                                        <p class="help-block">{{ $errors->first('javascript') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br/>
                        <br/>
                        <br/>
                        <div class="form-group">
                            <a href="{{ url('dashboard/rotate') }}" class="btn btn-default waves-effect">
                                <i class="fa fa-backward"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success notika-btn-success waves-effect">
                                <i class="fa fa-save"></i> {{ !is_null($rotate) ? "Save" : "Simpan dan lanjut menambah nomor Whatsapp" }}
                            </button>
                        </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection