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
                width: 350px;
            }
            .items {
                width: 100%;
            }

            .modal {
                padding-top: 100px;
            }

            .modal-header {
                background-color: #2a9055;
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
                @auth
                    <div class="d-flex justify-content-end align-items-center">
                        <button class="btn" data-toggle="modal" data-target=".modal">
                            <i class="fas fa-plus d-flex"><p style="font-size: 1rem">Add new Item</p></i>
                        </button>
                    </div>

                    <div class="d-flex justify-content-around mt-4">
                        <div class="col-8">
                            <h3>Current Inventory</h3>
                            <div class="items d-flex justify-content-start flex-wrap"></div>
                        </div>
                        <div class="col-4 border-left">
                            <h3>Previously Bought Items</h3>
                            <div class="prevItems d-flex justify-content-start flex-wrap"></div>
                        </div>
                    </div>

                    <div class="modal fade" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3>Add Item</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="d-flex row align-items-center justify-content-center p-5">
                                        <input class="searchElement p-2 mr-2" type="text" placeholder="Type in the item">
                                        <button onclick="search()" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="searchItems d-flex flex-wrap"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger">
                        You must be logged in to access this feature
                    </div>
                @endauth
            @endif
        @endsection

        <script>
            let itemList = null
            let previousBoughtItems = null
            let searchItems = []

            function getData() {
                if ({{$user}}) {
                    $.ajax({
                        type: 'GET',
                        url: '/getUserInventory',
                        success: function (data) {
                            itemList = data.items
                            render()
                        }
                    })

                    $.ajax({
                        type: 'GET',
                        url: '/getPrevBoughtItemUser',
                        success: function (data) {
                            previousBoughtItems = data.prevItems
                            renderPrevItems(data.prevItems)
                        }
                    })
                }
            }

            function render() {
                if (itemList === null) {
                    $('.items').append('<p>Nothing to render</p>')
                } else {
                    $.each(itemList, function (index, itemData) {
                        $('.items').append(
                            '<div class="border-box">' +
                                '<div class="d-flex">' +
                                    '<label><strong>Name:</strong></label>' +
                                    itemData.itemDetails.name + '<br>'+
                                '</div>' +
                                '<label><strong>Price:</strong></label>' +
                                itemData.itemDetails.price + '<br>'+
                                '<label><strong>Category:</strong></label>' +
                                itemData.itemDetails.type + '<br>'+
                                '<label><strong>Use By:</strong></label>' +
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

            function renderPrevItems(items) {
                if (items.length === 0) {
                    $('.prevItems').append(
                        '<p>No previous items found</p>'
                    )
                } else {
                    $('.prevItems').empty()
                    $.each(items, function (index, itemData) {
                        $('.prevItems').append(
                            '<div class="border-box">' +
                                '<div class="d-flex flex-wrap>"' +
                                    '<label><strong>Name: </strong></label>' +
                                    itemData[0].name + '<br>' +
                                '</div>' +
                                '<label><strong>Price:</strong></label>' +
                                itemData[0].price + '<br>' +
                                '<label><strong>Use By:</strong></label>' +
                                itemData[0].use_by + '<span> week(s) </span>' + '<br>' +
                                '<button class="btn btn-light" id="' + itemData[0].id + '" value="' + itemData[0].name + '"onclick="addItem(this.id)">Add Item</button>' +
                            '</div>'
                        )
                    })
                }
            }

            function search() {
                let item = $('.searchElement').val()
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/postSearchItem',
                    data: JSON.stringify([{
                        'itemName': item,
                        'type': 1
                    }]),
                    success: function (data) {
                        if (data) {
                            $('.searchItems').empty()
                            searchItems = data.data
                            $.each(searchItems, function (index, itemData) {
                                if (itemData) {
                                    $('.searchItems').append(
                                        '<div class="border-box">' +
                                            '<div class="d-flex flex-wrap>"' +
                                                '<label><strong>Name: </strong></label>' +
                                                itemData.name + '<br>' +
                                            '</div>' +
                                            '<label><strong>Price:</strong></label>' +
                                            itemData.price + '<br>' +
                                            '<label><strong>Use By:</strong></label>' +
                                            itemData.use_by + '<span> week(s) </span>' + '<br>' +
                                            '<button class="btn btn-light" id="' + itemData.id + '" value="' + itemData.name + '"onclick="addItem(this.id)">Add Item</button>' +
                                        '</div>'
                                    )
                                }
                            })
                        }
                    }
                })
            }
        </script>
    </body>
</html>
