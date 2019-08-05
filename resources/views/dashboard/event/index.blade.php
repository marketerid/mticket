@extends('dashboard.layout')

@section('title', 'Events - Mticket.asia')

@section('content')
<div class="container-fluid dashboard">
    @if(Session::has('alert'))
    <div class="alert bg-{{ (Session::get('alert') == "success") ? "success" : "danger" }} text-white alert-dismissible fade show" role="alert">
        <b>{{ Session::get('message') }}</b>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 flex-grow-1">Events</h1>
        <div class="btn-group">
          <div class="dropdown">
            <button class="btn bg-white border shadow dropdown-toggle" id="bg-event" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-calendar-check"></i> <span id="text-event">Events</span></button>
            <div class="dropdown-menu">
              <button class="dropdown-item btn-event" id="seminar">Seminar</button>
              <button class="dropdown-item btn-event" id="exhibition">Exhibition</button>
              <button class="dropdown-item btn-event" id="workshop">Workshop</button>
            </div>
          </div>&nbsp;
          <div class="dropdown">
            <button class="btn bg-white border shadow dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-filter"></i> <span id="text-status">Status</span></button>
            <div class="dropdown-menu">
              <button class="dropdown-item btn-status" id="0">Aktif</button>
              <button class="dropdown-item btn-status" id="1">Non Aktif</button>
            </div>
          </div>&nbsp;
          <button class="btn bg-white border shadow" id="reportrange" style="border-radius: .25rem; width: 100%;"><span></span>&nbsp;&nbsp;<i class="fa fa-caret-down"></i></button>
        </div>&nbsp;
        <form method="GET" id="form-search">
          <input type="hidden" name="event" value="">
          <input type="hidden" name="status" value="">
          <input type="hidden" name="start_date" value="">
          <input type="hidden" name="end_date" value="">
          <button type="submit" class="btn btn-primary border shadow"><i class="fas fa-search"></i></button>
        </form>
        <a href="{{ url('dashboard/event/create') }}" class="btn btn-success border shadow"><i class="fas fa-plus"></i> Create</a>
    </div>
    <div class="row">
        <div class="col load">
            @if (count($event) > 0)
                @include('dashboard.event.load')
            @else
                <h3 class="text-center text-muted mt-3 mb-3"><i class="fas fa-info-circle"></i> No Data Available</h3>
            @endif
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function() {
  function getResult(page){
    var event = $('input[name=event]').val();
    var status = $('input[name=status]').val();
    var start_date = $('input[name=start_date]').val();
    var end_date = $('input[name=end_date]').val();
    $.ajax({
      url: window.location,
      method: "get",
      data: {
        page: page,
        event: event,
        status: status,
        start_date: start_date,
        end_date: end_date
      }
    }).done(function(data){
        $('#body-loader').hide();
        $(".load").empty().html(data);
    }).fail(function(jqXHR, ajaxOptions, thrownError){
        $('#body-loader').hide();
        $(".load").empty().html('<h3 class="text-center">Tidak Ada Data</h3>');
    });
  }

  $(document).on('click', '.pagination a',function(e) {
      e.preventDefault();

      $('#body-loader').fadeIn("slow");
      $('.tbody').hide();
      $('li').removeClass('active');
      $(this).parent('li').addClass('active');

      var page = varLink($(this).attr('href'), 'page');
      window.history.pushState(null, null, url);
      getResult(page);
  });

  $(document).on('click', '.btn-event', function(e){
    e.preventDefault();
    $('input[name=event]').val($(this).attr("id"));
    $('#text-event').text($(this).text());
    $("#bg-event").attr('bg-white', 'bg-success');
  });

  $(document).on('click', '.btn-status', function(e){
    e.preventDefault();
    $('input[name=status]').val($(this).attr("id"));
    $('#text-status').text($(this).text());
    $('#body-loader').fadeIn("slow");
    $('.tbody').hide();
    getResult();
  });

  var start_date = varUrl()["start_date"];
  var end_date = varUrl()["end_date"];

  if(start_date == null){
    var start = moment().startOf('year');
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
    $('#body-loader').fadeIn("slow");
    $('.tbody').hide();
    getResult();
  });
});
</script>

<script>
$(document).on('click', '.delete', function(){
    var id = $(this).attr('id');
    $('#all-modal').modal('show');
    $('.modal-title').text('Are You Sure?');
    $('.modal-body').text('Data will be deleted after clicking OK');
    $('#modal-url').attr("href", "{{ route('event.delete') }}?id="+id);
});
</script>
@endsection