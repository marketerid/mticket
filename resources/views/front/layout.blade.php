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
					<h1 class="site-title"><a href="#" title="myticket" rel="home"><img src="{{ url('assets/img/logo.png') }}" alt="logo"></a></h1>
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
								<li class="active"><a href="{{ url('seminar') }}">Seminar (0)</a></li>
								<li><a href="{{ url('philiphine') }}">Philiphine (0)</a></li>
								<li><a href="{{ url('franchise') }}">Franchise (0)</a></li>
								<li class="cart"><a href="#">0</a></li>
							</ul>
						</div>
					</nav><!-- #site-navigation -->
				</div>
			</div>
		</div>
	</div>
</header><!-- #masthead -->

<section class="section-artist-featured-header">
	<div class="container">
		<div class="section-content">
			<h1>List of available events</h1>
			<p>Total 22 Events</p>
		</div>
	</div>
</section>

<section class="section-artist-content">
	<div class="container">
		<div class="row">
			<div id="primary" class="col-sm-12 col-md-8">
				@foreach ($event as $e)
				<div class="artist-event-item">
					<div class="row">
						<div class="artist-event-item-info col-sm-9">
							<h3>Seminar IMPORTIR.ORG - {{ ucfirst($e->city) }}</h3>
							<ul class="row">
								<li class="col-sm-5">
									<img src="{{ $e->image }}" class="img-fluid" alt="">
								</li>
								<li class="col-sm-7">
									<p>{!! $e->description !!}</p>
								</li>
							</ul>
						</div>
						<div class="artist-event-item-price col-sm-3">
							<span>Price From</span>
							<strong>$83</strong>
							<a href="#">Book Now</a>
						</div>
					</div>
				</div>
				@endforeach
				<div class="artist-event-footer">
					<ul class="pagination">
						<li>
							<a href="#" aria-label="Previous">
								<span aria-hidden="true"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Previous</span>
							</a>
						</li>
						<li><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li class="active"><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li>
							<a href="#" aria-label="Next">
								<span aria-hidden="true">Next <i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			
			<div id="secondary" class="col-sm-12 col-md-4">
				<div class="artist-details">
					<img src="theme/images/artist-img-profile.jpg" alt="image">
					<div class="artist-details-title">
						<h3>Serena Gemez</h3>
						<a href="#">Follow</a>
					</div>
					
					<div class="artist-details-info">
						<h4>About</h4>
						<p>Lorem ipsum dolor sit amet, consectetuer adipi elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
					</div>
				</div>
				
				<div class="related-artist">
					<h3>RELATED ARTISTS</h3>
					<ul class="related-artist-list">
						<li class="related-artist-item">
							<div class="related-artist-img col-md-12 col-lg-4">
								<a href="#"><img src="theme/images/related-artist-1.jpg" alt="image"></a>
							</div>
							<div class="related-artist-info col-md-12 col-lg-8">
								<h4><a href="#">Jason Carpenter</a></h4>
								<a href="#">Follow</a>
							</div>
						</li>
						<li class="related-artist-item">
							<div class="related-artist-img col-md-12 col-lg-4">
								<a href="#"><img src="theme/images/related-artist-2.jpg" alt="image"></a>
							</div>
							<div class="related-artist-info col-md-12 col-lg-8">
								<h4><a href="#">Elizabeth Simmons</a></h4>
								<a href="#">Follow</a>
							</div>
						</li>
						<li class="related-artist-item">
							<div class="related-artist-img col-md-12 col-lg-4">
								<a href="#"><img src="theme/images/related-artist-3.jpg" alt="image"></a>
							</div>
							<div class="related-artist-info col-md-12 col-lg-8">
								<h4><a href="#">Christina Guerrero</a></h4>
								<a href="#">Follow</a>
							</div>
						</li>
						<li class="related-artist-item">
							<div class="related-artist-img col-md-12 col-lg-4">
								<a href="#"><img src="theme/images/related-artist-4.jpg" alt="image"></a>
							</div>
							<div class="related-artist-info col-md-12 col-lg-8">
								<h4><a href="#">Michelle Cunningham</a></h4>
								<a href="#">Follow</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<footer id="colophon" class="site-footer">
	<div class="top-footer">
		<div class="container">
			<div class="row">
				
				<div class="col-md-8">
					<a href="#"><img src="theme/images/logo.png" alt="logo"></a>
				</div>
				<div class="col-md-4">
				
				<p>&copy; 2016 MYTICKET.COM. ALL RIGHTS RESEVED</p>
				</div>
			</div>
			
		</div>
	</div>
	
	<div class="main-footer">
		<div class="container">
			<div class="row">
			  <div class="footer-1 col-md-9">
				<div class="about clearfix">
					<h3>About</h3>
					<ul>
						<li><a href="#">Our Company</a></li>
						<li><a href="#">Careers</a></li>
						<li><a href="#">Advertising</a></li>
						<li><a href="#">Press Room</a></li>
						<li><a href="#">Trademarks</a></li>
						<li><a href="#">Terms of Service</a></li>
						<li><a href="#">Privacy Policy</a></li>
					</ul>
				  </div>
				  
				  <div class="support clearfix">
					<h3>Support and Contact</h3>
					<ul>
						<li><a href="#">Customer Support Contacts</a></li>
						<li><a href="#">Feedback</a></li>
						<li><a href="#">Help</a></li>
						<li><a href="#">Sitemap</a></li>
					</ul>
				  </div>
				  
				  <div class="social clearfix">
					<h3>Stay Connected</h3>
					<ul>
						<li class="facebook">
							<a href="#">
								<i class="fa fa-facebook" aria-hidden="true"></i>
								Facebook
							</a>
						</li>
						<li class="twitter">
							<a href="#">
								<i class="fa fa-twitter" aria-hidden="true"></i>
								Twitter
							</a>
						</li>
						<li class="linkedin">
							<a href="#">
								<i class="fa fa-linkedin-square" aria-hidden="true"></i>
								LinkedIn
							</a>
						</li>
						<li class="google">
							<a href="#">
								<i class="fa fa-google-plus-square" aria-hidden="true"></i>
									Google+
								</a>
						</li>
						<li class="rss">
							<a href="#">
								<i class="fa fa-rss-square" aria-hidden="true"></i>
								RSS
							</a>
						</li>
					</ul>
				  </div>
				</div>

			  <div class="footer-2 col-md-3">
				 <div class="footer-dashboard">
					<h3>MyTicket Dashboard</h3>
					<ul>
						<li><a href="#">Professional</a></li>
						<li><a href="#">Subscriber Login</a></li>
					</ul>
				  </div>
			  </div>

			</div>
		</div>
	</div>
</footer><!-- #colophon -->

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
</body>
</html>