<!DOCTYPE html>
<html>
<head>
  <title>@yield('title','Mticket.asia')</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ url('assets/img/icon.png') }}">
  <link rel="stylesheet" href="{{ url('assets/css/style.min.css') }}">
  <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('assets/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
<style>
.masthead {
  height: 100vh;
  min-height: 500px;
  background-image: url('https://www.startupdelta.org/wp-content/uploads/2018/06/founder-stage-3.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
</style>
@yield('css')
</head>
<body class="bg-light">
<section>
  <nav class="navbar navbar-light bg-white navbar-expand-lg border-bottom fixed-top">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ url('assets/img/logo.png') }}">
      </a>
      <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#menu" aria-expanded="false">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse collapse" id="menu">
        <ul class="navbar-nav ml-auto text-center">
          <li class="nav-item">
              <a href="{{ url('event/seminar') }}" class="nav-link text-dark">Seminar <span class="badge badge-pill badge-warning">15</span></a>
          </li>
          <li class="nav-item">
            <a href="{{ url('event/exhibition') }}" class="nav-link text-dark">Philiphine <span class="badge badge-pill badge-warning">3</span></a>
          </li>
          <li class="nav-item">
            <a href="{{ url('event/workshop') }}" class="nav-link text-dark">Franchise <span class="badge badge-pill badge-warning">1</span></a>
          </li>
          <li class="nav-item mb-1 ml-md-3">
            <a href="{{ url('contact-us') }}" class="btn btn-primary"><i class="fa fa-phone"></i> Contact Us</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</section>
<section>
@yield('content')
</section>
<footer class="sticky-footer" style="background-color: #1a237e;">
  <div class="container my-auto">
    <div class="row mt-3 mb-5">
      <div class="col-md-3">
        <h5 class="text-warning">Address</h5>
        <p class="text-white">Green Lake City Ruko Crown Block D no 17, Petir, Cipondoh, Kota Tangerang, 15147</p>
      </div>
      <div class="col-md-3">
        <h5 class="text-warning">Contacts</h5>
        <p class="text-white">
          <a href="mailto:info@mticket.asia" class="text-white">Email: info@mticket.asia</a><br>
          <a href="tel:02122302193" class="text-white">Phone: 021-22302193</a>
        </p>
      </div>
      <div class="col-md-3">
        <h5 class="text-warning">Others</h5>
        <p class="text-white">
          <a href="Terms and Conditions" class="text-white">Terms and Conditions</a><br>
          <a href="Refund Policy" class="text-white">Refund Policy</a>
        </p>
      </div>
      <div class="col-md-3">
        <h5 class="text-warning">Social Media</h5>
        <a href="https://facebook.com" class="btn btn-warning btn-circle text-dark"><i class="fab fa-facebook-f"></i></a>
        <a href="https://instagram.com" class="btn btn-warning btn-circle text-dark"><i class="fab fa-instagram"></i></a>
        <a href="https://youtube.com" class="btn btn-warning btn-circle text-dark"><i class="fab fa-youtube"></i></a>
      </div>
    </div>
    <div class="copyright text-center my-auto border-top text-white pt-4">
      <span>Copyright &copy; Mticket.asia 2019</span>
    </div>
  </div>
</footer>
<div id="body-loader"></div>
<script src="{{ url('assets/js/jquery.min.js') }}"></script>
<script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
@yield('js')
</body>
</html>