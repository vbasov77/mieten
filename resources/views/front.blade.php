@extends('layouts.app', ['title' => "Посуточно " . session('localityName')])
@section('content')
    <style>
        .preloader {
            height: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%, -50%)
        }

        .rowM{
            display: none;
        }
    </style>
    <link href="{{ asset('css/front.css') }}" rel="stylesheet">
    <section>
        <div class="container-fluid px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5">
                <div id="btnContainer">
                    <button onclick="rowM()" class="btn active"><i class="fa fa-bars"></i></button>
                    <button onclick="cardM()" class="btn "><i class="fa fa-th-large"></i></button>
                </div>
                <br>
            </div>
        </div>
    </section>
    <script src="{{asset('js/preloader/preloader.js')}}"></script>
    <section class="section text-center">
        <div class="container-fluid px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                @if(!empty(count($data)))
                    @foreach($data as $value)
                        <div class="card" id="card">
                            @if($value->path !== null)
                                <img src="{{ asset("images/" . $value->path) }}" class="card-img-top"
                                     alt="...">
                            @else
                                <img src="{{ asset("images/no_image/no_image.jpg") }}" class="card-img-top">
                            @endif
                            <div id="card-body" class="card-body">
                                <div style="float: left; opacity: .6; ">
                                    @for($i = 0; $i < $value ->capacity; $i++)
                                        <i class="fa fa-user"></i>
                                        {{--                        <p class="card-text"><?= $value['text_room']?></p>--}}
                                    @endfor
                                    @if(!empty($value->price ))
                                        &nbsp;<b>От: {{$value->price}}</b><i class="fa fa-rub"></i>
                                    @endif
                                    @if(!empty($value->count_rooms))
                                        @if(is_numeric($value->count_rooms))
                                            {{$value->count_rooms}} комн.
                                        @else
                                            &nbsp;<b>{{mb_strtoupper($value->count_rooms)}}</b>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div id="card-footer" class="card-footer">
                                <button class="btn btn-outline-success"
                                        onclick="window.location.href = '{{route('object.view', ['id'=>$value->id])}}';">
                                    Подробнее
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    К сожалению, по вашим запросам объектов не найдено...
                @endif
            </div>
        </div>
        @push('scripts')
            <script>
                var cardName = @json($dataSession['cardName']);
                var cardBodyName = @json($dataSession['cardBodyName']);
                var cardFooterName = @json($dataSession['cardFooterName']);
            </script>
            <script src="{{ asset('js/row&greed/row&greed.js') }}" defer></script>
        @endpush
    </section>
@endsection
