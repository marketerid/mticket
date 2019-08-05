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
                                    <h2>Detail Transaksi Bank {{ !is_null($transaction) ? $transaction->bank->account_no : "" }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="pull-right">
                                <a class="btn btn-sm btn-warning notika-btn-warning waves-effect" href="{{ url('dashboard/bank') }}">
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
                                <td>Bank</td>
                                <td>{{ $bank->bank }} - {{ $bank->account_no }}</td>
                            </tr>
                            <tr>
                                <td>Transaction ID</td>
                                <td>{{ $transaction->id }}</td>
                            </tr>
                            <tr>
                                <td>Deskripsi</td>
                                <td>{{ $transaction->description }}</td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td>{{ $transaction->type_text }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Transaksi</td>
                                <td>{{ number_format($transaction->total,0) }}</td>
                            </tr>
                            <tr>
                                <td>Saldo saat transaksi</td>
                                <td>{{ number_format($transaction->balance,0) }}</td>
                            </tr>
                            <tr>
                                <td>Waktu di catat</td>
                                <td>{{ $transaction->created_at }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="normal-table-list">
                    <h4>
                        Detail Transaksi Order {{ (!$transaction->user_order) ? "(Jika ada)" : "" }}
                        @if($transaction->user_order)
                            <a href="{{ url('dashboard/user-order/detail-order/' . $transaction->user_order->id) }}" class="btn btn-primary btn-xs pull-right">
                                <i class="fa fa-search"></i> Detail Order
                            </a>
                        @endif
                    </h4>
                    <div class="row">
                        @if($transaction->user_order)
                        <div class="col-md-6">
                            <div class="bsc-tbl">
                                <table class="table table-sc-ex table-striped">
                                    <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>
                                            {{ $transaction->user_order->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Customer Name</th>
                                        <td>
                                            {{ $transaction->user_order->customer_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Customer Email</th>
                                        <td>
                                            {{ $transaction->user_order->customer_email }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Customer Phone</th>
                                        <td>
                                            {{ $transaction->user_order->customer_phone }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Customer Provinsi</th>
                                        <td>
                                            {{ $transaction->user_order->province->title }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Customer Kota</th>
                                        <td>
                                            {{ $transaction->user_order->city->title }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Customer Kecamatan</th>
                                        <td>
                                            {{ $transaction->user_order->district->title }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Customer Kode Pos</th>
                                        <td>
                                            {{ $transaction->user_order->customer_postal_code }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Customer Alamat Lengkap</th>
                                        <td>
                                            {{ $transaction->user_order->customer_full_address }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Pilihan Kurir</th>
                                        <td>
                                            {{ $transaction->user_order->delivery_service }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Paket</th>
                                        <td>
                                            {{ $transaction->user_order->delivery_package }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Berat (gr)</th>
                                        <td>
                                            {{ number_format($transaction->user_order->weight_total,0) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ongkos Kirim</th>
                                        <td>
                                            {{ number_format($transaction->user_order->delivery_fee,0) }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bsc-tbl">
                                <table class="table table-sc-ex table-striped">
                                    <tbody>
                                    <tr>
                                        <th>Harga Produk Total</th>
                                        <td>
                                            Rp {{ number_format($transaction->user_order->product_total,0) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kode Unik</th>
                                        <td>
                                            Rp {{ number_format($transaction->user_order->unique_code,0) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Grand Total</th>
                                        <th>
                                            <span class="label label-primary">
                                                Rp {{ number_format($transaction->user_order->grand_total,0) }}
                                            </span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Order Dibuat Pada</th>
                                        <th>
                                            {{ $transaction->user_order->created_at }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Lunas Pada</th>
                                        <td>
                                            {!! !is_null($transaction->user_order->paid_at) ? "<span class='label label-success'>".$transaction->user_order->paid_at."</span>" : "<span class='label label-danger'>Belum Dibayar</span>" !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Dibayar Dengan</th>
                                        <td>
                                            {{ $transaction->user_order->paid_with }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <hr/>
                                <h4> List Produk Yang Dibeli </h4>
                                <table class="table table-sc-ex table-striped">
                                    <tbody>
                                    @foreach($transaction->user_order->details as $value)
                                        <tr>
                                            <th>Produk</th>
                                            <td>
                                                {{ $value->title }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Qty</th>
                                            <td>
                                                {{ number_format($value->quantity,0) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Weight (gr)</th>
                                            <td>
                                                {{ number_format($value->weight,0) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total Harga</th>
                                            <td>
                                                {{ number_format($value->product_total,0) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <p class="align-center">
                                    Tidak ada order berelasi dengan transaksi ini
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection