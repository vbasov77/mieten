@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/checkbox.css') }}" rel="stylesheet">
    <section>
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8">
                    @if (!empty($message))
                        <div id="mess" class="mess"
                             style="background-color: red; color:#ffffff; padding: 5px;margin: 15px">
                            <center> {{$message}}</center>
                        </div>
                    @endif
                    <h1 style="margin: 40px 0 60px 0">Добавить объект</h1>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('object.add_address')}}" method="post">
                        @csrf
                        <br>
                        <div>
                            <label for="address"><b>Адрес:</b></label>
                            <input name="address" type="text" value="{{old('address') }}"
                                   class="form-control" id="suggest"
                                   placeholder="Адрес" autocomplete="off" required>
                        </div>
                        <br>
                        <button class="btn btn-outline-success" type="submit">
                            Продолжить
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="//api-maps.yandex.ru/2.1/?94532f3f-9b0c-4212-ba00-c873aeb2ab32&lang=ru_RU&load=SuggestView&onload=onLoad"></script>
        <script src="{{'js/ymaps/ymaps.js'}}"></script>
        <script src="{{asset('js/messages/message_hide_click.js')}}"></script>

    @endpush
@endsection
