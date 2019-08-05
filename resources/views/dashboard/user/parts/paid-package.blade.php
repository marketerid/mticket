
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

    <!--PRICE CONTENT START-->
    <div class="generic_content active clearfix">

        <!--HEAD PRICE DETAIL START-->
        <div class="generic_head_price clearfix">

            <!--HEAD CONTENT START-->
            <div class="generic_head_content clearfix">

                <!--HEAD START-->
                <div class="head_bg"></div>
                <div class="head">
                    <span>Basic</span>
                </div>
                <!--//HEAD END-->

            </div>
            <!--//HEAD CONTENT END-->

            <!--PRICE START-->
            <div class="generic_price_tag clearfix">
											  <span class="price">
													<span class="sign">Rp</span>
													<span class="currency">299.000</span>
													<span class="cent">,-</span>
													<span class="month">/Th</span>
											  </span>
            </div>
            <!--//PRICE END-->

        </div>
        <!--//HEAD PRICE DETAIL END-->

        <!--FEATURE LIST START-->
        <div class="generic_feature_list">
            <ul>
                <li><span>2</span> Whatsapp Rotator</li>
                <li><span>Semua Fitur</span> di versi Gratis</li>
                <li><span>Custom UTM</span> WA Rotator</li>
                <li><span>Facebook Pixel</span> WA Rotator</li>
                <li><span>Google Analytic</span> WA Rotator</li>
                <li><span>Custom Javascript</span> WA Rotator</li>
                <li><span>Shift</span> WA Rotator</li>
            </ul>
        </div>
        <!--//FEATURE LIST END-->

        <!--BUTTON START-->
        <div class="generic_price_btn clearfix">
            @if($user->active_order AND $user->active_order->package->slug == 'basic')
                <a class="" href="#">ANDA DIPAKET INI</a>
            @elseif(!$user->active_order)
                <a class="" href="{{ url('dashboard/user/upgrade-now/?package=basic') }}">BELI</a>
            @else
                <a class="" href="#">ANDA DIPAKET Pro</a>
            @endif
        </div>
        <!--//BUTTON END-->

    </div>
    <!--//PRICE CONTENT END-->

</div>
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

    <!--PRICE CONTENT START-->
    <div class="generic_content clearfix">

        <!--HEAD PRICE DETAIL START-->
        <div class="generic_head_price clearfix">

            <!--HEAD CONTENT START-->
            <div class="generic_head_content clearfix">

                <!--HEAD START-->
                <div class="head_bg"></div>
                <div class="head">
                    <span>Pro</span>
                </div>
                <!--//HEAD END-->

            </div>
            <!--//HEAD CONTENT END-->

            <!--PRICE START-->
            <div class="generic_price_tag clearfix">
											  <span class="price">
													<span class="sign">Rp</span>
													<span class="currency">1.099.000</span>
													<span class="cent">,-</span>
													<span class="month">/Th</span>
											  </span>
            </div>
            <!--//PRICE END-->

        </div>
        <!--//HEAD PRICE DETAIL END-->

        <!--FEATURE LIST START-->
        <div class="generic_feature_list">
            <ul>
                <li><span>Semua fitur</span> di versi Basic</li>
                <li><span>2 Akun Bank</span> Mutasi Otomatis**</li>
                <li><span>Payment Order</span> Otomatis**</li>
                <li><span>Form Order</span> Custom</li>
                <li><span>SMS Notifikasi</span> Order/Mutasi Bank</li>
                <li><span>Lead Database</span> Managemen</li>
                <li><span>Diskon 50%</span> untuk User paket Basic</li>
            </ul>
        </div>
        <!--//FEATURE LIST END-->

        <!--BUTTON START-->
        <div class="generic_price_btn clearfix">
            @if($user->active_order AND $user->active_order->package->slug == 'pro')
                <a class="" href="#">ANDA DIPAKET INI</a>
            @elseif(!$user->active_order)
                <a class="" href="{{ url('dashboard/user/upgrade-now/?package=pro') }}">BELI</a>
            @else
                <a class="" href="#">ANDA DIPAKET Basic</a>
            @endif
        </div>
        <!--//BUTTON END-->

    </div>
    <!--//PRICE CONTENT END-->

</div>