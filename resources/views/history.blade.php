<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
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

            .border-box {
                border: solid 1px black;
                padding: 5px;
                margin: 5px;
                background-color: #a1cbef;
                width: 25%;
            }

            .shopping-list {
                background-color: #fff8b3;
                width: auto;
            }
        </style>
    </head>
    <body>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @extends('layouts.app')

        @section('content')
            @if (Route::has('login'))
                <div class="header row">
                    <div class="page-title col-6">
                        <p>Enter History</p>
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
                <div class="d-flex row align-items-center justify-content-center p-5">
                    <input id="searchElement" class="p-2 mr-2" type="text" placeholder="Type in the item">
                    <button onclick="search()" class="btn btn-primary">Search</button>
                </div>
                <div id="searchRender" class="d-flex justify-content-center flex-wrap"></div>
                <div id="listItems" class="shopping-list d-flex justify-content-center"></div>
                <button id="final-submit" class="btn btn-success" onclick="finalSubmit()">Confirm</button>
            @else
                <div class="alert alert-danger">
                    You must be logged in to access this feature
                </div>
            @endauth
        @endsection
        <script>
            let historyItems = []

            function enter(listNumber, itemListNumber) {
                let item = this.document.getElementById(listNumber).value;

                if (item.search("\n")) {
                    item = item.split("\n")

                    for(let i = 0; i < item.length; i++) {
                        if (item[i] !== null && item[i] !== "" && item[i].length !== 0) {
                            this.document.getElementById(listNumber).style.borderColor = 'black'

                            this.document.getElementById(itemListNumber).innerHTML += item[i] + '</br>'

                            this.document.getElementById(listNumber).value = ''
                        } else {
                            this.document.getElementById(listNumber).style.borderColor = 'red'
                        }
                    }
                }
            }

            function submit(itemListNumber) {
                let itemList = this.document.getElementById(itemListNumber).innerText
                let items = itemList.split('\n')

                historyItems.push(items.filter(item => item))
            }

            function finalSubmit() {
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/postHistory',
                    data: JSON.stringify({0: historyItems}),
                    success: function (data) {
                    }
                })
            }

            let item = null;
            let itemAdd = false

            function search() {
                item = window.document.getElementById('searchElement').value;

                if (item) {
                    window.document.getElementById('searchElement').style.borderColor = 'black';
                    window.document.getElementById('searchRender').innerHTML = '';
                    sendData()
                } else {
                    window.document.getElementById('searchElement').style.borderColor = 'red';
                    $('.alert-notification').append(
                        '<div class="alert alert-danger">Enter an item to search</div>'
                    ).delay(3000).slideUp(200, function () {
                        $(this).alert('close')
                    })
                }
            }

            function sendData() {
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/postSearchItem',
                    data: JSON.stringify(item),
                    success: function (data) {
                        if (data) {
                            data['data'].forEach(render)
                        }
                    }
                })
            }

            function render(item, index) {
                $('#searchRender').append(
                    '<div class="border-box">' +
                        '<label><strong>Name: </strong></label>' +
                        item.name + '<br>'+
                        '<label><strong>Price: </strong></label>' +
                        item.price + '<br>'+
                        '<label><strong>Use By: </strong></label>' +
                        item.use_by + '<span> week(s) </span>'+ '<br>'+
                        '<button class="btn btn-light" id="' + item.id + '" value="' + item.name + '"onclick="addItem(this.id, this.value)">Add Item</button>' +
                    '</div>'
                )
            }

            function addItem(id, name) {
                $('#listItems').append(
                    '<div class="flex-row"> ' +
                        '<p>' + name + '</p>' +
                    '</div>'
                )
                historyItems.push(id);
                $('#searchRender').empty();
                $('.alert-notification').empty().append(
                    '<div class="alert alert-success">Item Added</div>'
                ).delay(3000).slideUp(200, function () {
                    $(this).alert('close')
                })
            }
        </script>
    </body>
</html>
