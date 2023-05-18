@extends('layouts.app', ['title' => "Посуточно " . session('localityName')])
@section('content')
    @push('css')
        <style>
            .preloader {
                height: auto;
                position: absolute;
                top: 50%;
                left: 50%;
                margin-right: -50%;
                transform: translate(-50%, -50%)
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

            .rem {
                opacity: 0.6;
            }

            .rem:hover {
                opacity: 1;
            }

            .down {
                margin-top: 30px;
            }

            .details {
                display: block;
                padding: 15px;
            }

            .detail img {
                margin: 0px 0px 5px 0px;
            }

            @media screen and (max-width: 1000px) {
                .rowM {
                    width: 18em;

                }

                .rowM .big img {
                    width: 100%;
                    float: left;
                    clear: left;
                    display: block;
                }

                .rowM-footer {
                    display: none;
                }

                .detail {
                    display: inline-block;
                    margin: 0px 0px 0px 3px;
                    font-size: 13px;
                }

                .detail img {
                    margin: 0px 0px 5px 0px;
                }

            }

            @media (max-width: 558px) {
                .rowM {
                    width: 100%;

                }

            }

            .lit {
                display: flex;
                align-items: center;
                justify-content: center
            }

        </style>
    @endpush


    <center><h1 style="margin-top: 50px">Мои объекты</h1></center>


    <script src="{{asset('js/preloader/preloader.js')}}"></script>
    <section class="section">
        <div class="container-fluid px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 lit">

                @if(!empty(count($data)))
                    @foreach($data as $value)
                        <div class="rowM" style="
                        @php
                            if($value->published == 0){
        echo "opacity: .7;"; }else {echo "null";}
                        @endphp
                                ">
                            <div class="big">
                                @if($value->path !== null)
                                    <img src="{{ asset("images/" . $value->path) }}" class="card-img-top"
                                         alt="...">
                                @else
                                    <img src="{{ asset("images/no_image/no_image.jpg") }}" class="card-img-top">
                                @endif
                            </div>
                            <div class="rowM-body">
                                <div class="details">
                                    <div class="detail">
                                        <img src="{{ asset('icons/user.svg') }}"
                                             style="width: 17px; height: auto"
                                        >
                                        {!! $value ->capacity !!}
                                    </div>
                                    <div class="detail">
                                        @if(!empty($value->price ))
                                            <img style="width: 17px; height: auto;"
                                                 src="{{ asset("icons/ruble.svg") }}">От: {{$value->price}}
                                        @endif
                                    </div>
                                    <div class="detail">
                                        <img style="width: 15px; height: auto; "
                                             src="{{ asset("icons/room.svg") }}">
                                        @if(!empty($value->count_rooms))
                                            @if(is_numeric($value->count_rooms))
                                                {{$value->count_rooms}} комн.
                                            @else
                                                {{mb_strtoupper($value->count_rooms)}}
                                            @endif
                                        @endif
                                    </div>
                                    <div class="detail">
                                        <img src="{{ asset('icons/map.svg') }}"
                                             style="width: 17px; "
                                        >
                                        {!! $value->address  !!}
                                    </div>
                                    <div class="down">
                                        <a title="Редактировать" class="rem"
                                           href="{{route('object.edit', ['id' => $value->id])}}">
                                            <img src="{{ asset('icons/edit.svg') }}"
                                                 style="width: 17px; "
                                            ></a>
                                        <a title="Смотреть объект" class="rem"
                                           href="{{route('object.view', ['id' => $value->id])}}">
                                            <img src="{{ asset('icons/eye.svg') }}"
                                                 style="width: 20px; "
                                            ></a>
                                        @if($value->published == 1)
                                            <a title="Снять с публикации" class="rem"
                                               onClick="return confirm('Вы хотите снять с публикации?')"
                                               href="{{route('object.take_off', ['id' => $value->id])}}">
                                                <img src="{{ asset('icons/take_off.svg') }}"
                                                     style="width: 18px;"
                                                ></a>
                                        @else
                                            <a title="Опубликовать" class="rem"
                                               href="{{route('object.publish', ['id' => $value->id])}}">
                                                <img src="{{ asset('icons/publish.svg') }}"
                                                     style="width: 15px;"
                                                ></a>
                                        @endif
                                        <a title="Удалить объект" class="rem"
                                           onClick="return confirm('Подтвердите удаление объекта!')"
                                           href="{{route('object.delete', ['id' => $value->id])}}">
                                            <img src="{{ asset('icons/delete.svg') }}"
                                                 style="width: 20px;"
                                            ></a>
                                    </div>
                                </div>
                            </div>
                            <section>
                                <div class="rowM-footer">
                                    @if($value->published == 0)
                                        <div style="color: red">Не опубликовано</div>
                                        <a style="text-decoration: none" title="Опубликовать"
                                           href="{{route('object.publish', ['id' => $value->id])}}">
                                            Опубликовать</a>
                                    @else
                                        <div style="color: #2fa360">Опубликовано</div>
                                        <a style="text-decoration: none" style="color: red"
                                           href="{{route('object.take_off', ['id' => $value->id])}}">
                                            Снять с публикации</a>
                                    @endif
                                </div>
                            </section>
                        </div>
                    @endforeach
                @else
                    К сожалению, у вас пока нет объектов...
                @endif
            </div>
        </div>
    </section>
@endsection
