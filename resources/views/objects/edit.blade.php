@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/checkbox.css') }}" rel="stylesheet">
    <section>
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8">
                    <h1 style="margin: 40px 0 60px 0">Редактировать объект</h1>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="form">
                        @csrf
                        <div>
                            <label for="title"><b>Заголовок:</b></label>
                            <input name="title" type="text" value="{{$obj->title ?? old('title')}}"
                                   class="form-control"
                                   placeholder="Заголовок" autocomplete="off" required>
                        </div>
                        <br>
                        <div>
                            <label for="address"><b>Адрес:</b></label>
                            <input name="address" type="text" value="{{$obj->address ?? old('address') }}"
                                   class="form-control" id="suggest"
                                   placeholder="Адрес" autocomplete="off" readonly>
                        </div>
                        <br>
                        <div>
                            <label for="price"><b>Цена:</b></label>
                            <input name="price" type="number" value="{{$obj->price ?? old('price') }}"
                                   class="form-control"
                                   onkeypress="return (event.charCode >= 48 && event.charCode <= 57 && /^\d{0,8}$/.test(this.value));"
                                   placeholder="Цена" autocomplete="off" required>
                        </div>
                        <br>
                        <div>
                            <label for="area"><b>Общая площадь:</b></label>
                            <input id="area" name="area" type="text" value="{{$obj->area ?? old('area') }}"
                                   onkeyup="return checkСommas(this);"
                                   class="form-control"
                                   placeholder="Общая площадь" autocomplete="off" required>
                        </div>
                        <br>
                        <div>
                            <label for="floor"><b>Этаж:</b></label>
                            <input name="floor" type="number" value="{{$obj->floor ?? old('floor') }}"
                                   onkeypress="return (event.charCode >= 48 && event.charCode <= 57 && /^\d{0,3}$/.test(this.value));"
                                   class="form-control"
                                   placeholder="Этаж" autocomplete="off" required>
                        </div>
                        <br>

                        <label class="checkbox-btn2">
                            <input type="checkbox" name="balcony[]"
                                   @php
                                       if (in_array("балкон", $balcony)) {
                                           echo 'checked';

                                       }@endphp
                                   value="балкон">
                            <span>Балкон</span>
                        </label>
                        <label class="checkbox-btn2">
                            <input type="checkbox" name="balcony[]"
                                   @php
                                       if (in_array("лоджия", $balcony)) {
                                           echo 'checked';

                                       }@endphp
                                   value="лоджия">
                            <span>Лоджия</span>
                        </label>
                        <br>
                        <br>
                        <div>
                            <label for="rooms"><b>Количество комнат:</b></label><br>
                            <label class="checkbox-btn2">
                                <input type="checkbox" name="count_rooms" id="rooms"
                                       value="студия"
                                        @php
                                            if ($obj->count_rooms === "студия") {
                                                echo 'checked';

                                            }@endphp>
                                <span>Студия</span>
                            </label>

                            <input id="count" name="count_rooms" type="number"
                                   value="{{$obj->count_rooms ?? old('count_rooms') }}"
                                   class="form-control"
                                   onkeypress="return (event.charCode >= 48 && event.charCode <= 57 && /^\d{0,2}$/.test(this.value));"
                                   placeholder="Количество комнат" autocomplete="off" required>
                        </div>
                        <br>

                        <div>
                            <label for="capacity"><b>Вместимость(человек):</b></label>
                            <input name="capacity" type="number" value="{{$obj->capacity ?? old('capacity') }}"
                                   class="form-control"
                                   onkeypress="return (event.charCode >= 48 && event.charCode <= 57 && /^\d{0,3}$/.test(this.value));"
                                   placeholder="Вместимость" autocomplete="off" required>
                        </div>
                        <br>

                        {{--                        Чекбоксы                                             --}}

                        @include('objects/blocks/service')
                        <br>

                        <div>
                            <label for="text_room"><b>Текст:</b></label><br>
                            <textarea class="form-control" placeholder="Введите текст..." name="text_room" id="text"
                                      rows="5" cols="85"> {{$obj->text_obj?? old('text_obj')}}</textarea><br>
                        </div>
                        <br>
                        <div>
                            <label for="video"><b>Видео:</b></label>
                            <input name="video" type="text" value="{{$obj->path ?? old('video') }}"
                                   class="form-control"
                                   placeholder="https://www.youtube.com/embed/WviGn7gjhdw" autocomplete="off">
                        </div>
                        <br>
                        <br>
                        <div id="file" class="upload"></div>
                        <br>

                        <div class="files" id="files"></div>
                        <div class="file" id="file">
                            @if (!empty($images))
                                @foreach ($images as $item)
                                    <img class="img-thumbnail del" src="{{ asset("images/$item") }}/" alt=""
                                         data-file="{{$item}}">
                                @endforeach
                            @endif
                        </div>
                        <div class="preview" id="preview"></div>
                        <button class="btn btn-primary submit" id="submit" type="submit">Сохранить</button>
                        <a href='{{route('object.view', ['id' => $obj->id])}}' type='button'
                           class='btn btn-success' style="margin: 5px">Просмотр</a>

                        <a onClick="return confirm('Подтвердите удаление!')"
                           href='{{route('object.delete', ['id' => $obj->id])}}' type='button'
                           class='btn btn-danger' style="margin: 5px">Удалить</a>
                        <img src="{{ asset('images/loader/preloader.svg') }}" width="35px" height="auto" alt=""
                             class="preloader-img"/>
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

        <script>
            var id = @json($obj->id);
            var countRoom = @json($obj->count_rooms);
        </script>
        <script>
            if (countRoom === "студия") {
                document.getElementById('count').disabled = true;
            }
        </script>
        <script src="{{ asset('dropzone/edit.js') }}" defer></script>
        <script src="{{ asset('js/checkbox/checkbox.js') }}" defer></script>
        <script src="{{ asset('js/checkСommas/checkСommas.js') }}" defer></script>


    @endpush
@endsection
