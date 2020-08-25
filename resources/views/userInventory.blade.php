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
                border-radius: 20px;
                padding: 5px;
                margin: 5px;
                background-color: #a1cbef;
                width: 25%;
            }
            .items {
                width: 100%;
            }
        </style>
    </head>
    <body onload="getData()">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @extends('layouts.app')

        @section('content')
            @if (Route::has('login'))
                <div class="header row">
                    <div class="page-title col-6">
                        <p>Inventory</p>
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
            <div class="items d-flex justify-content-around flex-wrap">
            </div>
        @endsection

        <script>
            let itemList = null
            let currentItemForChange = null;

            function getData() {
                $.ajax({
                    type: 'GET',
                    url: '/getUserInventory',
                    success: function (data) {
                        itemList = data.items
                        console.log(itemList)
                        render()
                    }
                })
            }

            function render() {
                if (itemList === null) {
                    $('.items').append('<p>Nothing to render</p>')
                } else {
                    $.each(itemList, function (index, itemData) {
                        $('.items').append(
                            '<div class="border-box">' +
                                '<label>Name:  </label>' +
                                itemData.itemDetails.name + '<br>'+
                                '<label>Price:  </label>' +
                                itemData.itemDetails.price + '<br>'+
                                '<label>Category:  </label>' +
                                itemData.itemDetails.type + '<br>'+
                                '<label>Use By:  </label>' +
                                itemData.itemDetails.use_by + '<span> week(s) </span>'+ '<br>'+
                                '<label><strong>Current Stock: </strong></label>' +
                                '<div class="d-flex mx-2">' +
                                    '<button class="btn btn-light" id="' + itemData.itemDetails.id + '" onclick="removeItem(this.id)">-</button>' +
                                    '<input type="text" value="' + itemData.currentStock + '"><br>' +
                                    '<button class="btn btn-light" id="' + itemData.itemDetails.id + '" onclick="addItem(this.id)">+</button>' +
                                '</div>' +
                            '</div>'
                        )
                    })
                }
            }

            function addItem(id) {
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/postAddItemUserInventory',
                    data: id,
                    success: function () {
                       location.reload()
                    }
                })
            }

            function removeItem(id) {
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/postRemoveItemUserInventory',
                    data: id,
                    success: function () {
                        location.reload()
                    }
                })
            }
        </script>
    </body>
</html>
