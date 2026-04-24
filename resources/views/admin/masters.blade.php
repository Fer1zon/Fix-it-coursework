@extends("layouts.app")

@section("content")

    <table class = "table m-3">
        <thead>
            <tr>
                <th scope = "col">ID</th>
                <th scope = "col">Имя</th>
                <th scope = "col">Средний рейтинг</th>
                <th scope = "col">Кол-во вызовов</th>
                <th scope="col">Изображение</th>
                <th scope = "col">Возможные действия</th>
            </tr>
        </thead>

        <tbody>
        @foreach($masters as $master)
            <form method="post" action="{{route("master_update")}}" enctype="multipart/form-data">
                @csrf
                <tr>
                    <th scope = "row"><input type="text" class="form-control disabled" name = "id" value = "{{$master->id}}" readonly></th>
                    <th scope = "row"><input type="text" class="form-control" name = "name" value = "{{$master->name}}"></th>
                    <th scope = "row"><input type="text" class="form-control disabled" value = "{{$master->rating}}" disabled></th>
                    <th scope = "row"><input type="text" class="form-control disabled" value = "{{$master->calls_count}}" disabled></th>
                    <th scope="row"><img src = "{{asset(Storage::url($master->img))}}" style="max-width: 100px;"><input name = "img" type="file"></th>
                    <th>
                        <button type="submit" class="btn btn-warning">Сохранить изменения</button>
                        <a href = "{{route("master_delete", [$master->id])}}"><button type="button" class="btn btn-danger">Удалить</button></a>
                        <a href = "{{route("master_services", [$master->id])}}"><button type="button" class="btn btn-primary">Услуги</button></a>
                    </th>
                </tr>
            </form>
        @endforeach
        <form method="post" action = "{{route("master_create")}}" enctype="multipart/form-data">
            @csrf
            <tr>
                <th scope = "row"><input type="text" class="form-control disabled" name = "id" value = "" readonly></th>
                <th scope = "row"><input type="text" class="form-control" name = "name" value = ""></th>
                <th scope = "row"><input type="text" class="form-control disabled" value = "0.0" disabled></th>
                <th scope = "row"><input type="text" class="form-control disabled" value = "0" disabled></th>
                <th scope="row"><input name = "img" type="file"></th>
                <th>
                    <button type="submit" class="btn btn-success">Добавить</button>
                </th>
            </tr>
        </form>
        </tbody>
    </table>

@endsection
