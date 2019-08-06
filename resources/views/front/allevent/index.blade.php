@extends('front.layout')

@section('content')
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
@endsection

@section('js')
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
        $(".load").empty().html('<h3 class="text-center">Gagal ambil data</h3>');
    });
}
</script>
@endsection