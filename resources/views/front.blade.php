@extends('layouts.app', ['title' => "Посуточно " . session('localityName')])
@section('content')
        <link href="{{ asset('css/front.css') }}" rel="stylesheet">
    <style>

    </style>
    <div id="btnContainer">
        <section>
            <div class="container-fluid px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5">
                    <button onclick="rowM()" class="btn active rem"><img style="width: 19px; height: auto; "
                                                                     src="{{ asset("icons/rows.svg") }}"></button>
                    <button onclick="cardM()" class="btn rem"><img style="width: 15px; height: auto; "
                                                                src="{{ asset("icons/grid.svg") }}"></button>
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
