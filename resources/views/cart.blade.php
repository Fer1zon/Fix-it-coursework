@extends('layouts.app')

@section('content')
    @if(session('error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{-- Если есть иконки --}}
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <style>
        .product-card { transition: transform 0.2s; height: 100%; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .product-img { height: 200px; object-fit: contain; background-color: #f8f9fa; }
    </style>

    <div class="container py-4">
        <div class="row">
            <aside class="col-lg-3 mb-4">
                <form action="{{ route('create_order') }}" method="POST">
                    @csrf
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Создать заказ</h5>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Позиции в заказе</label>
                                @php $total_price = 0; @endphp
                                @foreach($cart as $id => $product)
                                    @php
                                        $subtotal = $product["price"] * $product["quantity"];
                                        $total_price += $subtotal;
                                     @endphp

                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="card-title mb-0" style="font-size: 0.9rem;">
                                            {{ $product['name'] }}
                                            <span class="text-muted">({{ number_format($product['price'], 0, '.', ' ') }} ₽ × {{ $product["quantity"] }})</span>
                                        </h6>
                                        <span class="fw-bold">{{ number_format($subtotal, 0, '.', ' ') }} ₽</span>
                                    </div>

                                @endforeach

                                <span class = "fw-bold text-primary"></span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="fw-bold">Итого к оплате:</span>
                                <span class="fw-bold fs-5 text-primary">
                                    {{ number_format($total_price, 0, '.', ' ') }} ₽
                                </span>
                            </div>

                            <hr>
                            <div class="mb-1">
                                <label class="form-label fw-bold">Адресс доставки</label>
                                <input type="text"
                                       name="address"
                                       id="address"
                                       class="form-control @error('address') is-invalid @enderror"
                                       placeholder="Город, улица, дом, квартира"
                                       value="{{ old('address') }}">

                                @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-4 {{empty($cart) ? 'disabled' : ''}}">Сделать заказ</button>
                        </div>
                    </div>
                </form>
            </aside>

            <main class="col-lg-9">
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">

                    @forelse($cart as $id => $product)
                        <div class="col">
                            <div class="card product-card shadow-sm">
                                <img src="{{ $product['img'] ?? 'https://via.placeholder.com' }}" class="card-img-top product-img p-3" alt="{{ $product['name'] }}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title h6 fw-bold">{{ $product['name'] }}</h5>
                                    <p class="card-text text-muted small flex-grow-1">{{ Str::limit($product['description'], 80) }}</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold text-primary">{{ number_format($product['price'], 0, '.', ' ') }} ₽</span>
                                            <span class="badge {{ $product['max_quantity'] > 5 ? 'bg-success' : 'bg-warning' }}">
                                            {{ $product["max_quantity"] > 0 ? 'В наличии: '.$product['max_quantity'].' шт' : 'Нет в наличии' }}
                                        </span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between border rounded p-1">
                                            <form action="{{ route('remove_cart', $id) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger px-3">-</button>
                                            </form>

                                            <span class="fw-bold">{{ session('cart')[$id]['quantity'] }} шт</span>

                                            <form action="{{ route('add_cart', $id) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success px-3" {{ session('cart')[$id]['quantity'] >= $product['max_quantity'] ? 'disabled' : '' }}>+</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Корзина пуста!</p>
                        </div>
                    @endforelse
                </div>

            </main>
        </div>
    </div>
@endsection
