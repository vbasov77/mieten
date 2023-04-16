@extends('layouts.app', ['title' => "Посуточно " . session('localityName')])
@section('content')


    <section style="margin-top: 40px" class="section text-center">
        <div class="container-fluid px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                @if(!empty(count($data)))
                    @foreach($data as $value)
                        <div class="card" style="width: 18rem;">
                            @if($value->path !== null)
                                <img src="{{ asset("images/" . $value->path) }}" class="card-img-top"
                                     alt="...">
                            @else
                                <img src="{{ asset("images/no_image/no_image.jpg") }}" class="card-img-top" alt="...">
                            @endif

                            <div class="card-body">
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
                            <div class="card-footer">
                                <button class="btn btn-outline-success"
                                        onclick="window.location.href = '{{route('object.view', ['id'=>$value ->id])}}';">
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
        <script src="{{ asset('js/calendars/calendar.js') }}" defer></script>
    </section>
@endsection
