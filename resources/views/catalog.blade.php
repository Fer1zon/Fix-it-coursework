@extends('layouts.app')

@section('content')
    <style>
        .product-card { transition: transform 0.2s; height: 100%; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .product-img { height: 200px; object-fit: contain; background-color: #f8f9fa; }
    </style>

    <div class="container py-4">
        <div class="row">
            <aside class="col-lg-3 mb-4">
                <form action="{{ route('catalog') }}" method="GET">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Фильтры</h5>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Поиск по имени</label>
                                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Название...">
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Категория</label>
                                @foreach($categories as $category)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat{{ $loop->index }}" {{ in_array($category->id, (array)request('categories')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cat{{ $loop->index }}">{{ $category->name }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Сортировать по цене</label>
                                <select name="sort_price" class="form-select">
                                    <option value="">По умолчанию</option>
                                    <option value="asc" {{ request('sort_price') == 'asc' ? 'selected' : '' }}>От дешевых к дорогим</option>
                                    <option value="desc" {{ request('sort_price') == 'desc' ? 'selected' : '' }}>От дорогих к дешевым</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Применить</button>
                        </div>
                    </div>
                </form>
            </aside>

            <main class="col-lg-9">
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                    @forelse($products as $product)
                        <div class="col">
                            <div class="card product-card shadow-sm">
                                <img src="{{ $product->img ?? 'https://via.placeholder.com' }}" class="card-img-top product-img p-3" alt="{{ $product->name }}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title h6 fw-bold">{{ $product->name }}</h5>
                                    <p class="card-text text-muted small flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold text-primary">{{ number_format($product->price, 0, '.', ' ') }} ₽</span>
                                            <span class="badge {{ ($product->quantity > 5) ? 'bg-success' : (($product->quantity == 0 ) ? 'bg-danger' : 'bg-warning' )}}">
                                            {{ $product->quantity > 0 ? 'В наличии: '.$product->quantity.' шт' : 'Нет в наличии' }}
                                        </span>
                                        </div>
                                        @if(isset(session('cart')[$product->id]))
                                            <div class="d-flex align-items-center justify-content-between border rounded p-1">
                                                <form action="{{ route('remove_cart', $product->id) }}" method="POST" class="m-0">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger px-3">-</button>
                                                </form>

                                                <span class="fw-bold">{{ session('cart')[$product->id]['quantity'] }} шт</span>

                                                <form action="{{ route('add_cart', $product->id) }}" method="POST" class="m-0">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success px-3" {{ session('cart')[$product->id]['quantity'] >= $product->quantity ? 'disabled' : '' }}>+</button>
                                                </form>
                                            </div>
                                        @else
                                            <form action="{{ route('add_cart', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-dark btn-sm w-100" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                                                    {{$product->quantity > 0 ? 'Добавить в корзину' : 'Товара нет в наличии'}}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Товары не найдены</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </main>
        </div>
    </div>
@endsection
