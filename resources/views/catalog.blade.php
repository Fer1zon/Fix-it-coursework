@extends('layouts.app')

@section('content')
   <div class = "container">

       <div class="accordion g-1" id="categoriesAccordion">
           @foreach($categories as $index => $category)
               <div class="accordion-item mb-2 rounded-3 overflow-hidden" style="background-color: rgb(217, 217, 217); border: none;">
                   <h2 class="accordion-header">
                       <button class="accordion-button collapsed p-3"
                               style="background-color: rgb(217, 217, 217);"
                               type="button"
                               data-bs-toggle="collapse"
                               data-bs-target="#collapse{{ $index }}"
                               aria-expanded="false"
                               aria-controls="collapse{{ $index }}">
                           <div class="d-flex align-items-center w-100">
                               <img class="me-3" src="{{ Storage::url($category->img)}}" style="width: 50px; height: 50px; object-fit: cover;">
                               <p class="mb-0" style="font-family: 'Fira-Sans-Condensed-Black'; font-weight: lighter; font-size: 32px">
                                   {{ $category->title }}
                               </p>
                           </div>
                       </button>
                   </h2>
                   <div id="collapse{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#categoriesAccordion">
                       <div class="accordion-body" style="background-color: rgb(240, 240, 240);">
                           @if(isset($services[$category->id]) && count($services[$category->id]) > 0)
                               <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                                   @foreach($services[$category->id] as $service)

                                           <div class="col">
                                               <div class="text-center">
                                                   <a href = "/catalog/{{$service->id}}" class = "nav-link">
                                                       <img src="{{ Storage::url($service->img) }}"
                                                            style="width: 100%; height: 150px; object-fit: cover;"
                                                            class="mb-2 rounded">
                                                       <h3 style="font-family: Fira-Sans-Condensed-Black; font-weight: lighter; font-size: 20px">{{ $service->title }}</h3>
                                                       <h4 style="font-family: Fira-Sans-Condensed-Black; font-weight: lighter;">{{isset($service->min_price) ? 'От ' . $service->min_price . 'Р': ''}}</h4>
                                                   </a>
                                               </div>
                                           </div>

                                   @endforeach
                               </div>
                           @else
                               <p class="text-center text-muted py-4">В этой категории пока нет услуг</p>
                           @endif
                       </div>
                   </div>
               </div>
           @endforeach
       </div>

   </div>
@endsection
