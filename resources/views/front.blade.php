@extends('layouts.app', ['title' => "Посуточно " . session('localityName')])
@section('content')
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    {{--    <link href="{{ asset('css/front.css') }}" rel="stylesheet">--}}
    <style>
        .preloader {
            height: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%, -50%)
        }

        .card {
            width: 18rem;
        }

        .card-body {
            padding: 0px;
            font-size: 13px;
            opacity: .9;
        }

        .card-body .detail {
            display: inline-block;
        }

        .rowM {
            width: 100%;
            display: block;
            position: relative;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
            padding: 8px;
            margin: 5px;
        }

        .rowM .big img {
            width: 18rem;
            float: left;
            clear: left;
            display: block;
        }

        .rowM-body {
            float: left;
            display: block;
        }

        .rowM-footer {
            width: 15%;
            float: right;
            margin: 50px 0;
        }

        .details {
            display: block;
            padding: 15px;
        }

        .detail {
            margin-left: 5px;
        }

        .detail img {
            margin: 0px -2px 5px 0px;
        }

        .lit {
            display: flex;
            align-items: center;
            justify-content: center
        }

        .card-footer {
            text-align: center;
        }
    </style>
    <div id="btnContainer">
        <section>
            <div class="container-fluid px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5">
                    <button onclick="rowM()" class="btn active"><i class="fa fa-bars"></i></button>
                    <button onclick="cardM()" class="btn "><i class="fa fa-th-large"></i></button>
                </div>
                <br>
            </div>
        </section>
    </div>
    <script src="{{asset('js/preloader/preloader.js')}}"></script>
    <section class="section">
        <div class="container-fluid px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 lit">
                @if(!empty(count($data)))
                    @foreach($data as $value)
                        <div class="card" id="card">
                            <div class="big">
                                @if($value->path !== null)
                                    <img src="{{ asset("images/" . $value->path) }}" class="card-img-top"
                                         alt="...">
                                @else
                                    <img src="{{ asset("images/no_image/no_image.jpg") }}" class="card-img-top">
                                @endif
                            </div>
                            <div id="card-body" class="card-body">
                                <div class="details">
                                    <div class="detail">
                                        <img style="width: 15px; height: auto; "
                                             src="{{ asset("icons/room.svg") }}">
                                        @if(!empty($value->count_rooms))
                                            @if(is_numeric($value->count_rooms))
                                                {{$value->count_rooms}} комн.
                                            @else
                                                &nbsp;{{mb_strtoupper($value->count_rooms)}}
                                            @endif
                                        @endif
                                    </div>
                                    <div class="detail">
                                        <img style="width: 17px; height: auto;"
                                             src="{{ asset("icons/user.svg") }}">
                                        {!! $value ->capacity !!}
                                    </div>
                                    <div class="detail">
                                        @if(!empty($value->price ))
                                            <img style="width: 17px; height: auto;"
                                                 src="{{ asset("icons/ruble.svg") }}">
                                            &nbsp;От: {{$value->price}}</b>
                                        @endif
                                    </div>

                                    <div class="detail">
                                        <img src="{{ asset('icons/map.svg') }}"
                                             style="width: 17px; "
                                        >
                                        {!! $value->address  !!}
                                    </div>
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
