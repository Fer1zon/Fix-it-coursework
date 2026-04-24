@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@section('content')

    <div class = "container">
        <div class = "row g-3">

            <div class = "col-12 col-md-12 d-flex justify-content-center">
                <img src = "{{Storage::url($master_data->img)}}" class = "col-4">
                <div class = "col-8 ms-4 align-items-center">
                    <h3 style="font-family: 'Fira-Sans-Condensed-Black'; font-weight: lighter; font-size: 46px">{{$master_data->name}}</h3>
                    @if($master_data->rating != 0)
                        <div class="card-body d-flex align-items-center">
                            <span class="ms-1 text-muted fs-4">{{$master_data->rating}}</span>
                            <i class="bi bi-star-fill ms-1"></i>
                        </div>
                    @endif
                    <h3 style="font-family: 'Fira-Sans-Condensed-Black'; font-size: 26px">Оказываю услуги:</h3>
                    <div class = 'd-flex flex-wrap justify-content-start'>
                        @forelse($services as $service)

                            <div class = "ms-3">
                                <a href = "{{route('call_master_page', [$service->service_id, $master_data->id])}}"><h3 style="font-size: 22px">{{$service->service_title}}</h3></a>
                            </div>

                        @empty
                            <p>Мастер пока не оказывает услуг</p>
                        @endforelse

                    </div>

                </div>
            </div>

            @if($reviews->isNotEmpty())
                <div class = "col-12 col-md-12 row g-3">
                    @foreach($reviews as $review)
                        <div class = "col-12 col-md-12 d-flex justify-content-start shadow p-4 rounded-3">
                            <img src = "{{asset($review->user_img)}}" class = 'col-1' style="height: auto; max-height: 80px; width: auto; object-fit: contain;">
                            <div class="container col-11 ms-1 p-1">
                                <div class="d-flex justify-content-start align-items-center">
                                    <h1 style="font-size: 26px; font-family: Fira-Sans-Condensed-Black; margin: 0; line-height: 1;">
                                        {{$review->user_name}}
                                    </h1>

                                    <div class="d-flex align-items-center ms-2">
                                        <span class="text-muted fs-4" style="line-height: 1;">{{$review->review_value}}</span>
                                        <i class="bi bi-star-fill ms-1" style="line-height: 1;"></i>
                                    </div>
                                </div>
                                <p style="font-size: 18px; font-family: Fira-Sans-Condensed-Black; width: 100%; margin-top: 0.5rem;">
                                    {{$review->review_comment}}
                                </p>
                            </div>
                        </div>

                    @endforeach


                </div>
            @else
                <div class="container text-center mt-5">
                    <p class = 'text-muted'>Отзывов нет!</p>
                </div>
            @endif

        </div>

    </div>

@endsection
