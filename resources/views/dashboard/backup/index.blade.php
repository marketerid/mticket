@extends('dashboard.layout')
@section('js')
    <script>
        $(document).ready(function (e) {
            let introCookies    = $(document).getCookie('wa-rotator-intro');

            $('#intro-rotator-dashboard').on('click', function (e) {
                $(document).setCookie('wa-rotator-intro', 1, 1);
            });

            if(introCookies !== "1"){
                $('#intro-rotator-dashboard').modal('toggle');
            }
        });
    </script>
@endsection
@section('content')
    <div class="sale-statistic-area">
        <div class="container">
            @if(Session::has('alert-class'))
                <a class="notification-alert" data-type="{{ (Session::get('alert-class') == "success") ? "success" : "danger" }}" data-from="top" data-align="center" data-title="" data-message="{{ Session::get('status') }}">
                </a>
            @endif
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
                    <div class="sale-statistic-inner notika-shadow mg-tb-30">
                        <div class="curved-inner-pro">
                            <div class="curved-ctn">
                                <h2>
                                    Whatsapp Log
                                </h2>
                                <a href="{{ url('dashboard/rotate') }}" class="btn btn-xs btn-primary text-right">
                                    <i class="fa fa-whatsapp"></i> Akses WA Anda
                                </a>
                                <p>Statistik whatsapp log analytic Anda</p>
                            </div>
                        </div>
                        <div id="placeholder-wa" class="flot-chart-sts flot-chart"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
                    <div class="statistic-right-area notika-shadow mg-tb-30 sm-res-mg-t-0">
                        <div class="past-day-statis">
                            <h2>30 Hari Terakhir</h2>
                            <p>Data singkat Whatsapp Rotator Anda</p>
                        </div>
                        <div class="past-statistic-an">
                            <div class="past-statistic-ctn">
                                <h3><span class="counter">{{ number_format($logs->count(), 0) }}</span></h3>
                                <p>Total Log</p>
                            </div>
                            <div class="past-statistic-graph">
                                <div class="stats-line"></div>
                            </div>
                        </div>
                        <div class="past-statistic-an">
                            <div class="past-statistic-ctn">
                                <h3><span class="counter">{{ number_format($logs->where('event','open')->count(), 0) }}</span></h3>
                                <p>Total Open</p>
                            </div>
                            <div class="past-statistic-graph">
                                <div class="stats-bar"></div>
                            </div>
                        </div>
                        <div class="past-statistic-an">
                            <div class="past-statistic-ctn">
                                <h3><span class="counter">{{ number_format($logs->where('event','copy')->count(), 0) }}</span></h3>
                                <p>Total Copy Nomor</p>
                            </div>
                            <div class="past-statistic-graph">
                                <div class="stats-line"></div>
                            </div>
                        </div>
                        <div class="past-statistic-an">
                            <div class="past-statistic-ctn">
                                <h3><span class="counter">{{ number_format($logs->where('event','submit')->count(), 0) }}</span></h3>
                                <p>Total Submit/Lead</p>
                            </div>
                            <div class="past-statistic-graph">
                                <div class="stats-bar-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Sale Statistic area-->

    <div class="modal fade" id="intro-rotator-dashboard" role="dialog">
        <div class="modal-dialog modals-default">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <a href="{{ url('dashboard/rotate/form-rotate?wizard=1&dashboard-intro=1') }}">
                        <img src="{{ asset('images/whatsapp-intro.png') }}" class="img"/>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection