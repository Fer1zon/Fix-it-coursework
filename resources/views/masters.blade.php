@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@section('content')
    <div class="container mb-5">
        <div class="row g-4">
            @forelse($masters as $master)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">

                    <div class="card h-100 shadow-sm">
                        <a href = "{{route('master_page', [$master->id])}}">
                        <img src="{{Storage::url($master->img)}}"
                             class="card-img-top"
                             alt="{{$master->name}}"
                             style="height: 200px; object-fit: cover;">
                        </a>
                        <div class="card-body text-center">
                            <h5 class="card-title">{{$master->name}}</h5>
                            <div class="mb-2">
                                <div class="d-flex justify-content-center gap-1 text-warning">
{{--                                    Интересно--}}
                                    @for($i = 1; $i <= round($master->rating); $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor
                                    @if($master->rating == 0)
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    @endif
                                </div>

                                <span class="ms-1 text-muted">{{$master->rating != 0 ? round($master->rating, 1) : 'Нет отзывов'}}</span>

                            </div>
                            <a href = "{{route("call_master_page", [$service_id, $master->id])}}">
                            <button class="btn btn-primary w-100">
                                <i class="bi bi-telephone"></i> Вызвать, от {{$master->price}}Р
                            </button>
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <p class="text-center text-muted py-4">Эту услугу пока не оказывает не один мастер!</p>
            @endforelse
        </div>
    </div>
@endsection
