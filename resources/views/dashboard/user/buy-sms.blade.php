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
                                    <h2>Top-up SMS</h2>
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
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                {{ Form::open(['url' => url('dashboard/user/buy-sms-process/') ]) }}
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
                        <div class="form-group{{ $errors->has('total_sms') ? ' has-error' : '' }}">
                            <div class="nk-int-st">
                                <label for="sms_balance">Total SMS</label>
                                <select name="sms_balance" class="form-control">
                                    <option value="">Pilih Jumlah SMS</option>
                                    <option value="100">100 SMS, Rp20.000</option>
                                    <option value="500">500 SMS, Rp100.000</option>
                                    <option value="1000">1.000 SMS, Rp180.000 (Potongan 20rb)</option>
                                    <option value="2000">2.000 SMS, Rp320.000 (Potongan 80rb)</option>
                                    <option value="5000">5.000 SMS, Rp750.000 (Potongan 250rb)</option>
                                    <option value="10000">10.000 SMS, Rp1.300.000 (Potongan 700rb)</option>
                                </select>
                                @if($errors->has('total_sms'))
                                    <p class="help-block">{{ $errors->first('total_sms') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{ url('dashboard/user') }}" class="btn btn-default waves-effect">
                                <i class="fa fa-backward"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success notika-btn-success waves-effect">
                                <i class="fa fa-shopping-cart"></i> Beli
                            </button>
                        </div>
                </div>
                {{ Form::close() }}
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="normal-table-list">
                    <div class="bsc-tbl">
                        <table class="table table-cl table-striped">
                            <tbody>
                            <tr>
                                <td>
                                    <p>
                                        SMS Dapat Anda gunakan untuk notifikasi order dari customer Anda, Pengingat Order, Dan Custom SMS
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
    </div>
@endsection