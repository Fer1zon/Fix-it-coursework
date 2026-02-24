@extends('layouts.app')
@section('content')

    <div class = "container">

        <table class = "table">
            <thead>
            <tr>
                <th scope="col">№</th>
                <th scope="col">Статус</th>
                <th scope="col">Товары</th>
                <th scope="col">Общая сумма</th>
                <th scope="col">Создан</th>
            </tr>
            </thead>

            <tbody>
            @foreach($orders as $order)
                <tr>
                    <th scope="row">{{$loop->index}}</th>
                    <th>
                        <button class = 'btn {{$order->status_id == 1 ? 'bg-warning' : (($order->status_id == 2 or $order->status_id == 3) ? 'bg-primary' : "bg-success")}}'>{{$order->status_name}}</button>
                    </th>
                    <th>
                        @foreach($order->products as $product)
                            <p>{{$product->product_name}} x {{$product->quantity}}</p>
                        @endforeach
                    </th>
                    <th>{{$order->total_price}} ₽</th>
                    <th>{{$order->create_at}}</th>
                </tr>
            @endforeach
            </tbody>
        </table>


    </div>

@endsection
