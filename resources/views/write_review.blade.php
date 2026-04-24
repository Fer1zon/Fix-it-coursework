@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                        <i class="fas fa-star text-warning fs-1"></i>
                        <i class="fas fa-star text-warning fs-1"></i>
                        <i class="fas fa-star text-warning fs-1"></i>
                        <i class="fas fa-star text-warning fs-1"></i>
                        <i class="fas fa-star-half-alt text-warning fs-1"></i>
                        <h2 class="h3 fw-bold mt-3">Оставить отзыв</h2>
                        <p class="text-secondary-emphasis mt-2">Поделитесь своим опытом</p>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{route('send_review')}}" method="post">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-semibold mb-3">
                                    <i class="fas fa-star text-warning me-1"></i> Ваша оценка
                                </label>
                                <div class="d-flex justify-content-between gap-2">
                                    <div class="form-check flex-fill text-center">
                                        <input class="form-check-input" type="radio" name="rating" value="1" id="rating1">
                                        <label class="form-check-label d-block py-2 border rounded-3" for="rating1">
                                            <i class="fas fa-star"></i> 1
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill text-center">
                                        <input class="form-check-input" type="radio" name="rating" value="2" id="rating2">
                                        <label class="form-check-label d-block py-2 border rounded-3" for="rating2">
                                            <i class="fas fa-star"></i> 2
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill text-center">
                                        <input class="form-check-input" type="radio" name="rating" value="3" id="rating3">
                                        <label class="form-check-label d-block py-2 border rounded-3" for="rating3">
                                            <i class="fas fa-star"></i> 3
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill text-center">
                                        <input class="form-check-input" type="radio" name="rating" value="4" id="rating4">
                                        <label class="form-check-label d-block py-2 border rounded-3" for="rating4">
                                            <i class="fas fa-star"></i> 4
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill text-center">
                                        <input class="form-check-input" type="radio" name="rating" value="5" id="rating5">
                                        <label class="form-check-label d-block py-2 border rounded-3" for="rating5">
                                            <i class="fas fa-star"></i> 5
                                        </label>
                                    </div>
                                </div>
                                <div class="form-text text-center mt-2">
                                    <i class="fas fa-info-circle me-1"></i> Выберите оценку от 1 до 5
                                </div>
                            </div>


                            <div class="mb-4">
                                <label for="message" class="form-label fw-semibold">
                                    <i class="fas fa-comment me-1"></i> Ваш отзыв
                                </label>
                                <textarea class="form-control" rows="5"
                                          name = "message"
                                          placeholder="Расскажите о своём опыте..."
                                          required></textarea>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i> Минимум 10 символов
                                </div>
                            </div>



                            <!-- Кнопка отправки -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg py-2">
                                    <i class="fas fa-paper-plane me-2"></i> Отправить отзыв
                                </button>
                            </div>
                            <input type="hidden" name="master_id" value="{{ $master_id ?? '' }}">
                            <input type="hidden" name="service_id" value="{{ $service_id ?? '' }}">
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
