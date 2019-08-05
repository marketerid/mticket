@extends('frontend.layout')
@section('title')
    Contact CS {{ $operator->name }} Whatsapp
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $('#copy').on('click', function (e) {
                myFunction();
            });

            $('#submit').on('click', function(e){
                e.preventDefault();
                let redirect    = $(this).attr('href');
                let newThis     = $(this);

                window.location.href    = redirect;

                /*$.ajax({
                    url: '',
                    type: 'GET',
                    beforeSend: function(){
                        newThis.attr('disabled', true);
                        newThis.text('Loading...');
                    },
                    success: function(response){
                        console.log(response);
                        window.location.href    = redirect;
                        return;
                    },
                    error: function (xhr) {
                        window.location.href    = redirect;
                        return;
                    }
                });*/
            });

            setTimeout(function () {
                //viewPage();
            }, 5000);

            function viewPage() {
                $.ajax({
                    url: '',
                    type: 'GET',
                    success: function(response){
                        console.log(response)
                    }
                });
            }

            function myFunction() {
                var range = document.createRange();
                range.selectNode(document.getElementById("phone"));
                window.getSelection().removeAllRanges(); // clear current selection
                window.getSelection().addRange(range); // to select text
                document.execCommand("copy");
                window.getSelection().removeAllRanges();// to deselect

                alert("No Whatsapp telah di Copy " + $('#phone').text());
                copyLog();
            }

            function copyLog(){
                $.ajax({
                    url: '',
                    type: 'GET',
                    success: function(response){
                        console.log(response)
                    }
                });
            }
        })
    </script>
    {!! $form->javascript !!}
    @if($form->google_analytic != '')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $form->google_analytic }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ $form->google_analytic }}');
        </script>
    @endif

    @if($form->facebook_pixel_id != '')
        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $form->facebook_pixel_id }}');
            fbq('track', '{{ $form->facebook_pixel_event ? $form->facebook_pixel_event : 'PageView' }}');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                 src="https://www.facebook.com/tr?id={{ $form->facebook_pixel_id }}&ev={{ $form->facebook_pixel_event ? $form->facebook_pixel_event : 'PageView' }}&noscript=1"/>
        </noscript>
    @endif

@endsection

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="img-container">
                        <img src="{{ $operator->avatar_link }}" class="img img-rounded img-sm avatar center"/>
                        <div class="content">
                            <p class="center">{{ $operator->name }}</p>
                        </div>
                    </div>

                    <h4 class="text-center" id="phone">{{ $operator->phone_text }}</h4>
                    <button type="button" class="btn btn-info btn-sm center" id="copy">
                        <i class="fas fa-copy"></i> Copy Nomor Whatsapp
                    </button>
                    <br/>
                    <br/>
                    <p>
                        Anda akan mengirim pesan :
                    </p>
                    <div class="alert alert-success" role="alert">
                        {{ $message }}
                    </div>
                    <div class="text-center">
                        <a id="submit" href="https://api.whatsapp.com/send?phone={{ $operator->phone }}&text={{ $message }}" class="btn btn-warning" role="button">
                            <img src="{{ asset('frontend/images/output-onlinepngtools.png') }}" class="img" style="max-width: 30px"/>
                            Kirim Pesan via Whatsapp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection