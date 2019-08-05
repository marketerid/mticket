
<!-- Mobile Menu start -->
<div class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="mobile-menu">
                    <nav id="dropdown">
                        <ul class="mobile-menu-nav">
                            @if(Auth::guard('web')->check())
                                <li>
                                    <a href="{{ url('dashboard') }}">Home</a>
                                </li>
                                <li><a data-toggle="collapse" data-target="#m-operator" href="#">Operator CS</a>
                                    <ul id="m-operator" class="collapse dropdown-header-top">
                                        <li class="{{ isActiveMenu('operator','') }}"><a href="{{ url('dashboard/operator') }}">List</a></li>
                                    </ul>
                                </li>
                                <li><a data-toggle="collapse" data-target="#m-form" href="#">Form Generator</a>
                                    <ul id="m-form" class="collapse dropdown-header-top">
                                        <li class="{{ isActiveMenu('form','') }}"><a href="{{ url('dashboard/form') }}">List</a></li>
                                        <li class="{{ isActiveMenu('form','lead') }}"><a href="{{ url('dashboard/form/lead') }}">Lead</a></li>
                                    </ul>
                                </li>
                                <li><a data-toggle="collapse" data-target="#m-rotate" href="#">WA Rotator</a>
                                    <ul id="m-rotate" class="collapse dropdown-header-top">
                                        <li class="{{ isActiveMenu('rotate','') }}"><a href="{{ url('dashboard/rotate') }}">WA Rotate</a></li>
                                        <li class="{{ isActiveMenu('rotate','log') }}"><a href="{{ url('dashboard/rotate/log') }}">History Log</a></li>
                                    </ul>
                                </li>
                                <li><a data-toggle="collapse" data-target="#m-profile" href="#">Profile</a>
                                    <ul id="m-profile" class="collapse dropdown-header-top">
                                        <li class="{{ isActiveMenu('user','') }}"><a href="{{ url('dashboard/user') }}">Lihat Profile</a></li>
                                        <li class="{{ isActiveMenu('user','invoice-list') }}"><a href="{{ url('dashboard/user/invoice-list') }}">Order/Invoice</a></li>
                                        <li class="{{ isActiveMenu('user','notification') }}"><a href="{{ url('dashboard/notification') }}">Pemberitahuan</a></li>
                                        <li class="{{ isActiveMenu('user','upgrade') }}"><a href="{{ url('dashboard/user/upgrade') }}">Upgrade</a></li>
                                        <li><a href="{{ url('auth/logout') }}">Logout</a></li>
                                    </ul>
                                </li>
                            @endif

                            @if(Auth::guard('operator')->check())
                                <li><a data-toggle="collapse" data-target="#m-form" href="#">Form Lead</a>
                                    <ul id="m-form" class="collapse dropdown-header-top">
                                        <li class="{{ isActiveMenu('form','lead') }}"><a href="{{ url('operator/form/lead') }}">Lead List</a></li>
                                    </ul>
                                </li>
                                <li><a data-toggle="collapse" data-target="#m-operator" href="#">Profile Saya</a>
                                    <ul id="m-operator" class="collapse dropdown-header-top">
                                        <li class="{{ isActiveMenu('operator','') }}"><a href="{{ url('operator/operator/view-profile') }}">Profile</a></li>
                                    </ul>
                                    <ul id="m-operator" class="collapse dropdown-header-top">
                                        <li class="{{ isActiveMenu('operator','') }}"><a href="{{ url('operator/logout') }}">Profile</a></li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Mobile Menu end -->
