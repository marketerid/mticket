@extends('dashboard.layout')
@section('title')
    Upgrade Akun
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-comparison.css') }}">
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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div id="generic_price_table">
                    <section>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <!--PRICE HEADING START-->
                                    <div class="price-heading clearfix">
                                        <h1>Upgrade Akun Anda</h1>
                                    </div>
                                    <!--//PRICE HEADING END-->
                                </div>
                            </div>
                        </div>
                        <div class="container">

                            <!--BLOCK ROW START-->
                            <div class="row">
                                <div class="col-md-4">

                                    <!--PRICE CONTENT START-->
                                    <div class="generic_content clearfix">

                                        <!--HEAD PRICE DETAIL START-->
                                        <div class="generic_head_price clearfix">

                                            <!--HEAD CONTENT START-->
                                            <div class="generic_head_content clearfix">

                                                <!--HEAD START-->
                                                <div class="head_bg"></div>
                                                <div class="head">
                                                    <span>Gratis</span>
                                                </div>
                                                <!--//HEAD END-->

                                            </div>
                                            <!--//HEAD CONTENT END-->

                                            <!--PRICE START-->
                                            <div class="generic_price_tag clearfix">
											  <span class="price">
													<span class="sign">Rp</span>
													<span class="currency">0</span>
													<span class="cent"></span>
													<span class="month">/MON</span>
											  </span>
                                            </div>
                                            <!--//PRICE END-->

                                        </div>
                                        <!--//HEAD PRICE DETAIL END-->

                                        <!--FEATURE LIST START-->
                                        <div class="generic_feature_list">
                                            <ul>
                                                <li><span>1</span> Whatsapp Rotator</li>
                                                <li><span>Unlimited CS</span> WA Rotator</li>
                                                <li><span>Live Log</span> WA Rotator</li>
                                                <li><span>Analytic</span> WA Rotator</li>
                                            </ul>
                                        </div>
                                        <!--//FEATURE LIST END-->

                                        <!--BUTTON START-->
                                        <div class="generic_price_btn clearfix">
                                            @if(!$user->active_order)
                                                <a type="button" class="btn btn-default" disabled="">ANDA DIPAKET INI</a>
                                            @else
                                                <a type="button" class="btn btn-default" disabled="">Anda telah Upgrade</a>
                                            @endif
                                        </div>
                                        <!--//BUTTON END-->

                                    </div>
                                    <!--//PRICE CONTENT END-->

                                </div>

                                @include('dashboard.user.parts.paid-package')
                            </div>
                            <!--//BLOCK ROW END-->

                        </div>
                    </section>
                    <footer>
                        <a class="bottom_btn btn-primary" href="#">Informasi Fitur</a>
                    </footer>
                </div>
            </div>
        </div>
    </div>
@endsection