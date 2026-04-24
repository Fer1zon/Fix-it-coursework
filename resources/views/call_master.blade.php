@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-telephone"></i> Вызов специалиста
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('call_master')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="phone" class="form-label">
                                <i class="bi bi-phone"></i> Контактный номер
                            </label>
                            <input type="tel"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   id="phone"
                                   name="phone"
                                   placeholder="+7 (XXX) XXX-XX-XX"
                                   value="{{ old('phone') }}"
                                   required>
                            <div class="form-text">Введите номер телефона для связи</div>
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">
                                <i class="bi bi-geo-alt"></i> Адрес
                            </label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address"
                                      name="address"
                                      rows="2"
                                      placeholder="г. Москва, ул. Примерная, д. 1, кв. 1"
                                      required>{{ old('address') }}</textarea>
                            <div class="form-text">Укажите точный адрес выполнения работ</div>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="preferred_time" class="form-label">
                                <i class="bi bi-clock"></i> Удобное время приезда
                            </label>
                            <select class="form-select @error('preferred_time') is-invalid @enderror"
                                    id="preferred_time"
                                    name="preferred_time"
                                    required>
                                <option value="">Выберите удобное время</option>
                                <option value="09:00-12:00" {{ old('preferred_time') == '09:00-12:00' ? 'selected' : '' }}>09:00 - 12:00</option>
                                <option value="12:00-15:00" {{ old('preferred_time') == '12:00-15:00' ? 'selected' : '' }}>12:00 - 15:00</option>
                                <option value="15:00-18:00" {{ old('preferred_time') == '15:00-18:00' ? 'selected' : '' }}>15:00 - 18:00</option>
                                <option value="18:00-21:00" {{ old('preferred_time') == '18:00-21:00' ? 'selected' : '' }}>18:00 - 21:00</option>
                            </select>
                            <div class="form-text">Выберите удобный временной интервал</div>
                            @error('preferred_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="date" class="form-label">
                                <i class="bi bi-calendar"></i> Дата приезда
                            </label>
                            <input type="date"
                                   class="form-control @error('date') is-invalid @enderror"
                                   id="date"
                                   name="date"
                                   value="{{ old('date', date('Y-m-d')) }}"
                                   min="{{ date('Y-m-d') }}"
                                   required>
                            @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="comment" class="form-label">
                                <i class="bi bi-chat"></i> Комментарий (опционально)
                            </label>
                            <textarea class="form-control"
                                      id="comment"
                                      name="comment"
                                      rows="2"
                                      placeholder="Опишите проблему или дополнительные пожелания">{{ old('comment') }}</textarea>
                        </div>

                        <input type="hidden" name="master_id" value="{{ $master_id ?? '' }}">
                        <input type="hidden" name="service_id" value="{{ $service_id ?? '' }}">

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle"></i> Вызвать специалиста
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
