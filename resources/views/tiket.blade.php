@extends('layouts.basic')
@section('data-layer')
    @if($hasTiket)
        <script type="text/javascript">
            var dataLayer = [
                {
                    'email': '{{ $result->email }}',
                    'invoice': '{{ $result->invoice }}',
                    'total': '{{ $result->total }}',
                    'pageType': "tiket"
                }
            ];
        </script>
    @endif

@endsection
@section('content')
    <!-- END PARALLAX SECTION -->
    <div id="pendaftaran" class="page340 section  pendaftaran rnr-portfolio">
        <!-- SECTION -->
        <div class="rnr-offset" data-section="pendaftaran"></div>
        <div class="container">
            <div class="row">
                <div data-effect="fadeInUp" class="rnr-animate animated sixteen columns">
                    <!-- START TITLE -->
                    <div class="title">
                        <h1 class="header-text">Download Tiket Seminar</h1>
                    </div>
                    <!-- END TITLE -->
                </div>
                <!-- END SIXTEEN COLUMNS -->
                <div class="fancy-header2">
                    @if(!$hasTiket)
                        <h4>Maaf tiket Anda tidak valid, silahkan periksa email Anda untuk link yang valid. Jika tetap menemui error harap hubungi Admin/CS</h4>
                        <br/>
                    @else
                        <h4>Silahkan download menggunakan link dibawah ini</h4>
                        <h2 class="highlight">
                            <a href="{{ $download }}"  target="_blank">
                                Download
                            </a>
                        </h2>
                    @endif
                </div>
            </div>
            <!-- END ROW -->
        </div>
        <!-- END CONTAINER -->
        <div class="container">
            <div data-effect="fadeInUp" class="sixteen columns rnr-animate animated">

                <div class="clear"></div>
            </div>
        </div>
    </div>
    <!--END SECTION -->

@endsection