<!DOCTYPE html>
<html>
<head>
  <title>@yield('title','Dashboard - Mticket.asia')</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="{{ url('assets/img/icon.png') }}">
  <link rel="stylesheet" href="{{ url('assets/css/style.min.css') }}">
	<link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ url('assets/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ url('assets/css/daterangepicker.min.css') }}">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
<style>
.dashboard {
  margin-top: 95px;
}
</style>
  @yield('css')
</head>
<body id="page-top" class="sidebar-toggled">
  <div id="wrapper">
    <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion toggled" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laptop-code"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Edu-tech <sup>ID</sup></div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="{{ url('dashboard') }}">
          <i class="fas fa-fw fa-home"></i>
          <span>Dashboard</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('dashboard/event') }}">
          <i class="fas fa-fw fa-person-booth"></i>
          <span>Event</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('dashboard/registration') }}">
          <i class="fas fa-fw fa-users"></i>
          <span>Registration</span></a>
      </li>
      <hr class="sidebar-divider d-none d-md-block">
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 fixed-top shadow">
          <button id="sidebarToggleTop" class="btn d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <a class="navbar-brand" href="{{ url('dashboard') }}">
            <img src="{{ url('assets/img/logo.png') }}">
          </a>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item no-arrow mx-1 d-none d-sm-inline-block fullscreen">
              <a class="nav-link" href="#" role="button">
                <i class="fas fa-expand fa-fw"></i>
              </a>
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Muhamad Ridwan</span>
                <img class="img-profile rounded-circle" src="{{ url('assets/img/profile.png')}}">
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#all-modal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        @yield('content')
      </div>
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Mticket.asia 2016-2019 All right reserved</span>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <div class="modal fade" id="all-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-danger" id="modal-url" href="/">Ok</a>
        </div>
      </div>
    </div>
  </div>
<div id="body-loader"></div>
<script src="{{ url('assets/js/jquery.min.js') }}"></script>
<script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('assets/js/jquery.easing.min.js') }}"></script>
<script src="{{ url('assets/js/moment.min.js') }}"></script>
<script src="{{ url('assets/js/daterangepicker.min.js') }}"></script>
<script src="{{ url('assets/js/sb-admin.min.js') }}"></script>
<script src="{{ url('assets/js/chart.min.js') }}"></script>
@yield('js')
</body>
</html>