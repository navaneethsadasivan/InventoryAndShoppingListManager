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

            <button onclick="confirmList()">Confirm</button>
        @endsection

        <script>
            let itemIds = [];

            function generate() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    url: '/getList',
                    success: function (data) {
                        let itemName = Object.values(data['list'])
                        itemIds = Object.keys(data['list'])
                        window.document.getElementById('generateButton').disabled = true
                        itemName.forEach(insertItems)
                    }
                })
            }

            function insertItems(item, index) {
                window.document.getElementById('generatedList').innerHTML += item + '<br>'
            }

            function confirmList() {
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/postHistory',
                    data: JSON.stringify({0: itemIds}),
                    success: function (data) {
                    }
                })
            }
        </script>
    </body>
</html>
