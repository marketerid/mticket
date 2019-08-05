@extends('dashboard.layout')
@section('title')
    Detail WA Rotator {{ isset($rotate) ? $rotate->title : '' }}
@endsection
@section('css_top')
    <link rel="stylesheet" href="{{ url('frontend/css/themesaller-forms.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-tour/build/css/bootstrap-tour.css') }}">
    <style>
        .disabled{
            pointer-events:none;
        }
    </style>
@endsection
@section('js')
    <script src="{{ url('frontend/js/rangle-slider/jquery-ui-1.10.4.custom.min.js') }}"></script>
    <script src="{{ url('frontend/js/rangle-slider/jquery-ui-touch-puch.min.js') }}"></script>

    <script src="{{ asset('bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js') }}"></script>
    <script src="{{ url('frontend/js/jquery-price-slider.js') }}"></script>
    <script src="{{ asset('frontend/js/dashboard/form-rotator.js') }}"></script>
    <script>
        @if((!$rotate->subs->count() OR $wizard == 1) AND (!Session::has('alert-class') AND Session::has('alert-class') != 'danger'))
            var tour = new Tour({
                steps: [
                    {
                        element: "#open-modal-sub",
                        title: "Tambahkan Nomor CS Pertama Anda",
                        content: "Anda dapat menambahkan nomor CS Whatsapp pertama Anda dengan klik tombol ini",
                        backdrop: true,
                        backdropContainer: 'body',
                        smartPlacement: true,
                    },
                    {
                        element: "#open-modal-generate-btn",
                        title: "Dapatkan link untuk mulai menggunakan Whatsapp Rotator",
                        content: "Setelah menambahkan paling tidak 1 nomor CS, Anda dapat klik tombol ini untuk mendapatkan link whatsapp rotator",
                        backdrop: true,
                        backdropContainer: 'body',
                        smartPlacement: true,
                    },
                    {
                        element: "#log-rotator",
                        title: "Log Whatsapp Rotator",
                        content: "Setelah Anda mulai menyebarkan Link WA Rotator, Anda dapat memantau aktifitas secara realtime di menu Log ini",
                        backdrop: true,
                        backdropContainer: 'body',
                        smartPlacement: true,
                    }
                ]
            });

            tour.init();
            tour.start(true);
        @endif

        @if($openTourRotate)
            var tour = new Tour({
                steps: [
                        {
                            element: "#shift-sub-first",
                            title: "Tambahkan Jadwal/Shift",
                            content: "Anda dapat menambahkan Jadwal tampil/shift untuk CS Anda dengan menekan tombol ini",
                            storage: window.localStorage,
                            backdrop: true,
                            backdropContainer: 'body',
                            smartPlacement: true
                        }
                    ]
                });

            tour.init();
            tour.start(true);
        @endif
    </script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            @if($wizard == 1)
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
                                            <li class="">
                                                <a href="{{ url('dashboard/rotate/form-rotate/'. $rotate->id .'?wizard=1') }}">1. Judul & Konfigurasi Rotator</a>
                                            </li>
                                            <li class="active"><a href="#tab1" data-toggle="tab" aria-expanded="true">2. Tambahkan Nomor Whatsapp</a></li>

                                            @if($rotate->subs->count())
                                                <li class=""><a href="#" class="open-modal-generate" data-toggle="tab" aria-expanded="true">3. Dapatkan Link</a></li>
                                            @else
                                                <li class="" data-toggle="tooltip" title="Anda harus 'Tambah Nomor' whatsapp Anda dahulu untuk bisa mendapatkan Link">
                                                    <a href="#disabled">3. Dapatkan Link</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcomb-list">
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
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="breadcomb-wp">
                                <div class="breadcomb-icon">
                                    <i class="notika-icon notika-windows"></i>
                                </div>
                                <div class="breadcomb-ctn">
                                    <h2>Detail Whatsapp Rotator Anda</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="pull-right">
                                <button type="button" id="open-modal-generate-btn" class="open-modal-generate btn btn-sm btn-success notika-btn-success waves-effect">
                                    <i class="fa fa-gears"></i> Generate Link
                                </button>
                                <a id="log-rotator" class="btn btn-sm btn-info notika-btn-info waves-effect" href="{{ url('dashboard/rotate/log') }}">
                                    <i class="fa fa-pencil"></i> Logs
                                </a>
                                <a id="edit-rotator" class="btn btn-sm btn-warning notika-btn-warning waves-effect" href="{{ url('dashboard/rotate/form-rotate/' . $rotate->id) }}">
                                    <i class="fa fa-pencil"></i> Edit Rotator
                                </a>
                                <a class="btn btn-sm btn-default notika-btn-default waves-effect" href="{{ url('dashboard/rotate') }}">
                                    <i class="fa fa-backward"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="normal-table-list">
                    <div class="bsc-tbl">
                        <table class="table table-cl table-striped">
                            <tbody>
                            <tr>
                                <td>Title</td>
                                <td>{{ $rotate->title }}</td>
                            </tr>
                            <tr>
                                <td>Slug</td>
                                <td>{{ $rotate->slug }}</td>
                            </tr>
                            <tr>
                                <td>Template Pesan</td>
                                <td>{{ $rotate->message }}</td>
                            </tr>
                            <tr>
                                <td>Google Analytic</td>
                                <td>{{ $rotate->google_analytic }}</td>
                            </tr>
                            <tr>
                                <td>Facebook Pixel ID</td>
                                <td>{{ $rotate->facebook_pixel_id }}</td>
                            </tr>
                            <tr>
                                <td>Facebook Pixel Event</td>
                                <td>{{ $rotate->facebook_pixel_event }}</td>
                            </tr>
                            <tr>
                                <td>Javascript</td>
                                <td>{{ $rotate->javascript }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <br/>

                    <p>
                        Link Share Whatsapp Rotator
                    </p>
                    <input id="share-link" type="text" value="{{ $rotate->link_share }}" class="form-control" readonly>
                    <button id="copy-link" type="button" class="btn btn-xs btn-primary"><i class="fa fa-copy"></i> Copy Link</button>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="normal-table-list">
                    <h4>
                        List Nomor Whatsapp untuk di Rotasi
                        <button type="button" class="btn btn-xs btn-primary pull-right" id="open-modal-sub">
                            <i class="fa fa-plus"></i> Tambah Nomor
                        </button>
                    </h4>
                    <div class="bsc-tbl">
                        <table class="table table-sc-ex table-striped">
                            <thead>
                            <tr>
                                <th>
                                    No HP /
                                    <br/>
                                    Nama CS
                                </th>
                                <th>Persentase</th>
                                <th>
                                    Primary
                                    <i class="fa fa-info" data-toggle="tooltip" title="Jika primary, akan menjadi nomor utama jika algoritma random tidak ditemukan"></i>
                                </th>
                                <th>Active</th>
                                <th>Jadwal Shift</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rotate->subs as $sub)
                                <tr>
                                    <td>
                                        {{ $sub->phone }}
                                        <br/>
                                        {{ $sub->name }}
                                    </td>
                                    <td>{{ $sub->percentage }}%</td>
                                    <td>{!! $sub->is_primary_html !!}</td>
                                    <td>{!! $sub->is_active_html !!}</td>
                                    <td>
                                        <a href="#" class="btn btn-xs btn-{{ $sub->schedules->count() ? 'warning' : 'info' }} waves-effect shift-sub" id="{{ !$sub->schedules->count() ? "shift-sub-first" : "" }}"
                                           data-rotate-id="{{ $rotate->id }}" data-sub-id="{{ $sub->id }}" data-sub="{{ json_encode($sub) }}">
                                            <i class="fa fa-calendar-times-o"></i>
                                            @if($sub->schedules->count())
                                                Terjadwal
                                            @else
                                                Aktif selalu
                                            @endif
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('dashboard/rotate/form-sub/' . $rotate->id . '/' . $sub->id) }}" class="btn btn-xs btn-primary waves-effect edit-sub"
                                           data-rotate-id="{{ $rotate->id }}" data-sub-id="{{ $sub->id }}" data-sub="{{ json_encode($sub) }}" data-is-free="{{ is_null($user->active_order_id) ? 1 : 0 }}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="{{ url('dashboard/rotate/form-sub/' . $sub->id) }}" class="btn btn-xs btn-danger waves-effect">
                                            <i class="fa fa-close"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-schedule-cs" role="dialog">
        <div class="modal-dialog modals-default">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-warning">
                            Jika Anda <span class="label label-warning">menambahkan jadwal shift aktif</span> maka nomor CS akan ditampilkan <span class="label label-warning">terbatas</span> berdasarkan jadwal yang Anda tentukan
                        </li>
                        <li class="list-group-item list-group-item-info">
                            Jika <span class="label label-info">Tidak Mempunyai Jadwal</span> maka nomor CS akan <span class="label label-info">selalu aktif</span> dan ditampilkan sesuai perhitungan persentase
                        </li>
                        <li class="list-group-item list-group-item-success">
                            Anda dapat menambahkan satu atau lebih jadwal/shift ditampilkan sesuai dengan keinginan Anda
                        </li>
                    </ul>
                    <div id="schedule-cs-text">

                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-generate-campaign" role="dialog">
        <div class="modal-dialog modals-default">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>
                        Contoh jika Anda mengisi campaign atau UTM bernama "untuk-iklan-ig", maka akan digenerate sebuah link menjadi
                        <span class="label label-info">www.domain.com/wa/toko-saya?campaign=untuk-iklan-ig</span>
                        sehingga setiap customer Anda klik pada link maka system akan dicatat mempunyai referal/utm "untuk-iklan-ig"
                    </p>
                    <p>
                        Anda dapat membuat 1 atau lebih campaign sesuai dengan kebutuhan.
                    </p>
                    <div class="form-group">
                        <div class="nk-int-st">
                            <label for="phone">Nama Campaign (opsional)</label>
                            <input type="text" name="campaign" id="campaign" class="form-control" placeholder="{{ !is_null($user->active_order) ? 'Masukan Nama Campaign Anda' : 'Harap upgrade untuk menggunakan fitur ini, Profile -> Upgrade' }}" value="{{ old('campaign') }}" {{ !is_null($user->active_order) ? 'required' : 'disabled' }}/>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <div class="nk-int-st">
                            <label for="name">Hasil Link</label>
                            <input type="text" name="link" id="link-generated" class="form-control" data-link-share="{{ $rotate->link_share }}" value="{{ $rotate->link_share }}" readonly/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="copy-generated-link">
                        <i class="fa fa-copy"></i> Copy Link
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-add-sub" role="dialog">
        <div class="modal-dialog modals-default">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                {{ Form::open(['url' => url('dashboard/rotate/form-sub/' . (!is_null($rotate) ? $rotate->id : "")),'id' => 'form-sub', 'autocomplete' => 'off', 'files' => true ]) }}

                <div class="modal-body">
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <div class="nk-int-st">
                            <label for="phone">Nomor Whatsapp</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Nomor Whatsapp Anda" value="{{ old('phone') }}" required/>
                            @if($errors->has('phone'))
                                <p class="help-block">{{ $errors->first('phone') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <div class="nk-int-st">
                        <label for="name">Nama Panggilan</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nama Panggilan Customer Service" value="{{ old('name') }}" required/>
                        @if($errors->has('name'))
                            <p class="help-block">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('percentage') ? ' has-error' : '' }}">
                    <div class="themesaller-forms nk-int-st">
                        <div class="spacer-b16a">
                            <label for="percentage">Persentase Untuk Tampil : </label>
                            <input type="text" id="percentage" name="percentage" class="slider-input" value="{{ 100 }}" readonly="">
                        </div>
                        <div class="slider-wrapper">
                            <div id="percentage-slider" class="{{ is_null($user->active_order_id) ? "disabled" : "" }}"></div>
                        </div>
                        @if(is_null($user->active_order_id))
                            <span class="label label-danger">Anda harus upgrade untuk menggunakan fitur persentase ini</span>
                            <a href="{{ url('dashboard/user/upgrade') }}" class="btn btn-xs btn-warning"><i class="fa fa-star"></i> klik disni</a>
                        @endif
                        @if($errors->has('percentage'))
                            <p class="help-block">{{ $errors->first('percentage') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('is_primary') ? ' has-error' : '' }}">
                    <div class="nk-int-st">
                        <label for="is_active">Is Primary</label>
                        <select class="form-control" name="is_primary" id="is_primary">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        @if($errors->has('is_primary'))
                            <p class="help-block">{{ $errors->first('is_primary') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                    <div class="nk-int-st">
                        <label for="is_active">Is Active</label>
                        <select class="form-control" name="is_active" id="is_active">
                            <option value="1">Active</option>
                            <option value="0">Non Active</option>
                        </select>
                        @if($errors->has('is_active'))
                            <p class="help-block">{{ $errors->first('is_active') }}</p>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success confirm">Save</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection