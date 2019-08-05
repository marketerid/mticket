@extends('dashboard.layout')
@section('title')
    Log Whatsapp Rotator
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @if(Session::has('alert-class'))
                    <div class="alert alert-{{ (Session::get('alert-class') == "success") ? "success" : "danger" }} alert-dismissible alert-mg-b-0" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="notika-icon notika-close"></i></span>
                        </button>
                        {{ Session::get('status') }}
                    </div>
                @endif
                <div class="breadcomb-list">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <div class="breadcomb-wp">
                                <div class="breadcomb-icon">
                                    <i class="notika-icon notika-windows"></i>
                                </div>
                                <div class="breadcomb-ctn">
                                    <h2>Log Whatsapp Rotator</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        </div>
                    </div>

                    <div class="row">
                        {{ Form::open(['url' => url('dashboard/rotate/log/'),'method'   => 'get']) }}
                        <div class="col-lg-2 col-md-2z col-sm-2 col-xs-12">
                            <div class="form-example-int form-example-st">
                                <div class="form-group">
                                    <div class="nk-int-st">
                                        <input type="text" class="form-control input-sm" name="title" placeholder="Rotator Title" value="{{ !empty($filters['title']) ? $filters['title'] : old('title') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-example-int form-example-st">
                                <div class="form-group">
                                    <div class="nk-int-st">
                                        <input type="text" class="form-control input-sm" name="campaign" placeholder="Campaign" value="{{ !empty($filters['campaign']) ? $filters['campaign'] : old('campaign') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-example-int form-example-st">
                                <div class="form-group">
                                    <div class="nk-int-st">
                                        <input type="text" class="form-control input-sm" name="phone" placeholder="CS Phone" value="{{ !empty($filters['phone']) ? $filters['phone'] : old('phone') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-example-int form-example-st">
                                <div class="form-group ic-cmp-int float-lb floating-lb">
                                    <div class="form-ic-cmp">
                                        Event
                                    </div>
                                    <div class="bootstrap-select fm-cmp-mg">
                                        <select class="selectpicker" name="event">
                                            <option value="" {{ (empty($filters['event']) OR $filters['event'] == '') ? "selected" : "" }}>All</option>
                                            <option value="open" {{ (!empty($filters['event']) AND $filters['event'] == 'open') ? "selected" : "" }}>Open Link</option>
                                            <option value="submit" {{ (!empty($filters['event']) AND $filters['event'] == 'submit') ? "selected" : "" }}>Submit Pesan</option>
                                            <option value="copy" {{ (!empty($filters['event']) AND $filters['event'] == 'copy') ? "selected" : "" }}>Copy Nomor WA</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-example-int form-example-st">
                                <div class="form-group">
                                    <div class="nk-int-st">
                                        <input type="text" class="form-control input-sm date" name="date_start" placeholder="Date Start" value="{{ !empty($filters['date_start']) ? $filters['date_start'] : old('date_start') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-example-int form-example-st">
                                <div class="form-group">
                                    <div class="nk-int-st">
                                        <input type="text" class="form-control input-sm date" name="date_end" placeholder="Date End" value="{{ !empty($filters['date_end']) ? $filters['date_end'] : old('date_end') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-example-int pull-right">
                                <button class="btn btn-primary btn-sm notika-btn-success waves-effect">
                                    <i class="fa fa-search"></i> Filter
                                </button>
                                <a href="{{ url('dashboard/rotate/log') }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-close"></i> Reset
                                </a>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="normal-table-list">
                    <div class="bsc-tbl">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-lg-6 col-xs-12">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td>
                                            Total Log
                                        </td>
                                        <td>
                                            {{ $logsCount->count() }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Top 5 Campaign
                                        </td>
                                        <td>
                                            <ul>
                                            @foreach($mostCampaign as $key => $campaign)
                                                <li>
                                                    {{ $key ? $key : "tanpa campaign" }} : {{ $campaign }}
                                                </li>
                                            @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <table class="table table-sc-ex table-striped">
                            <thead>
                            <tr>
                                <th>Rotator Title</th>
                                <th>Phone</th>
                                <th>Name</th>
                                <th>Event</th>
                                <th>Campaign</th>
                                <th>Message</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->rotate->title }}</td>
                                    <td>{{ $log->phone }}</td>
                                    <td>{{ $log->name }}</td>
                                    <td>{{ $log->event }}</td>
                                    <td>{{ $log->campaign }}</td>
                                    <td>
                                        {{ (strlen($log->message) > 20) ? (substr($log->message, 0, 17) . '...') : $log->message }}
                                        <span class="label label-info">
                                            <i class="fa fa-info" data-toggle="tooltip" title="{{ $log->message }}"></i>
                                        </span>
                                    </td>
                                    <td>{{ $log->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="text-center">
                            @if(isset($logs))
                                {!! $logs->appends(Input::except('page'))->links() !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection