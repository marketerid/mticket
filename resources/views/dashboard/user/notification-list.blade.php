@extends('dashboard.layout')
@section('title') Notifikasi User @endsection
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
                                    <h2>List Notifikasi Saya</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="normal-table-list">
                    <div class="bsc-tbl">
                        <table class="table table-sc-ex table-striped">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Link</th>
                                <th>Terbaca</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($notifications as $notification)
                                <tr>
                                    <td>{{ $notification->title }}</td>
                                    <td>{{ url($notification->link) }}</td>
                                    <td>{!! !is_null($notification->read_at) ? '<span class="label label-info">Terbaca</span>' : '<span class="label label-warning">Belum</span>' !!}</td>
                                    <td>
                                        <a href="{{ url('dashboard/user/notification/' . $notification->id) }}" class="btn btn-xs btn-primary waves-effect">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </td>
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