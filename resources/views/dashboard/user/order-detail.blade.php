@extends('dashboard.layout')
@section('title')
    Detail Order
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                <div class="breadcomb-list">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <div class="breadcomb-wp">
                                <div class="breadcomb-icon">
                                    <i class="notika-icon notika-windows"></i>
                                </div>
                                <div class="breadcomb-ctn">
                                    <h2>Order Detail {{ $order->invoice_no }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="pull-right">
                                <a href="{{ url('dashboard/user/') }}" class="btn btn-xs btn-warning">
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
                <div class="normal-table-list">
                    <div class="bsc-tbl">
                        <table class="table table-cl table-striped">
                            <tbody>
                            <tr>
                                <td>ID</td>
                                <td>{{ $order->invoice_no }}</td>
                            </tr>
                            <tr>
                                <td>Produk</td>
                                <td>{{ $order->package->description }}</td>
                            </tr>
                            <tr>
                                <td>Package</td>
                                <td>{{ strtoupper($order->package->slug) }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    @if(!is_null($order->expired_at))
                                        <span class="label label-danger">Expired</span>
                                    @else
                                        {{ $order->status }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Expired pada</td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->addDays(3)->format('d F Y H:i:s') }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="normal-table-list">
                    <div class="bsc-tbl">
                        <table class="table table-cl table-striped">
                            <tbody>
                            <tr>
                                <td>Invoice PDF</td>
                                <td>
                                    <a href="{{ url('dashboard/user/invoice/' . $order->id) }}" class="btn btn-xs btn-info" target="_blank">
                                        <i class="fa fa-download"></i> Download Invoice
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Sudah dibayar?</td>
                                <td>{{ !is_null($order->paid_at) ? "Lunas" : "Belum Dibayar" }}</td>
                            </tr>
                            <tr>
                                <td>Harga Produk</td>
                                <td>Rp {{ number_format($order->product_total,0) }}</td>
                            </tr>
                            <tr>
                                <td>Kode unik</td>
                                <td>Rp {{ number_format($order->unique_code,0) }}</td>
                            </tr>
                            <tr>
                                <td>Grand Total</td>
                                <th>Rp {{ number_format($order->grand_total,0) }}</th>
                            </tr>
                            <tr>
                                @if(is_null($order->paid_at) AND is_null($order->expired_at))
                                    <td>Link Pembayaran</td>
                                    <td>
                                        <a href="{{ url('dashboard/user/payment/' . $order->id) }}" class="btn btn-sm btn-buy">
                                            <i class="fa fa-money"></i> BAYAR SEKARANG
                                        </a>
                                    </td>
                                @endif
                                @if(is_null($order->paid_at) AND !is_null($order->expired_at))
                                    ORDER EXPIRED
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection