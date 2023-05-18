@extends('layouts.without_app_locality')
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
        </style>
    @endpush
    @push('scripts')
        <script src="{{asset('js/preloader/preloader.js')}}"></script>
    @endpush
    <div class="container-fluid mt-4" style="white-space: nowrap">
        <div class="card">
            <div class="card-body" style="background-color: cadetblue;">
                <form method="post" action="{{route('get.city')}}">
                    @csrf
                    <div class="form-group">
                        <div class="main-search-input-wrap search">
                            <div class="main-search-input fl-wrap">
                                <div class="main-search-input-item">
                                    <input id="value" type="text" value="" placeholder="Начните вводить город">
                                </div>

                                <button style="background-color: #50898b" class="main-search-button">Применить
                                </button>
                            </div>
                            <br>
                            <div id="dropdown" style="margin-top: 40px">
                                <select class="select" name="list" id="list"></select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    @push('scripts')
        <script src="{{ asset('js/search/search_locality.js') }}" defer></script>
    @endpush

@endsection