@extends('dashboard.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcomb-list">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <div class="breadcomb-wp">
                                <div class="breadcomb-icon">
                                    <i class="notika-icon notika-windows"></i>
                                </div>
                                <div class="breadcomb-ctn">
                                    <h2>List Transaksi Bank Saya</h2>
                                </div>
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
                                <th>ID</th>
                                <th>Bank</th>
                                <th>Nomor Rekening</th>
                                <th>Nama</th>
                                <th>Transaksi</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Alexandra</td>
                                <td>Christopher</td>
                                <td>@makinton</td>
                                <td>Ducky</td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-primary waves-effect">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="#" class="btn btn-xs btn-danger waves-effect">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection