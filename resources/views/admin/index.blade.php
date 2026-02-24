@extends('layouts.app')

@section('content')

    <div class ="container py-1">
        <table class = "table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Почта</th>
                    <th scope="col">Создан</th>
                    <th scope="col">Роль</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <th>{{$user->name}}</th>
                        <th>{{$user->email}}</th>
                        <th>{{$user->created_at}}</th>
                        <th>{{$user->role_name}}</th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
