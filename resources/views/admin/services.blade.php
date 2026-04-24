@extends("layouts.app")
@section("content")

    <table class = "table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope = "col">Название</th>
                <th scope ="col">Категория</th>
                <th scope="col">Фото</th>
                <th scope = "col">Действия</th>
            </tr>
        </thead>

        <tbody>
            @foreach($services as $service)
                <form method="post" action="{{route("admin_update_service", [$category_id])}}" enctype="multipart/form-data">
                    @csrf
                    <tr>
                        <th scope = "row"><input name = "id" type="text" class = "form-control disabled" value = "{{$service->id}}" readonly></th>
                        <th scope = "row"><input name = "title" type = "text" class = "form-control" value = "{{$service->title}}"></th>
                        <th scope ="row">
                            <select class="form-select" name = "category" id="inputGroupSelect01">
                                @foreach($categories as $category)
                                    @if($category_id == $category->id)
                                        <option selected value = "{{$category->id}}">{{$category->title}}</option>
                                    @else
                                        <option value="{{$category->id}}">{{$category->title}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <img src="{{Storage::url($service->img)}}">
                            <input type="file" name = "img">
                        </th>

                        <th>
                            <button type = "submit" class="btn btn-warning">Сохранить</button>
                            <a href = "{{route("admin_delete_service", [$category_id, $service->id])}}"><button type = "button" class = "btn btn-danger">Удалить</button></a>

                        </th>

                    </tr>
                </form>
            @endforeach
            <form method="post" action="{{route("admin_create_service", [$category_id])}}" enctype="multipart/form-data">
                @csrf
                <tr>
                    <th scope = "row"><input name = "id" type="text" class = "form-control disabled" value = "" disabled></th>
                    <th scope = "row"><input name = "title" type = "text" class = "form-control" value = "" required></th>
                    <th scope ="row">
                        <select class="form-select" name = "category" id="inputGroupSelect01" required>
                            @foreach($categories as $category)
                                @if($category_id == $category->id)
                                    <option selected value = "{{$category->id}}">{{$category->title}}</option>
                                @else
                                    <option value="{{$category->id}}">{{$category->title}}</option>
                                @endif
                            @endforeach
                        </select>
                    </th>
                    <th>
                        <input type="file" name = "img" required>
                    </th>

                    <th>
                        <button type = "submit" class="btn btn-success">Создать</button>

                    </th>

                </tr>
            </form>
        </tbody>
    </table>

@endsection
