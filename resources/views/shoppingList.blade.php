<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .title {
                font-size: 84px;
                margin: auto;
                text-align: center;
            }
        </style>
    </head>
    <body>
        @extends('layouts.app')

        @section('content')
            <navbar title="Shopping List"></navbar>

            <button onclick="generate()" id="generateButton">Generate List</button>

            <div id="generatedList"></div>
        @endsection

        <script>
            function generate() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    url: '/getList',
                    success: function (data) {
                        console.log(data)
                        window.document.getElementById('generateButton').disabled = true

                        data['list'].forEach(insertItems)
                    }
                })
            }

            function insertItems(item, index) {
                window.document.getElementById('generatedList').innerHTML += item + '<br>'
            }
        </script>
    </body>
</html>
