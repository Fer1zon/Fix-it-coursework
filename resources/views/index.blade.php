@extends('layouts.app')
@section('content')
    <div class="m-0 p-4 shadow col-10 border rounded-end">
        <div class="row align-items-center">
            <div class="col-md-8 text-start">
                <p class="fs-2">
                    Достижения начинаются<br>
                    здесь!<br>
                    Вдохновляйся спортом,<br>
                    достигай цели<br>
                    Подготовься к победе с нами!<br>
                </p>
            </div>
            <div class="col-md-4 text-center">
                <img src="assets/img/protein.png" class="img-fluid" alt="Protein">
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div id="carouselExampleIndicators" class="carousel slide mx-auto" style="max-width: 600px;">
            <div class="carousel-indicators">
                @foreach($advantages as $a)

                    @if($loop->index==0)
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$loop->index}}" class="active"></button>
                    @else
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$loop->index}}"></button>
                    @endif



                @endforeach

            </div>

            <div class="carousel-inner">
                @foreach($advantages as $advantage)
                    @if($loop->index == 0)

                        <div class="carousel-item active">

                            <div class="card pt-5 mx-auto" style="min-height: 400px; width: 100%;">
                                <img src="{{$advantage['img']}}" class="card-img-top w-25 mx-auto" alt="...">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <h4 class="card-title text-center fs-1">{{$advantage['title']}}</h4>
                                    <p class="text-center mb-0 fs-4">{{$advantage['description']}}</p>
                                </div>
                            </div>
                        </div>

                    @else
                        <div class="carousel-item">

                            <div class="card pt-5 mx-auto" style="min-height: 400px; width: 100%;">
                                <img src="{{$advantage['img']}}" class="card-img-top w-25 mx-auto" alt="...">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <h4 class="card-title text-center fs-1">{{$advantage['title']}}</h4>
                                    <p class="text-center mb-0 fs-4">{{$advantage['description']}}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                @endforeach



            </div>


            <!-- Кнопки управления -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
            </button>
        </div>
    </div>



@endsection
