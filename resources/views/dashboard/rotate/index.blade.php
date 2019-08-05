@extends('dashboard.layout')
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
                                    <h2>List WA Rotator Saya</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="breadcomb-report">
                                <a title="Tambah Baru" class="btn waves-effect" href="{{ url('dashboard/rotate/form-rotate?wizard=1') }}">
                                    <i class="fa fa-plus"></i> Panduan Tambah WA Rotator
                                </a>
                            </div>
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
                                <th>Slug</th>
                                <th>Total CS</th>
                                <th>Activity Log</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rotates as $rotate)
                                <tr>
                                    <td>{{ $rotate->title }}</td>
                                    <td>{{ $rotate->slug }}</td>
                                    <td>{{ $rotate->subs->count() }}</td>
                                    <td>{{ $rotate->logs->count() }}</td>
                                    <td>
                                        <a href="{{ url('dashboard/rotate/detail-rotate/' . $rotate->id) }}" class="btn btn-xs btn-primary waves-effect" data-toggle="tooltip" title="Lihat Detail">
                                            <i class="fa fa-search"></i>
                                        </a>
                                        <a href="{{ url('dashboard/rotate/form-rotate/' . $rotate->id) }}" class="btn btn-xs btn-warning waves-effect"  data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="{{ url('dashboard/rotate/delete-rotate/' . $rotate->id) }}" class="btn btn-xs btn-danger waves-effect delete" data-toggle="tooltip" title="Hapus">
                                            <i class="fa fa-close"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection