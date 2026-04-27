@extends("layouts.app")

@section('content')

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-3 fw-bold text-primary">FIX-IT</h1>
        <p class="lead">Профессиональный ремонт и обслуживание вашего дома</p>
        <hr class="w-25 mx-auto">
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h3 class="card-title">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>О нас
                    </h3>
                    <p class="card-text mt-3">
                        Компания <strong>FIX-IT</strong> работает на рынке с 2015 года.
                        Мы специализируемся на ремонте цифровой и бытовой техники, мебели, сантехники и электрики.
                    </p>
                    <p class="card-text">
                        Наши мастера имеют многолетний опыт и подтвержденные навыки.
                        Гарантия на все виды работ — до 2 лет.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h3 class="card-title">
                        <i class="bi bi-telephone-fill text-primary me-2"></i>Контакты
                    </h3>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-3">
                            <i class="bi bi-building text-primary me-2"></i>
                            <strong>Название:</strong> FIX-IT
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-telephone-fill text-primary me-2"></i>
                            <strong>Телефон:</strong> <a href="#" class="text-decoration-none">+8 123 456 78 90</a>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-envelope-fill text-primary me-2"></i>
                            <strong>Email:</strong> <a href="#" class="text-decoration-none">example@gmail.com</a>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                            <strong>Адрес:</strong> г. Ижевск, ул. Пушкинская, 268
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="card-title mb-3">
                <i class="bi bi-map-fill text-primary me-2"></i>Мы на карте
            </h4>
            <div class="ratio ratio-16x9">
                <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A0ea73d8cfa3903b9c51f48f5928a0955b715893fddafb4899cc4c5ac622c8855&amp;width=448&amp;height=448&amp;lang=ru_RU&amp;scroll=true"></script>
                            </div>
        </div>
    </div>

    <div class="row mt-5 g-4 text-center">
        <div class="col-md-4">
            <i class="bi bi-tools fs-1 text-primary"></i>
            <h5 class="mt-2">Сотрудники по всему городу</h5>
            <p class="text-muted">Будем у вас в ближайшее время</p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-truck fs-1 text-primary"></i>
            <h5 class="mt-2">Бесплатная диагностика</h5>
            <p class="text-muted">При вызове на ремонт технически сложной техники</p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-shield-check fs-1 text-primary"></i>
            <h5 class="mt-2">Гарантия качества</h5>
            <p class="text-muted">Все наши сотрудники проходят регулярную проверку квалификации</p>
        </div>
    </div>
</div>

@endsection
