@extends('layouts.app', ['title' => "Мои сообщения"])
@section('content')


        <link href="{{ asset('css/messages.css') }}" rel="stylesheet">

    <section>
        <div class="container px-4 px-lg-5">
            <div class="row  justify-content-center text-center">
                <div class="col-xl-8">
                    <h1>Мои сообщения</h1>
                    @for ($i = 0; $i < count ($messages); $i++)
                        <a class="messageLink" style="text-decoration: none;" href="{{ route('view.messages',
                            ['id'=> $messages[$i]->obj_id,  'to_user_id'=>$messages[$i]->user_id]) }}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-2 ">
                                            {{--                                        {!! $messages[$i]->user_id !!}--}}
                                            <img
                                                    src="{{ asset('images/' . $messages[$i]->path ) }}" style="width: 80px; height: auto"
                                                    alt="...">
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

@endsection
