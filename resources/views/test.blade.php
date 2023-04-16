@extends('layouts.app')
@section('content')
    <style>
        select#list {
            width: 100%;
            border: none;
        }
    </style>
@endsection

<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 Autocomplete Textbox From Database with jQuery Ajax - MakeCodes.ru</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>

<body>

<div class="container mt-4">

    <div class="card">
        <div class="card-header text-center font-weight-bold">
            <h2>Поиск по городу</h2>
        </div>

        <div class="card-body">
            <form  method="post" action="#">
                @csrf

                <div class="form-group">
                    <label for="name">Город</label>
                    <input type="text" id="value" name="name"
                           class="form-control" placeholder="Начните вводить город">
                    <div id="dropdown">
                        <select name="list" id="list"></select>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        document.getElementById('dropdown').style.display = 'none';

        $("#value").autocomplete({

            source: function (request, response) {
                var $this = $(this);
                file = $this.data('value');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/autocomplete",
                    data: $("#value"),
                    dataType: "json",
                    success: function (data) {
                        var arr = data;
                        // var resp = $.map(data, function (obj) {
                        //     return obj.name;
                        // });
                        // response(resp);
                        var input = document.getElementById('value');
                        var optionsVal = document.getElementById('list');
                        console.log(arr);

                        input.addEventListener('keyup', show);
                        optionsVal.onclick = function(){
                            setVal(this);
                        };

                        //shows the list
                        function show(){
                            var dropdown = document.getElementById('dropdown');
                            dropdown.style.display = 'none';

                            optionsVal.options.length = 0;

                            if(input.value){
                                dropdown.style.display = 'block';
                                optionsVal.size = 2;
                                var textCountry = input.value;

                                for(var i = 0; i < arr.length; i++){
                                    if(arr[i].indexOf(textCountry) !== -1){
                                        //addvalue
                                        addValue(arr[i],arr[i]);

                                    }
                                }

                            }
                        }

                        function addValue(text,val){
                            var createOptions = document.createElement('option');
                            optionsVal.appendChild(createOptions);
                            createOptions.text = text;
                            createOptions.value = val;
                        }

                        //Settin the value in the box by firing the click event
                        function setVal(selectedVal){
                            input.value = selectedVal.value;
                            document.getElementById('dropdown').style.display='none';
                        }
                    }
                });
            },
        });
    });
</script>


{{--<script src="{{ asset('auto.js') }}"></script>--}}
</body>

</html>