
<head>
    <meta charset="utf-8">
    <base data-url="{{ url('') }}" data-token="{{ \Illuminate\Support\Facades\Auth::guard('web')->check() ? encrypt(json_encode([
        'user_id'       => \Illuminate\Support\Facades\Auth::guard('web')->user()->id,
        'expired_at'    => \Carbon\Carbon::now()->addMinutes(3)->toDateTimeString()
    ])) : '' }}" data-csrf="{{ csrf_token() }}"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title','Dashboard') | Wasend Marketing Tools</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-139045809-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-139045809-1');
    </script>


    @yield('css_top')
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('frontend/img/favicon.ico') }}">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('frontend/css/bootstrap.min.css') }}">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('frontend/css/font-awesome.min.css') }}">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('frontend/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/owl.transitions.css') }}">
    <!-- meanmenu CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('frontend/css/meanmenu/meanmenu.min.css') }}">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('frontend/css/animate.css') }}">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('frontend/css/normalize.css') }}">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('frontend/css/scrollbar/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/notification/notification.css') }}">
    <!-- jvectormap CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('frontend/css/jvectormap/jquery-jvectormap-2.0.3.css') }}">
    <!-- notika icon CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('frontend/css/notika-custom-icon.css') }}">
    <!-- wave CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('frontend/css/wave/waves.min.css') }}">

    <link rel="stylesheet" href="{{ url('frontend/css/owl.transitions.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/datapicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/bootstrap-select/bootstrap-select.css') }}">
    {{--<link rel="stylesheet" href="{{ url('frontend/js/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ url('frontend/js/bootstrap-datepicker/daterangepicker.css') }}">--}}
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('frontend/css/main.css') }}">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('frontend/style.css') }}">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('frontend/css/responsive.css') }}">
    <!-- modernizr JS
		============================================ -->
    <script src="{{ url('frontend/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset("bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css") }}"/>

    @yield('css')
</head>
