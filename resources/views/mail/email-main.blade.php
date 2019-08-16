<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Mticket.asia</title>
    <link rel="stylesheet" href="{{ asset('assets/css/mail.css') }}">
</head>
<body bgcolor="#FFFFFF">

<table class="head-wrap" bgcolor="#ff6600">
    <tr>
        <td></td>
        <td class="header container">
            <div class="content">
                <table>
                    <tr>
                        <td class="title"><a class="a-none" href="{{ url('/') }}" style="color: #fff;">MTICKET.ASIA</a></td>
                        <td align="right"><h6 class="collapse" style="color: #fff;">{{ (isset($title)) ? $title : 'Informasi' }}</h6></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>
    </tr>
</table>

<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">
            <div class="content">
                @yield('main')
            </div>

            <div class="content">
                <table class="social" width="100%">
                    <tr>
                        <td>
                            <table align="left" class="column">
                                <tr>
                                    <td>
                                        <h5 class="">Connect with Us:</h5>
                                        <p class="">
                                            <a href="https://www.facebook.com/importir.org/" class="soc-btn fb">Facebook</a>
                                            <a href="https://www.instagram.com/importirorg/" class="soc-btn ig">Instagram</a>
                                            <a href="https://www.youtube.com/channel/UCm82ZIloMS7lzlqqy2VUgVA" class="soc-btn yt">Youtube</a>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <table align="left" class="column">
                                <tr>
                                    <td>
                                        <h5 class="">Contact Info:</h5>
                                        <p>
                                            Phone: <strong>(021) 22302193 </strong>
                                            <br/>
                                            Email: <strong><a href="mailto:sales@importir.org">info@mticket.asia</a></strong>
                                        </p>
                                        <p>
                                            Green Lake City Ruko Crown Block C no 32,
                                            Barat, Petir, Cipondoh, Tangerang City,
                                            Jakarta 15147
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <span class="clear"></span>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>
    </tr>
</table>

</body>
</html>