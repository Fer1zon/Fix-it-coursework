@extends('layouts.app')
@section('content')

    <table class = "table m-3">
        <thead>
            <tr>
                <th scope = "col">ID</th>
                <th scope = "col">Имя</th>
                <th scope = "col">Изображение</th>
                <th scope = "col">Действия</th>
            </tr>
        </thead>

        <tbody>
            @foreach($categories as $category)

                <form action="{{route("admin_update_category")}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <tr>
                        <th scope = "row"><input type = "text" value = "{{$category->id}}" class = "disabled form-control" name = "id" readonly></th>
                        <th scope = "row"><input type = "text" value="{{$category->title}}" class = "form-control" name = "name"></th>
                        <th scope = "row">
                            <img style = "max-width: 100px;" src = "{{Storage::url($category->img)}}">
                            <input type = "file" name = "img">
                        </th>
                        <th scope = "row">
                            <button class = "btn btn-warning" type = "submit">Сохранить</button>
                            <a href = "{{route("admin_delete_category", [$category->id])}}"><button type = "button" class = "btn btn-danger">Удалить</button></a>
                            <a href = "{{route("admin_services", [$category->id])}}"><button type = "button" class = "btn btn-primary">Услуги в категории</button></a>
                        </th>
                    </tr>
                </form>
            @endforeach

            <form action="{{route("admin_create_category")}}" method="POST" enctype="multipart/form-data">
                @csrf
                <tr>
                    <th scope = "row"><input type = "text" value = "" class = "disabled form-control" name = "id" disabled></th>
                    <th scope = "row"><input type = "text" value="" class = "form-control" name = "name"></th>
                    <th scope = "row">
                        <input type = "file" name = "img">
                    </th>
                    <th scope = "row">
                        <button class = "btn btn-success" type = "submit">Создать</button>
                    </th>
                </tr>
            </form>
        </tbody>
    </table>

@endsection
