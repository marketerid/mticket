<div class="header-top-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="logo-area">
                    <a href="#"><img src="{{ url('frontend/img/logo/logo.png') }}" alt="" width="140px" /></a>

                    @if(Auth::guard('web')->check())
                        <span class="label label-warning">as Admin</span>
                    @endif
                    @if(Auth::guard('operator')->check())
                        <span class="label label-default">as Operator</span>
                    @endif
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="header-top-menu">
                    <ul class="nav navbar-nav notika-top-nav">
                        <li class="nav-item nc-al">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                <span>
                                    <i class="notika-icon notika-alarm"></i>
                                </span>
                            </a>
                            <div role="menu" class="dropdown-menu message-dd notification-dd animated zoomIn" id="notification-place">

                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                <div class="spinner4 spinner-4"></div><div class="ntd-ctn"><span id="notification-total">0</span></div></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>