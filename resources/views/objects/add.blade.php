@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/checkbox.css') }}" rel="stylesheet">
    <section>
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8">
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
                    <form action="{{route('object.add')}}" method="post">
                        @csrf
                        <input name="images" id="someInputId" type="hidden" value="">
                        <div>
                            <label for="title"><b>Заголовок:</b></label>
                            <input name="title" type="text" value="{{old('title')}}"
                                   class="form-control"
                                   placeholder="Заголовок" autocomplete="off" required>
                        </div>
                        <br>
                        <div>
                            <label for="address"><b>Адрес:</b></label>
                            <input name="address" type="text" value="{{old('address') }}"
                                   class="form-control" id="suggest"
                                   placeholder="Адрес" autocomplete="off" required>
                        </div>
                        <br>
                        <div>
                            <label for="price"><b>Цена:</b></label>
                            <input name="price" type="text" value="{{old('price') }}"
                                   class="form-control"
                                   onkeypress="return (event.charCode >= 48 && event.charCode <= 57 && /^\d{0,3}$/.test(this.value));"
                                   placeholder="Цена" autocomplete="off" required>
                        </div>
                        <br>

                        <div>
                            <label for="rooms"><b>Количество комнат:</b></label><br>
                            <label class="checkbox-btn2">
                                <input type="checkbox" name="count_rooms" id="rooms"
                                       value="студия">
                                <span>Студия</span>
                            </label>
                            <input id="count" name="count_rooms" type="number" value="{{old('count_rooms') }}"
                                   class="form-control"
                                   onkeypress="return (event.charCode >= 48 && event.charCode <= 57 && /^\d{0,2}$/.test(this.value));"
                                   placeholder="Количество комнат" autocomplete="off" required>
                        </div>
                        <br>
                        <div>
                            <label for="text_room"><b>Текст:</b></label><br>
                            <textarea class="form-control" placeholder="Введите текст..." name="text_room" id="text"
                                      rows="5" cols="85"> {{old('text_room')}}</textarea><br>
                        </div>
                        <br>
                        <div>
                            <label for="capacity"><b>Вместимость(человек):</b></label>
                            <input name="capacity" type="number" value="{{old('capacity') }}"
                                   class="form-control"
                                   onkeypress="return (event.charCode >= 48 && event.charCode <= 57 && /^\d{0,3}$/.test(this.value));"
                                   placeholder="Вместимость" autocomplete="off" required>
                        </div>
                        <br>

                        {{--                        Чекбоксы                                             --}}

                        <label for="service"><b>Сервис:</b></label><br>
                        <label class="checkbox-btn2">
                            <input type="checkbox" name="service[]"
                                   value="телевизор">
                            <span>Телевизор</span>
                        </label>

                        <label class="checkbox-btn2">
                            <input type="checkbox" name="service[]"
                                   value="фен">
                            <span>фен</span>
                        </label>

                        <label class="checkbox-btn2">
                            <input type="checkbox" name="service[]"
                                   value="утюг">
                            <span>утюг</span>
                        </label>

                        <label class="checkbox-btn2">
                            <input type="checkbox" name="service[]"
                                   value="холодильник">
                            <span>холодильник</span>
                        </label>

                        <label class="checkbox-btn2">
                            <input type="checkbox" name="service[]"
                                   value="кондиционер">
                            <span>кондиционер</span>
                        </label>
                        <br>
                        <br>


                        <div>
                            <label for="video"><b>Видео:</b></label>
                            <input name="video" type="text" value="{{old('video') }}"
                                   class="form-control"
                                   placeholder="https://www.youtube.com/embed/WviGn7gjhdw" autocomplete="off">
                        </div>
                        <br>
                        <br>
                        <div id="file" class="upload"></div>
                        <br>
                        <div class="preview"></div>
                        <div class="files" id="files"></div>

                        <button class="btn btn-primary" id="submit" type="submit">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script src="//api-maps.yandex.ru/2.1/?94532f3f-9b0c-4212-ba00-c873aeb2ab32&lang=ru_RU&load=SuggestView&onload=onLoad"></script>
        <script src="{{'js/ymaps/ymaps.js'}}"></script>

        <script src="{{ asset('dropzone/dropzone.min.js') }}" defer></script>
        <link href="{{ asset('dropzone/dropzone.min.css') }}" rel="stylesheet">
        <script src="{{ asset('dropzone/add.js') }}" defer></script>

        <script src="{{ asset('js/checkbox/checkbox.js') }}" defer></script>

        <script src="{{ asset('js/del_session/del_session.js') }}" defer></script>
    @endpush
@endsection
