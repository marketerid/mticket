@extends('dashboard.layout')
@section('title')
    Upgrade Akun Sekarang
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-comparison.css') }}">
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
                                    <h2>Upgrade Paket</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="pull-right">
                                <a class="btn btn-warning notika-btn-warning waves-effect" href="{{ url('dashboard/user/') }}">
                                    <i class="fa fa-backward"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                {{ Form::open(['url' => url('dashboard/user/upgrade-process/') ]) }}
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
                    <div class="form-group{{ $errors->has('package') ? ' has-error' : '' }}">
                        <div class="nk-int-st">
                            <label for="sms_balance">Pilihan Paket</label>
                            <select name="sms_balance" class="form-control">
                                <option value="">Pilih Paket</option>
                                <option value="basic">Basic Rp299.000/th</option>
                                <option value="pro">Pro Rp1.099.000/th</option>
                            </select>
                            @if($errors->has('package'))
                                <p class="help-block">{{ $errors->first('package') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="{{ url('dashboard/user') }}" class="btn btn-default waves-effect">
                            <i class="fa fa-backward"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success notika-btn-success waves-effect">
                            <i class="fa fa-shopping-cart"></i> BELI
                        </button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>

            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="normal-table-list">
                    <div class="bsc-tbl">
                        <table class="table table-cl table-striped">
                            <tbody>
                            <tr>
                                <td>
                                    <p>Anda akan upgrade paket
                                    </p>
                                    <p>
                                        Anda juga dapat menggunakan fitur Bulk/Blast SMS Custom sesuai dengan database nomor handphone yang Anda miliki,
                                        Pelajari lebih lanjut <a href="#" class="btn btn-xs btn-info"><i class="fa fa-link"></i> Disini</a>
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--//BLOCK ROW END-->

        </div>
    </div>
@endsection