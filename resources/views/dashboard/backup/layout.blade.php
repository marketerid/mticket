<!doctype html>
<html class="no-js" lang="">
@include('dashboard.head')
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">Browser Anda terlalu <strong>TUA</strong>. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<!-- Start Header Top Area -->
@include('dashboard.header')
<!-- End Header Top Area -->
@include('dashboard.nav')
<!-- Start Content area-->
<div class="content-area" style="padding-top: 25px; margin-bottom: 100px;">
    @yield('content')
</div>
<!-- Start Footer area-->
<div class="footer-copyright-area" style="position: fixed;bottom: 0;height: 45px;width: 100%">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="footer-copy-right">
                    <p>Copyright © 2018
                        . All rights reserved. Engine by <a href="https://wasend.id">Wasend.ID</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@include('dashboard.foot')
</body>

</html>