@extends("layouts.app")

@section("content")

    <div class = "container text-center text-primary">
        <h1>Услуги {{$name}}</h1>
    </div>
    <table class = "table m-3">
        <thead>
            <tr>
                <th scope = "col">ID</th>
                <th scope = "col">Имя услуги</th>
                <th scope = "col">Цена</th>
                <th scope = "col">Действия</th>
            </tr>
        </thead>

        <tbody>
        @foreach($master_services as $service)
        <form method="post" action="{{route("master_update_service")}}">
            @csrf
            <tr>
                <th scope = "row"><input type="text" class="form-control disabled" name = "relation_id" value = "{{$service->relation_id}}" readonly></th>
                <th scope = "row"><input type="text" class="form-control" value = "{{$service->title}}" disabled></th>
                <th scope = "row"><input type="number" class="form-control" name = "price" value = "{{$service->price}}"></th>

                <th scope = "row">
                    <a href = "{{route("master_delete_service", [$service->relation_id])}}"><button type="button" class="btn btn-danger">Удалить</button></a>
                    <button type="submit" class="btn btn-warning">Сохранить</button>
                </th>
            </tr>

        </form>
        @endforeach
        <form method="post">

        </form>
        </tbody>
    </table>

    <h2 class = "text-primary">Добавить услугу мастеру:</h2>
    <div class = 'd-flex flex-wrap justify-content-start'>
        @forelse($available_services as $service)

            <form class = "ms-3" method="POST" action = "{{route("master_add_service")}}">
                @csrf
                <input type = "hidden" name = "master_id" value = "{{$master_id}}">
                <input type = "hidden" name = "service_id" value = "{{$service->id}}">
                <button class = "btn btn-primary" type = "submit">{{$service->title}}</button>
            </form>

        @empty
            <p>В каталоге нет услуг</p>
        @endforelse

    </div>

@endsection
