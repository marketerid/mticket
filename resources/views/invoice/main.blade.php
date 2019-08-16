<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice - Mticket.asia</title>
    <link rel="stylesheet" href="{{ asset('assets/css/invoice.css') }}"/>
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <h2>Mticket.asia</h2>
    </div>
    <h1>{{ $user->invoice }}</h1>
    <div id="company" class="">
        <div>Mticket.asia</div>
        <div>
            Green Lake City<br/>
            Ruko Crown Block D-17<br/>
            Cipondoh, Tangerang City,<br/>
            Jakarta 15147
        </div>
        <div>(021) 22302193</div>
        <div><a href="mailto:sales@importir.org">info@mticket.asia</a></div>
    </div>
    <div id="project">
        <div><span>Service</span> Event</div>
        <div><span>Name</span> {{ $user->name }}</div>
        <div><span>Phone</span> {{ $user->phone }}</div>
        <div><span>Email</span> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></div>
        <div><span>Status</span> {{ ($user->status == 'PAID') ? "LUNAS" : "BELUM LUNAS" }}</div>
    </div>
</header>
@yield('main')

<footer>
    Invoice was created on a computer and is valid without the signature and seal.
</footer>
</body>
</html>