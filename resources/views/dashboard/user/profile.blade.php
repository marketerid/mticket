@extends('dashboard.layout')
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
                                    <h2>Detail Profile Anda</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="pull-right">

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
                            @if(!$user->active_order)
                                <tr>
                                    <td>Upgrade</td>
                                    <td>
                                        <a href="{{ url('dashboard/user/upgrade') }}" class="btn btn-primary">
                                            <i class="fa fa-star"></i> Upgrade Sekarang
                                        </a>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td>Name</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{ $user->phone }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td>Paket Aktif</td>
                                <td>
                                    <span class="label label-info">
                                        {{ $user->active_order ? strtoupper($user->active_order->package->slug) : "PAKET GRATIS" }}
                                    </span>
                                </td>
                            </tr>
                            @if($user->active_order AND $user->active_order->package->slug == 'pro')
                                <tr>
                                    <td>Saldo SMS</td>
                                    <td>
                                        {{ number_format($user->sms_balance,0) }}
                                        <a href="{{ url('dashboard/user/buy-sms') }}" class="btn btn-xs btn-primary pull-right">
                                            <i class="fa fa-plus"></i> Beli Saldo
                                        </a>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td>
                                    <a href="{{ url('dashboard/user/edit-profile') }}" class="btn btn-xs btn-info">
                                        <i class="fa fa-user"></i> Edit Profile
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('dashboard/user/edit-password') }}" class="btn btn-xs btn-warning">
                                        <i class="fa fa-lock"></i> Edit Password
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="normal-table-list">
                    <h4>Order/Invoice Anda</h4>
                    <div class="bsc-tbl">
                        <table class="table table-sc-ex table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Invoice</th>
                                <th>Domain</th>
                                <th>Paket</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user->orders as $key => $order)
                                @php
                                    if($key > 24){
                                        break;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->invoice_no }}</td>
                                    <td>{{ $order->sub_domain . ' - ' . $order->own_domain }}</td>
                                    <td>{{ $order->package->description }}</td>
                                    <td>{!! $order->status_html !!}</td>
                                    <td>{{ number_format($order->grand_total,0) }}</td>
                                    <td>
                                        <a href="{{ url('dashboard/user/order-detail/' . $order->id) }}" class="btn btn-xs btn-primary waves-effect" data-toggle="tooltip" title="Dibuat pada: {{ $order->checkout_at }}">
                                            <i class="fa fa-search"></i>
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
@endsection