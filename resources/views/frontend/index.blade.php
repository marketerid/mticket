@extends('frontend.layout')

@section('css')
<link rel="stylesheet" href="{{ url('assets/css/daterangepicker.min.css') }}">
@endsection

@section('content')
<header class="masthead">
  <div class="container h-100">
    <div class="row h-100 align-items-center">
      <div class="col-12 text-center">
        <h4 class="font-weight-light"><span class="badge badge-light"> TICKETING PLATFORM</span></h4>
        <h2 class="font-weight-light"><span class="badge badge-warning">Cari Eventmu Sekarang!</span></h2>
        <p class="lead"><span class="badge badge-light"><i class="fa fa-map-marker-alt"></i> Indonesia | Philippines | Thailand</span></p>
      </div>
    </div>
  </div>
</header>
<section class="mt-3 mb-5">
  <div class="container">
    <h1 class="display-5 text-center p-3">FIND YOUR UPCOMING EVENTS HERE</h1><hr>
    <div class="d-sm-flex align-items-center justify-content-between mb-4 p-3">
        <h1 class="h5 mb-2 text-gray-800">EXPLORE OUR EVENTS AND GET YOUR PASS</h1>
        <div class="btn-group">
          <div class="dropdown">
            <button class="btn bg-white border shadow dropdown-toggle mr-md-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-filter"></i> <span id="text-status">Events</span></button>
            <div class="dropdown-menu">
              <a class="dropdown-item btn-sm status" id="0" href="javascript:void(0)">Seminar</a>
              <a class="dropdown-item btn-sm status" id="1" href="javascript:void(0)">Exhibition</a>
              <a class="dropdown-item btn-sm status" id="2" href="javascript:void(0)">Workshop</a>
            </div>
          </div>
          <button class="btn bg-white border shadow" id="reportrange" style="cursor: pointer; padding: 5px 15px; border-radius: .25rem; width: 100%;"><span></span>&nbsp;&nbsp;<i class="fa fa-caret-down"></i></button>
        </div>
    </div>
    <div class="load">
      @if (count($event) > 0)
          @include('frontend.load')
      @else
          <h3 class="text-center">Tidal Ada Event</h3>
      @endif
    </div>
  </div>
</section>
@endsection

@section('js')
<script src="{{ url('assets/js/moment.min.js') }}"></script>
<script src="{{ url('assets/js/daterangepicker.min.js') }}"></script>
<script>
$(document).ready(function() {
    $(document).on('click', '.pagination a',function(event)
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
<script>
function getVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
        vars[key] = value;
    });
    return vars;
}
$(function() {
  var start_date = getVars()["start_date"];
  var end_date = getVars()["end_date"];

  if(start_date == null){
    var start = moment().startOf('month');
    var end = moment();
  } else {
    var start = moment(start_date);
    var end = moment(end_date);
  }

  function cb(start, end) {
      $('#reportrange span').html('<i class="fa fa-calendar"></i>&nbsp;'+start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
      $('input[name=start_date]').val(start.format('YYYY-MM-DD'));
      $('input[name=end_date]').val(end.format('YYYY-MM-DD'));
  }

  $('#reportrange').daterangepicker({
      startDate: start,
      endDate: end,
      "opens": "left",
      "alwaysShowCalendars": true,
      "showCustomRangeLabel": false,
      ranges: {
         'Today': [moment(), moment()],
         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
         'This Month': [moment().startOf('month'), moment().endOf('month')],
         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
  }, cb);

  cb(start, end);

  $('#reportrange').on('apply.daterangepicker', function() {
    $('#form-dashboard').submit();
  });
});
</script>
@endsection