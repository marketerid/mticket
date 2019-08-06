<!DOCTYPE html>
<html>
<head>
	<title>Mticket.asia</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
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
	<link rel="stylesheet" href="{{ url('theme/css/responsive.css') }}">
<style>
#body-loader {
    position:fixed;
    width:100%;
    left:0;right:0;top:0;bottom:0;
    background-color: rgba(255,255,255,0.7);
    z-index:9999;
    display:none;
}

@-webkit-keyframes spin {
    from {-webkit-transform:rotate(0deg);}
    to {-webkit-transform:rotate(360deg);}
}

@keyframes spin {
    from {transform:rotate(0deg);}
    to {transform:rotate(360deg);}
}

#body-loader::after {
    content:'';
    display:block;
    position:absolute;
    left:48%;top:40%;
    width:40px;height:40px;
    border-style:solid;
    border-color:black;
    border-top-color:transparent;
    border-width: 4px;
    border-radius:50%;
    -webkit-animation: spin .8s linear infinite;
    animation: spin .8s linear infinite;
}
</style>
</head>
<body>
<header id="masthead" class="site-header fix-header header-3">
	<div class="top-header">
		<div class="container">
			<div class="row">
				<div class="top-left">
					<ul>
						<li>
							<a href="tel:02122302193">
								<i class="fa fa-phone"></i>
								021-22302193
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
	<div class="main-header">
		<div class="container">
			<div class="row">
				<div class="site-branding col-md-3">
					<h1 class="site-title"><a href="{{ url('/') }}" title="myticket" rel="home"><img src="{{ url('assets/img/logo.png')}}" alt="logo"></a></h1>
				</div>

				<div class="col-md-9">
					<nav id="site-navigation" class="navbar">
						<div class="navbar-header">
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
								<li><a href="{{ url('event/seminar') }}">Seminar (0)</a></li>
								<li><a href="{{ url('event/philiphine') }}">Philiphine (0)</a></li>
								<li><a href="{{ url('event/franchise') }}">Franchise (0)</a></li>
								<li class="cart"><a href="#">0</a></li>
							</ul>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</div>
</header>
<section class="hero-2">
	<div class="container">
		<div class="row">
			<div class="hero-content">
				<p class="hero-caption">TICKETING <span>FLATFORM</span></p>
				<h1 class="hero-title">Cari Eventmu Sekarang!</h1>
				<ul class="count-down"></ul>
				<div class="hero-location">
					<p><i class="fa fa-map-marker" aria-hidden="true"></i> Indonesia | Philippines | Thailand</p>
				</div>
				<div class="hero-purchase-ticket">
					<a href="{{ url('event') }}">VIEW EVENTS</a>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="section-refine-search">
	<div class="container">
		<div class="row">
			<form>
				<div class="keyword col-sm-6 col-md-4">
					<label>Search Keyword</label>
					<input type="text" class="form-control hasclear" placeholder="Search">
					<span class="clearer"><img src="images/clear.png" alt="clear"></span>
				</div>
				<div class="location col-sm-6 col-md-3">
					<label>Location</label>
					<select class="selectpicker dropdown">
					  <option>Select Location</option>
					  <option>San Francisco</option>
					  <option>Foxborough </option>
					  <option>Buffalo</option>
					  <option>Auburn Hills</option>
					</select>
				</div>
				<div class="event-date col-sm-6 col-md-3">
					<label>Event Date</label>
					<select class="selectpicker dropdown">
					  <option>Select Date</option>
					  <option>August 1st, 2016</option>
					  <option>August 2nd, 2016</option>
					  <option>August 3rd, 2016</option>
					  <option>August 4th, 2016</option>
					</select>
				</div>
				<div class="col-sm-6 col-md-2">
					<input type="submit" value="Search">
				</div>
			</form>
		</div>
	</div>
</section>

<section class="section-search-content">
	<div class="container">
		<div class="row">
			<div id="secondary" class="col-md-4 col-lg-3">
				<div class="search-filter">
					<div class="search-filter-delivery">
						<h3>Type</h3>
						<div class="checkbox">
							<input id="delivery1" class="styled" type="checkbox" checked="">
							<label for="delivery1">Seminar</label>
						</div>
						<div class="checkbox">
							<input id="delivery2" class="styled" type="checkbox">
							<label for="delivery2">Philiphine</label>
						</div>
						<div class="checkbox">
							<input id="delivery3" class="styled" type="checkbox">
							<label for="delivery3">Franchise</label>
						</div>
					</div>
					<div class="search-filter-category">
						<h3>City</h3>
						<div class="checkbox">
							<input id="category1" class="styled" type="checkbox" checked="">
							<label for="category1">Jakarta</label>
						</div>
						<div class="checkbox">
							<input id="category2" class="styled" type="checkbox">
							<label for="category2">Bandung</label>
						</div>
						<div class="checkbox">
							<input id="category3" class="styled" type="checkbox">
							<label for="category3">Bogor</label>
						</div>
					</div>
					<div class="search-filter-seat-features">
						<h3>Month</h3>
						<div class="checkbox">
							<input id="features1" class="styled" type="checkbox" checked="">
							<label for="features1">January</label>
						</div>
						<div class="checkbox">
							<input id="features2" class="styled" type="checkbox">
							<label for="features2">February</label>
						</div>
						<div class="checkbox">
							<input id="features3" class="styled" type="checkbox">
							<label for="features3">Maret</label>
						</div>
						<div class="checkbox">
							<input id="features4" class="styled" type="checkbox">
							<label for="features4">April</div>
						<div class="checkbox">
							<input id="features5" class="styled" type="checkbox">
							<label for="features5">Mei</label>
						</div>
					</div>
				</div>
			</div>
			<div id="primary" class="col-md-8 col-lg-9">
				<div class="search-result-header">
					<div class="row">
						<div class="col-sm-7">
							<h2>All Sports Events at San Francisco</h2>
							<span>Showing 1-10 of 32 Results</span>
						</div>
						<div class="col-sm-5">
							<label>Sort By</label>
							<select class="selectpicker dropdown">
							  <option>Terdekat</option>
							  <option>Terlama</option>
							</select>
						</div>
					</div>
				</div>
				<div class="load">
			      @if (count($event) > 0)
			          @include('front.load')
			      @else
			          <h3 class="text-center">Tidal Ada Event</h3>
			      @endif
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
					<a href="#"><img src="{{ url('theme') }}/images/logo.png" alt="logo"></a>
				</div>
				<div class="col-sm-4 col-md-4">
				
				<p>&copy; 2019 MTICKET.ASIA. ALL RIGHTS RESEVED</p>
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
</footer>
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
<script>
$(document).ready(function() {
    $(document).on('click', '.click-pagination',function(event)
    {
        event.preventDefault();
        $('#body-loader').fadeIn("slow");
        $('.tbody').hide();
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        var page = $(this).attr('href');
        getData(page);
    });
});

function getData(page){
    $.ajax(
    {
        url: page,
        type: "get",
        datatype: "html"
    }).done(function(data){
        $('#body-loader').hide();
        $(".load").empty().html(data);
    }).fail(function(jqXHR, ajaxOptions, thrownError){
        $('#body-loader').hide();
        $(".load").empty().html('<h3 class="text-center">Tidak Ada Data</h3>');
    });
}
</script>
</body>
</html>