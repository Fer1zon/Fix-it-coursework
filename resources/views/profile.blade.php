@extends('layouts.app')
@section('content')

    <div class = "container rounded-3 p-5 d-flex justify-content-around align-items-center" style="background-color: rgb(245, 245, 245); min-height: 20px">

        <img src = "{{asset($user->img)}}" style="max-width: 200px">
        <div class="card-body">
            <form>
                <fieldset disabled>
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Имя</label>

                    <div class="col-md-6">
                        <input id="disabledTextInput" type="text" class="form-control disabled" name="name" value="{{$user->name}}" required autocomplete="name" autofocus>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">Почта</label>

                    <div class="col-md-6">
                        <input id="disabledTextInput" type="email" class="form-control" name="email" value="{{$user->email}}" required autocomplete="email">
                    </div>
                </div>
                </fieldset>
            </form>
        </div>

    </div>

    <div class = "container mt-5">
        <div class = "row g-3">
            @foreach($calls_master as $call_master)


                <div class = "col-12 col-md-12 p-4 rounded-3 text-center" style="background-color: rgb(245, 245, 245)">

                    <table class="table m-0">
                        <thead>
                        <tr>
                            <th scope="col">Услуга</th>
                            <th scope="col">Мастер</th>
                            <th scope = "col">Назначенное время</th>
                            <th scope = "col">Адрес</th>
                            <th scope = 'col'>Цена</th>
                            <th scope="col">Статус</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <th scope = "row">{{$call_master->service_title}}</th>
                                <th scope = "row">{{$call_master->master_name}}</th>
                                <th scope = "row">{{$call_master->date}} {{$call_master->preferred_time}}</th>
                                <th scope = "row">{{$call_master->address}}</th>
                                @if($call_master->status_id == 5)
                                    <th scope="row">Услуга не оказана</th>
                                @else
                                    <th scope="row">{{isset($call_master->finish_price) ? $call_master->finish_price . 'Р': 'Услуга еще не оказана'}}</th>
                                @endif
                                <th scope="row">
                                    <button class = 'btn'>{{$call_master->status_name}}</button>
                                </th>
                            </tr>

                        </tbody>
                    </table>
                    @if($call_master->status_id == 1)
                        <form method="POST" action="{{route('call_decline')}}">
                            @csrf
                            <input type="hidden" value = '{{$call_master->id}}' name = "call_id">
                            <button class = "btn btn-danger mt-1 w-25">Отменить</button>
                        </form>
                    @endif
                    @if($call_master->opportunity_review)
                        <a href = "{{route('send_review_page', [$call_master->service_id, $call_master->master_id])}}"><button class = "btn btn-primary mt-1 w-75">Оставить отзыв</button></a>
                    @endif
                </div>
            @endforeach


        </div>
    </div>


@endsection