<!-- Main Menu area start-->
<div class="main-menu-area mg-tb-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                    @if(Auth::guard('web')->check())
                        <li class="{{ isActiveMenuMain('') }}">
                            <a href="{{ url('dashboard') }}"><i class="notika-icon notika-house"></i> Home</a>
                        </li>
                        <li class="{{ isActiveMenuMain('operator') }}">
                            <a data-toggle="tab" href="#operator"><i class="fa fa-users"></i> Operator CS</a>
                        </li>
                        <li class="{{ isActiveMenuMain('form') }}">
                            <a data-toggle="tab" href="#form"><i class="fa fa-gears"></i> Form Generator</a>
                        </li>
                        <li class="{{ isActiveMenuMain('rotate') }}">
                            <a data-toggle="tab" href="#rotate"><i class="fa fa-whatsapp"></i> WA Rotator</a>
                        </li>
                        {{--<li class="{{ isActiveMenuMain('bank') }}">
                            <a data-toggle="tab" href="#bank"><i class="fa fa-bank"></i> Bank</a>
                        </li>
                        <li class="{{ isActiveMenuMain('user-order') }}"><a data-toggle="tab" href="#order"><i class="notika-icon notika-bar-chart"></i> Order</a>
                        </li>
                        <li class="{{ isActiveMenuMain('product') }}"><a data-toggle="tab" href="#product"><i class="notika-icon notika-windows"></i> Product</a>
                        </li>--}}
                        </li>
                        <li class="{{ isActiveMenuMain('user') }}"><a data-toggle="tab" href="#Profile"><i class="notika-icon notika-support"></i> Profile</a>
                        </li>
                    @endif
                    @if(Auth::guard('operator')->check())
                        <li class="{{ isActiveMenuMain('form') }}">
                            <a data-toggle="tab" href="#form"><i class="fa fa-gear"></i> Lead Form</a>
                        </li>
                        <li class="{{ isActiveMenuMain('operator') }}">
                            <a data-toggle="tab" href="#operator"><i class="fa fa-users"></i> Profile</a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content custom-menu-content">
                    @if(Auth::guard('web')->check())
                        <div id="operator" class="tab-pane notika-tab-menu-bg animated flipInX {{ isActiveMenuMain('operator') }}">
                            <ul class="notika-main-menu-dropdown">
                                <li class="{{ isActiveMenu('operator','') }}"><a href="{{ url('dashboard/operator') }}">List Operator</a>
                                </li>
                            </ul>
                        </div>
                        <div id="form" class="tab-pane notika-tab-menu-bg animated flipInX {{ isActiveMenuMain('form') }}">
                            <ul class="notika-main-menu-dropdown">
                                <li class="{{ isActiveMenu('form','') }}"><a href="{{ url('dashboard/form') }}">List Form</a>
                                </li>
                                <li class="{{ isActiveMenu('form','lead') }}"><a href="{{ url('dashboard/form/lead') }}">List Lead</a>
                                </li>
                            </ul>
                        </div>
                        <div id="rotate" class="tab-pane notika-tab-menu-bg animated flipInX {{ isActiveMenuMain('rotate') }}">
                            <ul class="notika-main-menu-dropdown">
                                <li class="{{ isActiveMenu('rotate','') }}"><a href="{{ url('dashboard/rotate') }}">WA Rotate</a>
                                </li>
                                <li class="{{ isActiveMenu('rotate','log') }}"><a href="{{ url('dashboard/rotate/log') }}">History Log</a>
                                </li>
                            </ul>
                        </div>
                        <div id="bank" class="tab-pane notika-tab-menu-bg animated flipInX {{ isActiveMenuMain('bank') }}">
                            <ul class="notika-main-menu-dropdown">
                                <li class="{{ isActiveMenu('bank','') }}"><a href="{{ url('dashboard/bank') }}">List Bank</a>
                                </li>
                                <li class="{{ isActiveMenu('bank','transaction') }}"><a href="{{ url('dashboard/bank/transaction') }}">List Transaction</a>
                                </li>
                            </ul>
                        </div>
                        <div id="order" class="tab-pane notika-tab-menu-bg animated flipInX {{ isActiveMenuMain('user-order') }}">
                            <ul class="notika-main-menu-dropdown">
                                <li class="{{ isActiveMenu('user-order','') }}"><a href="{{ url('dashboard/user-order') }}">List Order</a>
                                </li>
                                <li class="{{ isActiveMenu('user-order','customer') }}"><a href="{{ url('dashboard/user-order/customer') }}">List Customer</a>
                                </li>
                            </ul>
                        </div>
                        <div id="product" class="tab-pane notika-tab-menu-bg animated flipInX {{ isActiveMenuMain('product') }}">
                            <ul class="notika-main-menu-dropdown">
                                <li class="{{ isActiveMenu('product','') }}"><a href="{{ url('dashboard/product') }}">Product List</a>
                                </li>
                            </ul>
                        </div>
                        <div id="Profile" class="tab-pane notika-tab-menu-bg animated flipInX {{ isActiveMenuMain('user') }}">
                            <ul class="notika-main-menu-dropdown">
                                <li class="{{ isActiveMenu('user','') }}"><a href="{{ url('dashboard/user') }}">Lihat Profile</a>
                                <li class="{{ isActiveMenu('user','invoice-list') }}">
                                    <a href="{{ url('dashboard/user/invoice-list') }}">Order/Invoice</a>
                                </li>
                                <li class="{{ isActiveMenu('user','notification') }}">
                                    <a href="{{ url('dashboard/user/notification') }}">Pemberitahuan</a>
                                </li>
                                <li class="{{ isActiveMenu('user','upgrade') }}">
                                    <a href="{{ url('dashboard/user/upgrade') }}"><i class="fa fa-star"></i> Upgrade</a>
                                </li>
                                <li><a href="{{ url('auth/logout') }}">Logout</a>
                                </li>
                            </ul>
                        </div>
                    @endif
                    @if(Auth::guard('operator')->check())
                        <div id="form" class="tab-pane notika-tab-menu-bg animated flipInX {{ isActiveMenuMain('form') }}">
                            <ul class="notika-main-menu-dropdown">
                                <li class="{{ isActiveMenu('form','lead') }}"><a href="{{ url('operator/form/lead') }}">Lead Saya</a>
                                </li>
                            </ul>
                        </div>
                        <div id="operator" class="tab-pane notika-tab-menu-bg animated flipInX {{ isActiveMenuMain('operator') }}">
                            <ul class="notika-main-menu-dropdown">
                                <li class="{{ isActiveMenu('operator','') }}"><a href="{{ url('operator/operator/view-profile') }}">Profile Saya</a>
                                </li>
                                <li class="{{ isActiveMenu('operator','') }}"><a href="{{ url('auth/logout-op') }}">Logout</a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Menu area End-->