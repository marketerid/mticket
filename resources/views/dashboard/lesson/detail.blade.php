@extends('dashboard.layout')

@section('title', 'Edit Learn - Edu-tech.id')

@section('content')
<div class="container-fluid dashboard">
    <div class="row">
        <div class="col-md-4 p-0">
            <div class="card">
                <h3>Deatil {{ $learn->title }}</h3>
            </div>
        </div>
        <div class="col-md-8">
            <h3>List {{ $learn->title }}</h3>
            @foreach ($learn->lesson as $l)
                <ul>
                    <li>{{ $l->id }}. {{ str_slug($l->title) }} <a href="{{url('dashboard/learn/phps/welcome')}}">Klik</a></li>
                </ul>
            @endforeach
        </div>
    </div>
</div>
@endsection