@extends('layouts.app', ['title' => "Мои сообщения"])
@section('content')


    <link href="{{ asset('css/messages.css') }}" rel="stylesheet">

    <section>
        <div class="container px-4 px-lg-5">
            <div class="row  justify-content-center text-center">
                <div class="col-xl-8">
                    @if (!empty($message))
                        <div id="mess" class="mess"
                             style="background-color: #43b143; color:#ffffff; padding: 5px;margin: 15px">
                            <center> {{$message}}</center>
                        </div>
                    @endif
                    <h1 style="margin-top: 40px">Мои сообщения</h1>
                    @for ($i = 0; $i < count ($messages); $i++)
                        <a class="messageLink" style="text-decoration: none;" href="{{ route('view.messages',
                            ['id'=> $messages[$i]->obj_id,  'to_user_id'=>$messages[$i]->user_id]) }}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-2 ">
                                            @if(!empty($messages[$i]->path))
                                                <img src="{{ asset('images/' . $messages[$i]->path ) }}"
                                                     style="width: 80px; height: auto">
                                            @else
                                                <img src="{{ asset('images/no_image/no_image.jpg') }}"
                                                     style="width: 100px; height: auto">
                                            @endif
                                        </div>
                                        <div class="col-xl-6 text-left">
                                            {!! $messages[$i]->body !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                    @endfor
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="{{asset('js/messages/message_hide.js')}}"></script>
    @endpush

@endsection
