@extends('layouts.app')
@section('content')
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <section>
        <div class="container px-4 px-lg-5">
            <div class="row  justify-content-center text-center">
                <div class="col-xl-8">
                    <div style="padding: 20px">
                        <h3>{{$data ->title}}</h3><br>
                    </div>
                    <div id="carusel" class="carousel slide" data-ride="carousel">
                        <ul class="carousel-indicators">
                            @if(!empty($images))
                                @for ($s = 0; $s < count($images); $s++)
                                    @php
                                        if ($s == 0){
                                             $active = "active";
                                        } else {$active = "";}
                                    @endphp
                                    <li data-target="#carusel" data-slide-to="{{$s}}" class="{{$active}}"></li>
                                @endfor
                            @endif
                        </ul>
                        <div class="carousel-inner">
                            @if(!empty($images))
                                @for ($i = 0; $i < count($images); $i++)
                                    @php
                                        if ($i == 0){
                                            $carusel = "carousel-item active";
                                             } else {$carusel = "carousel-item";}
                                    @endphp
                                    <div class="{{$carusel}}">
                                        <img src="{{ asset('images/' . $images[$i])}}" alt="">
                                    </div>
                                @endfor
                            @else
                                <img src="{{ asset('images/no_image/no_image.jpg')}}" alt="">
                            @endif
                            <a class="carousel-control-prev" href="#carusel" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#carusel" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="col-xl-4">
                    @if (!empty($data['price']))
                        <div style="font-size: 30px; margin-bottom: 15px; opacity: .7; margin-top: 45px; ">
                            <b> От {{ $data ['price'] }} <i class="fa fa-rub"></i></b>
                        </div>
                    @endif
                    @if (!empty($data['service'])  )
                        <h3 style="padding: 15px">Сервис</h3>
                        @php
                            $service = explode(',', $data['service']);
                        @endphp

                        @foreach($service as $value)
                            <div style="font-size: 23px;">
                                <i class="fa fa-check"></i> {{$value }}<br>
                            </div>
                        @endforeach

                    @endif
                </div>
                <br>
            </div>
            <div class="row justify-content-center text-center">
                <div class="col-12">
                    <button class="btn btn-success btn-sm" style="color: white; margin-top: 25px"
                            onclick="window.location.href = '{{route('view.messages',
                            ['id'=>$data->id, 'to_user_id'=>$data->user_id])}}'">
                        Написать сообщение
                    </button>
                    <div style="margin: 50px 0 50px 0">
                        <h1><i class="fa fa-map-marker" aria-hidden="true"></i> {{$data->address}}</h1>
                        Количество комнат: {{$data -> count_rooms}}<br>
                        Вместимость до:
                        @for($i = 0; $i < $data->capacity; $i++)
                            <i class="fa fa-user"></i>
                        @endfor

                    </div>
                </div>
            </div>
            <div class="row justify-content-center text-center">
                <div class="col-12">
                    <div style="margin: 50px 0 50px 0">
                        {{$data -> text_obj}}
                    </div>
                </div>
            </div>
            <div class="row justify-content-center text-center">
                <div class="col-12">
                    @if (!empty($data->path))
                        <div style="margin-top: 40px">
                            <iframe width="560" height="315" src="{{$data->path}}" title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                            </iframe>
                        </div>
                    @endif
                </div>
            </div>
            <br>
        </div>

    </section>
    <section>
        <div class="row justify-content-center">
            <div style="margin-top: 25px; margin-bottom: 25px; text-align: center;">
                <h2>На карте</h2>
            </div>
            <div id="map" style="width: 100%; height: 400px"></div>
        </div>
    </section>
    <section>
        <div class="row justify-content-center text-center">

            @if(!empty(Auth::user()->id ) == $data->user_id)
                <div>
                    <button class="btn btn-success btn-sm" style="color: white; margin-top: 25px"
                            onclick="window.location.href = '{{route('object.edit', ['id'=>$data->id])}}'">
                        Редактировать номер
                    </button>
                </div>
            @endif
        </div>
    </section>
    @push('scripts')
        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
        <script>
            // Функция ymaps.ready() будет вызвана, когда
            // загрузятся все компоненты API, а также когда будет готово DOM-дерево.
            ymaps.ready(init);

            function init() {
                // Создание карты.
                // https://tech.yandex.ru/maps/doc/jsapi/2.1/dg/concepts/map-docpage/
                var myMap = new ymaps.Map("map", {
                    // Координаты центра карты.
                    // Порядок по умолчнию: «широта, долгота».
                    center: [{{$data->coordinates}}],
                    // Уровень масштабирования. Допустимые значения:
                    // от 0 (весь мир) до 19.
                    zoom: 12,
                    // Элементы управления
                    // https://tech.yandex.ru/maps/doc/jsapi/2.1/dg/concepts/controls/standard-docpage/
                    controls: [

                        'zoomControl', // Ползунок масштаба
                        'rulerControl', // Линейка
                        'routeButtonControl', // Панель маршрутизации
                        'trafficControl', // Пробки
                        'typeSelector', // Переключатель слоев карты
                        'fullscreenControl', // Полноэкранный режим
                        // Поисковая строка
                        new ymaps.control.SearchControl({
                            options: {
                                // вид - поисковая строка
                                size: 'large',
                                // Включим возможность искать не только топонимы, но и организации.
                                provider: 'yandex#search'
                            }
                        })
                    ]
                });
                var myPlacemark = new ymaps.Placemark([{{$data->coordinates}}], {
                    // Хинт показывается при наведении мышкой на иконку метки.
                    hintContent: 'Содержимое всплывающей подсказки',
                    // Балун откроется при клике по метке.
                    balloonContent: '<center><div>{{$data->address}}<br>От {{$data->price}} руб.<br></div></center>'
                });

                // После того как метка была создана, добавляем её на карту.
                myMap.geoObjects.add(myPlacemark);

            }
        </script>
    @endpush
@endsection
