@extends("layouts.app")

@section('content')

    <table class = "table">

        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope = "col">Пользователя</th>
                <th scope = "col">Мастера</th>
                <th scope = "col">Услуга</th>
                <th scope = "col">Контактный номер</th>
                <th scope="col">Адрес</th>
                <th scope = "col">Дата визита</th>
                <th scope = "col">Статус</th>
                <th scope="col">Итоговая цена</th>
                <th scope = "col">Действия</th>
            </tr>
        </thead>

        <tbody>
            @foreach($calls as $call)
                <form method="POST" action="{{route("admin_update_calls_master")}}">
                    @csrf
                    <tr>
                        <th scope = "row">
                            <input type = "text" class = "form-control disabled" value = "{{$call->call_id}}" name = "id" readonly>
                        </th>

                        <th scope = "row">
                            <input type = "text" class = "form-control disabled" value = "{{$call->user_name}}" disabled>
                        </th>

                        <th scope = "row">
                            <input type = "text" class = "form-control disabled" value = "{{$call->master_name}}" disabled>
                        </th>

                        <th scope = "row">
                            <input type = "text" class = "form-control disabled" value = "{{$call->service_name}}" disabled>
                        </th>

                        <th scope = "row">
                            <input type = "text" class = "form-control disabled" value = "{{$call->contact_phone}}" disabled>
                        </th>

                        <th scope = "row">
                            <input type = "text" class = "form-control disabled" value = "{{$call->address}}" disabled>
                        </th>

                        <th scope = "row">
                            <input type = "text" class = "form-control disabled" value = "{{$call->preferred_date}} {{$call->preferred_time}}" disabled>
                        </th>

                        <th scope = "row">
                            <select class="form-select" name = "status_id" id="inputGroupSelect01">
                                @foreach($statuses as $status)
                                    @if($call->status_id == $status->id)
                                        <option selected value = "{{$status->id}}">{{$status->name}}</option>
                                    @else
                                        <option value="{{$status->id}}">{{$status->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </th>

                        <th scope = "row">
                            <input type = "number" value = "{{$call->finish_price}}" class = "form-control" name = "finish_price">
                        </th>
                        <th>
                            <button class = "btn btn-warning" type = "submit">Сохранить</button>
                            <a href = "{{route("admin_delete_calls_master", [$call->call_id])}}"><button class = "btn btn-danger" type="button">Удалить</button></a>
                        </th>
                    </tr>
                </form>
            @endforeach
        </tbody>

    </table>

@endsection
