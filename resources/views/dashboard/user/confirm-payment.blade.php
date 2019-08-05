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
                                    <h2>Konfirmasi Pembayaran {{ $order->invoice_no }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="pull-right">
                                <a class="btn btn-warning notika-btn-warning waves-effect" href="{{ url('dashboard/user/payment/' . $order->id) }}">
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
                {{ Form::open(['url' => url('dashboard/user/save-confirm-payment/' . $order->id) ]) }}
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
                        <div class="form-group{{ $errors->has('bank_destination') ? ' has-error' : '' }}">
                            <div class="nk-int-st">
                                <label for="bank_destination">Bank Tujuan</label>
                                <input type="text" name="bank_destination" class="form-control" placeholder="BCA/Mandiri/BNI/Lainya" value="{{ old('bank_destination') }}" required>
                                @if($errors->has('bank_destination'))
                                    <p class="help-block">{{ $errors->first('bank_destination') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('bank_pengirim') ? ' has-error' : '' }}">
                            <div class="nk-int-st">
                                <label for="bank_pengirim">Bank Pengirim</label>
                                <input type="text" name="bank_pengirim" class="form-control" placeholder="Bank Anda, BCA/Mandiri/BNI/Lainya" value="{{ old('bank_pengirim') }}" required>
                                @if($errors->has('bank_pengirim'))
                                    <p class="help-block">{{ $errors->first('bank_pengirim') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('account_no') ? ' has-error' : '' }}">
                            <div class="nk-int-st">
                                <label for="account_no">No Rekening Anda</label>
                                <input type="text" name="account_no" class="form-control" placeholder="Nomor Rekening yang Anda Gunakan" value="{{ old('account_no') }}" required>
                                @if($errors->has('password'))
                                    <p class="help-block">{{ $errors->first('account_no') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('account_name') ? ' has-error' : '' }}">
                            <div class="nk-int-st">
                                <label for="account_name">Atas Nama</label>
                                <input type="text" name="account_name" class="form-control" placeholder="Atas Nama Bank Pengirim" value="{{ old('account_name') }}" required>
                                @if($errors->has('account_name'))
                                    <p class="help-block">{{ $errors->first('account_name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <div class="nk-int-st">
                                <label for="amount">Nominal</label>
                                <input type="text" name="amount" class="form-control" placeholder="Nominal Transfer" value="{{ number_format($order->grand_total,0) }}" required>
                                @if($errors->has('amount'))
                                    <p class="help-block">{{ $errors->first('amount') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <a href="{{ url('dashboard/user/payment/' . $order->id) }}" class="btn btn-default waves-effect">
                                <i class="fa fa-backward"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success notika-btn-success waves-effect">
                                <i class="fa fa-save"></i> Confirm
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
                                        Status : {!! !is_null($order->paid_at) ? '<span style="color:green">LUNAS</span>' : '<span style="color:red">BELUM DIBAYAR</span>' !!}
                                    </p>
                                    <p>
                                        Total: Rp {{ number_format($order->grand_total, 0) }}
                                    </p>
                                    @if(!is_null($order->paid_at))
                                        <p>
                                            Dibayar Pada : {{ date("d F Y", strtotime($order->paid_at)) }}<br/>
                                            Menggunakan metode pembayaran {{ $order->paid_by }}
                                        </p>
                                    @endif
                                </td>
                                <td>
                                    <p>
                                        Silahkan melakukan pembayaran ke
                                    </p>
                                    <p>
                                        Bank BCA <br/>
                                        Nomor Rekening : 1800-3797-81 <br/>
                                        Atas Nama : Muhamad Yulianto
                                    </p>
                                    <br/>
                                    <p>
                                        Bank CIMB Niaga <br/>
                                        Nomor Rekening : 76096-2227-900 <br/>
                                        Atas Nama : Muhamad Yulianto
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