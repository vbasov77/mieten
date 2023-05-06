@extends('layouts.app', ['title' => "Мои сообщения"])
@section('content')
    <link href="{{ asset('css/messages.css') }}" rel="stylesheet">
    <style>
    </style>
    <section>
        <div class="container px-4 px-lg-5"
             style="white-space: nowrap"> {{--Запрет переноса строк при уменьшении странцы браузера--}}
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8">
                    @csrf
                    <div style="margin-top: 10px" id="framechat">
                        <div class="content">
                            <div class="header">
                                @if (!empty($data))
                                    <div class="msgImg">
                                        {{--  Ссылка на объект--}}
                                        <a style="text-decoration: none;"
                                           href="{{ route('object.view', ['id'=>$data[0]->id]) }}">

                                            @if(!empty($data[0]->path))
                                                <img class="imgMsg"
                                                     src="{{ asset('images/' . $data[0]->path) }}"
                                                     style="width: auto; height: 60px"
                                                >
                                            @else
                                                <img class="imgMsg"
                                                     src="{{ asset('images/no_image/no_image.jpg') }}"
                                                     style="width: auto; height: 60px"
                                                >
                                            @endif
                                        </a>
                                        <div class="infoBlock">
                                            <b>{!! $data[0]->user_name !!}</b><br>
                                            <small>
                                                <div class="iconsSmall">
                                                    <img src="{{ asset('icons/location-map-marker-navigation.svg') }}"
                                                         style="width: 20px; height: auto"
                                                    ></div>{!! $data[0]->address !!}</small>
                                        </div>
                                    </div>
                                @else
                                    <div class="msgImg">
                                        <img class="imgMsg"
                                             src="{{ asset('icons/account.svg') }}"
                                             style="width: auto; height: 60px"
                                        >
                                        <div class="infoBlock">
                                            Объект удалён
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <div class="messages">
                                <ul>
                                    @for($i = 0; $i < count($messages); $i++)
                                        <li class="sent">
                                            <div class="myClass">
                                                <div class="messageBlock" id="{{$messages[$i]->id}}" style="
                                                     @php
                                                    if($messages[$i]->status == 0){
                                                        echo "background-color: #dad6f5; ";}
                                                @endphp
                                                @php
                                                    if($messages[$i]->from_user_id == $userId){
                            echo "float: right; ";
                        }
                                                @endphp "
                                                     data-id="{{$messages[$i]->id}}"
                                                     data-notified="{{$messages[$i]->status}}">
                                                    @if($messages[$i]->from_user_id == $userId)
                                                        <div class="round-popup">
                                                            <button data-id="{{$messages[$i]->id}}" type="button"
                                                                    class="close"
                                                                    aria-label="Close"><span
                                                                        aria-hidden="true">&times;</span></button>
                                                        </div>
                                                    @endif
                                                    <big>{!!$messages[$i]->body !!}<br></big>
                                                    <small style="opacity: 0.7">{!! $messages[$i]->created_at !!}</small>
                                                </div>
                                            </div>
                                        </li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="message-input">

                                <div class="wrap">
                                    @if (!empty($data))
                                        <input class="form-control" type="text" placeholder="Ваше сообщение..."/>
                                        <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            var to_user_id = @json($toUser);
            var from_user_id = @json($userId);
            var obj_id = @json($data[0]->id);
        </script>
        <script src="{{asset('js/messages/message.js')}}"></script>
    @endpush
@endsection