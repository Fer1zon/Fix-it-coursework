@extends('layouts.app')
@section('content')

    <div class = "container-fluid vh-100 d-flex justify-content-center align-items-center">
        <img class = "w-100 h-100 rounded-4" src = "assets/img/baner.jpg">
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
            <h1 style = "font-family: 'Fira-Sans-Condensed-Black'; font-weight: lighter; font-size: 48px">FIX-IT - Команда которая берет все заботы по дому на себя</h1>
            <p class="lead" style = "font-family: 'Fira-Sans-Condensed-Black'; font-weight: lighter; font-size: 36px">Будем у вас уже через 30 минут!</p>
        </div>
    </div>

    <div class="container d-flex justify-content-center mt-4">
        <h1 style="font-family: 'Fira-Sans-Condensed-Black'; font-size: 64px">Мы занимаемся ремонтом</h1>
    </div>
    <div class="container">
        <div class="row g-3">
            @foreach($services as $service)

                <div class="col-12 col-md-6">
                    <a href = "{{route('catalog')}}" class="nav-link">
                    <div class="d-flex justify-content-around p-3 align-items-center rounded-3" style="background-color: rgb(217, 217, 217)">
                        <img class="col-1" src="{{$service['img']}}">
                        <p class="col-8 mb-0" style="font-family: 'Fira-Sans-Condensed-Black'; font-weight: lighter; font-size: 32px">{{$service['title']}}</p>
                    </div>
                    </a>
                </div>

            @endforeach



        </div>
    </div>



@endsection
