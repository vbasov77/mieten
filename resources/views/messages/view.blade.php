@extends('layouts.app', ['title' => "Мои сообщения"])
@section('content')
    <link href="{{ asset('css/messages.css') }}" rel="stylesheet">
    <style>
        .address {
            margin: 0 25% 0 25%;
            width: 50%;
        }
    </style>
    <section>
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8">
                    @csrf
                    <div style="margin-top: 10px" id="framechat">
                        <div class="content">
                            <div class="header">
                                {{--                                <i class="fa fa-comments"></i>--}}

                                <div class="msgImg">
                                    <a style="text-decoration: none;" href="{{ route('object.view', ['id'=>$objId]) }}">
                                        <img class="imgMsg"
                                             src="{{ asset('images/' . $image) }}" style="width: auto; height: 60px"
                                        >
                                    </a>

                                    {!! $address !!}

                                </div>

                            </div>

                            <div class="messages">
                                <ul>
                                    @for($i = 0; $i < count($messages); $i++)
                                        <li class="sent">
                                            <div class="myClass">
                                                <div class="messageBlock" style="
                                                     @php
                                                    if($messages[$i]->status == 0){
                                                        echo "background-color: #dad6f5; ";}
                                                @endphp
                                                @php
                                                    if($messages[$i]->from_user_id == $userId){
                            echo "float: right; ";
                        }
                                                @endphp "


                                                     data-id="{{$messages[$i]->id}}">
                                                    @if($messages[$i]->from_user_id == $userId)
                                                        <button data-id="{{$messages[$i]->id}}" type="button"
                                                                class="close"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span></button>
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

                                    <input class="form-control" type="text" placeholder="Ваше сообщение..."/>
                                    <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
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
            var obj_id = @json($objId);
        </script>

        <script src="{{asset('js/messages/message.js')}}"></script>
    @endpush
@endsection