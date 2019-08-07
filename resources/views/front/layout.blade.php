<!DOCTYPE html>
<html>
<head>
	<title>Mticket.asia</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
	<link rel="stylesheet" href="{{ url('theme/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ url('theme/css/bootstrap-select.min.css') }}">
	<link rel="stylesheet" href="{{ url('theme/css/bootstrap-slider.min.css') }}">
	<link rel="stylesheet" href="{{ url('theme/css/jquery.scrolling-tabs.min.css') }}">
	<link rel="stylesheet" href="{{ url('theme/css/bootstrap-checkbox.css') }}">
	<link rel="stylesheet" href="{{ url('theme/css/flexslider.css') }}">
	<link rel="stylesheet" href="{{ url('theme/css/featherlight.min.css') }}">
	<link rel="stylesheet" href="{{ url('theme/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ url('theme/css/bootstrap.offcanvas.min.css') }}">
	<link rel="stylesheet" href="{{ url('theme/css/core.css') }}">
	<link rel="stylesheet" href="{{ url('theme/css/style.css') }}" >
	<link rel="stylesheet" href="{{ url('theme/css/responsive.css') }}" >
@yield('css')
</head>
<body>
<header id="masthead" class="site-header">
	<div class="top-header top-header-bg">
		<div class="container">
			<div class="row">
				<div class="top-left">
					<ul>
						<li>
							<a href="tel:02122302193">
								<i class="fa fa-phone"></i>
								021 22302193
							</a>
						</li>
						<li>
							<a href="mailto:hello@myticket.com"> 
								<i class="fa fa-envelope-o"></i>
								info@mticket.asia
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="main-header main-header-bg">
		<div class="container">
			<div class="row">
				<div class="site-branding col-md-3">
					<h1 class="site-title"><a href="{{ url('/') }}" title="myticket" rel="home"><img src="{{ url('assets/img/logo-white.png') }}" alt="logo"></a></h1>
				</div>

				<div class="col-md-9">
					<nav id="site-navigation" class="navbar">
						<div class="navbar-header">
							<div class="mobile-cart" ><a href="#">0</a></div>
							<button type="button" class="navbar-toggle offcanvas-toggle pull-right" data-toggle="offcanvas" data-target="#js-bootstrap-offcanvas">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>

						<div class="navbar-offcanvas navbar-offcanvas-touch navbar-offcanvas-right" id="js-bootstrap-offcanvas">
							<button type="button" class="offcanvas-toggle closecanvas" data-toggle="offcanvas" data-target="#js-bootstrap-offcanvas">
							   <i class="fa fa-times fa-2x" aria-hidden="true"></i>
							</button>
					
							<ul class="nav navbar-nav navbar-right">
								<li class="active"><a href="{{ url('event/seminar') }}">Seminar (0)</a></li>
								<li><a href="{{ url('event/philiphine') }}">Philiphine (0)</a></li>
								<li><a href="{{ url('event/franchise') }}">Franchise (0)</a></li>
								<li class="cart"><a href="#">0</a></li>
							</ul>
						</div>
					</nav><!-- #site-navigation -->
				</div>
			</div>
		</div>
	</div>
</header><!-- #masthead -->

@yield('content')

<footer id="colophon" class="site-footer">
	<div class="top-footer">
		<div class="container">
			<div class="row">
				
				<div class="col-md-8">
					<a href="#"><img src="{{ url('assets/img/logo-white.png') }}" alt="logo"></a>
				</div>
				<div class="col-md-4">
				
				<p>&copy; 2016 MTICKET.ASIA ALL RIGHTS RESEVED</p>
				</div>
			</div>
			
		</div>
	</div>
	
	<div class="main-footer">
		<div class="container">
			<div class="row">
			  <div class="footer-1 col-md-9">
				  <div class="social clearfix">
					<h3>Stay Connected</h3>
					<ul>
						<li class="facebook">
							<a href="#">
								<i class="fa fa-facebook" aria-hidden="true"></i>
								Facebook
							</a>
						</li>
						<li class="linkedin">
							<a href="#">
								<i class="fa fa-instagram" aria-hidden="true"></i>
								Instagram
							</a>
						</li>
						<li class="google">
							<a href="#">
								<i class="fa fa-youtube" aria-hidden="true"></i>
									Youtube
								</a>
						</li>
					</ul>
				  </div>
				</div>

			  <div class="footer-2 col-md-3">
				 <div class="footer-dashboard">
					<ul>
						<li><a href="#">Terms & Condition</a></li>
					</ul>
				  </div>
			  </div>

			</div>
		</div>
	</div>
</footer><!-- #colophon -->
<div id="body-loader"></div>
<script src="{{ url('theme/js/jquery-3.2.0.min.js') }}"></script>
<script src="{{ url('theme/js/bootstrap-slider.min.js') }}"></script>
<script src="{{ url('theme/js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('theme/js/jquery.scrolling-tabs.min.js') }}"></script>
<script src="{{ url('theme/js/jquery.countdown.min.js') }}"></script>
<script src="{{ url('theme/js/jquery.flexslider-min.js') }}"></script>
<script src="{{ url('theme/js/jquery.imagemapster.min.js') }}"></script>
<script src="{{ url('theme/js/tooltip.js') }}"></script>
<script src="{{ url('theme/js/bootstrap.min.js') }}"></script>
<script src="{{ url('theme/js/featherlight.min.js') }}"></script>
<script src="{{ url('theme/js/featherlight.gallery.min.js') }}"></script>
<script src="{{ url('theme/js/bootstrap.offcanvas.min.js') }}"></script>
<script src="{{ url('theme/js/main.js') }}"></script>
@yield('js')
</body>
</html>