@extends('layouts.app', ['title' => "Мои сообщения"])
@section('content')
    <link href="{{ asset('css/messages.css') }}" rel="stylesheet">
    <style>
        .rem {
            opacity: 0.5;
        }

        .rem:hover {
            opacity: 1;
        }
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
                                                    <img src="{{ asset('icons/map.svg') }}"
                                                         style="width: 19px; margin: 0px 3px 7px 0"
                                                    ></div>{!! $data[0]->address !!}</small>
                                        </div>
                                        @if(!empty($messages))
                                            <a style="text-decoration: none;" title="Удалить чат"
                                               onClick="return confirm('Подтвердите удаление чата!')"
                                               href="{{ route('delete.chat', ['to_user_id' => $toUser,
                                       'from_user_id' =>$userId, 'obj_id'=> $messages[0]->obj_id]) }}">
                                                <img class="imgMsg rem"
                                                     src="{{ asset('icons/del_message.svg') }}"
                                                     style="width: auto; height: 25px; float: right; border: none;"
                                                >
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <div class="msgImg">
                                        <img class="imgMsg"
                                             src="{{ asset('icons/no-entry.svg') }}"
                                             style="width: auto; height: 40px; border: none"
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
                            @if (!empty($data))
                                <div class="message-input">

                                    <div class="wrap">

                                        <input class="form-control" type="text" placeholder="Ваше сообщение..."/>
                                        <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                        </button>

                                    </div>

                                </div>
                            @else
                                <div class="text-center">
                                    <a class="btn btn-outline-danger btn-sm"
                                       onClick="return confirm('Подтвердите удаление!')"
                                       href="{{ route('delete.chat', ['to_user_id' => $toUser,
                                       'from_user_id' =>$userId, 'obj_id'=> $messages[0]->obj_id]) }}">Удалить чат
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (!empty($data))
        @push('scripts')
            <script src="{{ asset('js/jquery/jquery-3.5.1.js') }}"></script>
            <script>
                var to_user_id = @json($toUser);
                var from_user_id = @json($userId);
                var obj_id = @json($objId);
            </script>
            <script src="{{asset('js/messages/message.js')}}"></script>
        @endpush
    @endif
@endsection