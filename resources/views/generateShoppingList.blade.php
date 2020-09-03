<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .top-right {
                text-align: right;
                width: 50%;
            }

            .header {
                background-color: #2a9055;
                padding: 5px;
            }
            .links > a {
                color: #ced4da;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .page-title {
                color: #ced4da;
                text-align: left;
                padding: 0 25px;
                font-size: 20px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                width: 50%;
            }
            #generatedList {
                background-color: #fff8b3;
            }
        </style>
    </head>
    <body>
        @extends('layouts.app')

        @section('content')
            @if (Route::has('login'))
                <div class="header row">
                    <div class="page-title col-6">
                        <p>Generate Shopping List</p>
                    </div>
                    <div class="top-right links col-6">
                        @auth
                            <a href="{{url('/')}}">Home</a>
                            <a href="{{ url('/home') }}">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>
                        @else
                            <a href="{{ route('login') }}">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </div>
                </div>
            @endif

            <div class="alert-notification"></div>

            @auth
                <div class="d-flex align-items-center justify-content-center my-4">
                    <button
                        onclick="generate()"
                        id="generateButton"
                        class="btn btn-primary"
                    >Generate List</button>
                </div>

                <div class="d-flex align-items-center justify-content-center my-4">
                    <div id="generatedList"></div>
                </div>

                <div class="d-flex align-items-center justify-content-center my-4">
                    <button onclick="confirmList()" class="btn btn-success confirmButton" hidden>Confirm</button>
                </div>
            @else
                <div class="alert alert-danger">
                    You must be logged in to access this feature
                </div>
            @endauth
        @endsection

        <script>
            let itemIds = {};

            function generate() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    url: '/getList',
                    success: function (data) {
                        console.log(data)
                        if (data.list) {
                            $('#generateButton').prop('hidden', true)
                            $('.confirmButton').prop('hidden', false)
                            $('#generatedList').append(
                                '<div class="d-flex row justify-content-between col-12">' +
                                '<p class="col-10 border-bottom"><strong>Item</strong></p>' +
                                '<p class="col-2 border-bottom"><strong>Price(&#163)</strong></p>' +
                                '</div>'
                            );
                            $.each(data.list, function (index, itemData) {
                                let id = itemData.id
                                itemIds[id] = 1
                                $('#generatedList').append(
                                    '<div class="d-flex justify-content-between">' +
                                    '<span class="col-10">' + itemData.name + '</span>' +
                                    '<span class="col-2">' + parseFloat(itemData.price).toFixed(2) + '</span>' +
                                    '<button class="btn btn-light" id="'+ itemData.id +'" onclick="removeItem(this.id)">X</button>' +
                                    '</div>'
                                )
                            })
                        }
                    }
                })
            }

            function confirmList() {
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/postNewList',
                    data: JSON.stringify({0: itemIds}),
                    success: function (data) {
                        $('#generatedList').empty();
                        $('.alert-notification').append(
                            '<div class="alert-success">List has been confirmed</div>'
                        ).delay(3000).slideUp(200, function () {
                            $(this).alert('close')
                        })
                        $('#generateButton').prop('hidden', false)
                        $('.confirmButton').prop('hidden', true)
                    }
                })
            }

            function removeItem(itemId) {
                itemIds.splice(itemIds.indexOf(itemId), 1)
            }
        </script>
    </body>
</html>
