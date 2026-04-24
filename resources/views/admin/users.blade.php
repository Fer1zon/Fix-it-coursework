@extends('layouts.app')

@section('content')

    <table class = "table">

        <thead>
            <tr>
                <th scope = "col">ID</th>
                <th scope = "col">Имя</th>
                <th scope = "col">Почта</th>
                <th scope = "col">Роль</th>
                <th scope ="col">Действия</th>
            </tr>
        </thead>

        <tbody>
            @foreach($users as $user)
                <form method="POST" action="{{route("admin_update_user")}}">
                    @csrf
                    <tr>
                        <th scope = "row">
                            <input class = "form-control disabled" value="{{$user->id}}" name = "id" readonly>
                        </th>

                        <th scope = "row">
                            <input class = "form-control disabled" value="{{$user->name}}" disabled>
                        </th>

                        <th>
                            <input class = "form-control disabled" value = "{{$user->email}}" disabled>
                        </th>

                        <th>
                            <select class = "form-select" name = "role_id" id="inputGroupSelect01">

                                @foreach($roles as $role)
                                    @if($role->id == $user->role_id)
                                        <option selected value = "{{$role->id}}">{{$role->name}}</option>
                                    @else
                                        <option value = "{{$role->id}}">{{$role->name}}</option>
                                    @endif
                                @endforeach

                            </select>
                        </th>
                        <th>
                            <button type = "submit" class = "btn btn-warning">Сохранить</button>
                        </th>
                    </tr>
                </form>
            @endforeach
        </tbody>

    </table>

@endsection
