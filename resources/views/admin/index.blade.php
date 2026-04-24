@extends('layouts.app')

@section('content')

    <div class = "row g-3 text-center">

        <div class = "col-md-4">
            <h5 class = "text-primary">Количество мастеров</h5>
            <p class = "text-muted">{{$masters_count}}</p>
        </div>

        <div class = "col-md-4">
            <h5 class = "text-primary">Количество пользователей</h5>
            <p class = "text-muted">{{$users_count}}</p>
        </div>

        <div class = "col-md-4">
            <h5 class = "text-primary">Количество вызванных мастеров</h5>
            <p class = "text-muted">{{$calls_count}}</p>
        </div>

        <div class = "col-md-4">
            <h5 class = "text-primary">Средний рейтинг всех мастеров</h5>
            <p class = "text-muted">{{round($average_rating, 1)}}</p>
        </div>

        <div class = "col-md-4">
            <h5 class = "text-primary">Последний совершенный вызов</h5>
            <p class = "text-muted">{{$last_call}}</p>
        </div>



    </div>

    <div class = "row g-3">
        <a href = "{{route("masters_manage")}}" class = "col-lg-4"><h2>Управление мастерами</h2></a>
        <a href = "{{route("admin_categories")}}" class = "col-lg-4"><h2>Управление категориями и услугами</h2></a>
        <a href = "{{route("admin_calls_master")}}" class = "col-lg-4"><h2>Управление заказами</h2></a>
        <a href = "{{route("admin_users")}}" class = "col-lg-4"><h2>Управление пользователями</h2></a>
    </div>

@endsection
