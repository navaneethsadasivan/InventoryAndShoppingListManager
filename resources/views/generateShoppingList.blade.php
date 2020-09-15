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

            .border-box {
                border: solid 1px black;
                border-radius: 20px;
                padding: 5px;
                margin: 5px;
                background-color: #a1cbef;
                width: 350px;
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
                width: 400px;
                background-color: #fff8b3;
            }

            .menu-icon {
                color: #ced4da;
                font-size: 30px;
            }

            .side-nav {
                height: 100%;
                width: 0;
                position: fixed;
                z-index: 1;
                top: 0;
                left: 0;
                background-color: #2a9055;
                overflow-x: hidden;
                transition: 0.5s;
                padding-top: 60px;
            }

            .side-nav a {
                padding: 8px 8px 8px 32px;
                text-decoration: none;
                font-size: 25px;
                color: black;
                display: block;
                transition: 0.3s;
            }

            .side-nav a:hover {
                color: #f1f1f1;
            }

            .side-nav .closebtn {
                position: absolute;
                top: 0;
                right: 25px;
                font-size: 36px;
                margin-left: 50px;
            }

            .modal {
                padding-top: 100px;
            }

            .modal-header {
                background-color: #2a9055;
            }
        </style>
    </head>
    <body>
        @extends('layouts.app')

        @section('content')
            <div id="sideNav" class="side-nav">
                <button class="btn closebtn" onclick="closeNavBar()"><i class="fas fa-times"></i></button>
                <a href="{{route('welcome')}}">Home<i class="fas fa-home p-2"></i></a>
                <a href="{{route('item')}}">Items<i class="fas fa-database p-2"></i></a>
                <a href="{{route('inventory')}}">Inventory<i class="fas fa-warehouse p-2"></i></a>
                <a href="{{route('shoppingList')}}">Shopping List<i class="fas fa-clipboard-check p-2"></i></a>
            </div>
            <div id="main-body">
                @if (Route::has('login'))
                    <div class="header row">
                        <div class="page-title col-6">
                            <div class="d-flex align-items-center">
                                <button class="btn menu-icon" onclick="openNavBar()"><i class="fas fa-bars fa-2x"></i></button>
                                <p>Generate Shopping List [BETA]</p>
                            </div>
                        </div>
                        <div class="top-right links col-6">
                            @auth
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
                    <div class="d-flex p-2 justify-content-end">
                        <button id="add-item" class="btn btn-success" data-toggle="modal" data-target=".modal" hidden>
                            <i class="fas fa-plus"></i>Add item
                        </button>
                    </div>

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
            </div>
        @endsection

        <script>
            document.addEventListener('click', function (e) {
                if (e.target.nodeName === 'SPAN' || e.target.id === 'add-item') {
                    $('.searchElement').val('')
                    $('.searchItems').empty()
                }
            })

            let itemIds = {};

            function openNavBar() {
                $('#sideNav').css('width', "250px")
                $('#main-body').css('marginLeft', "250px")
            }

            function closeNavBar() {
                $('#sideNav').css('width', 0)
                $('#main-body').css('marginLeft', 0)
            }

            function generate() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    url: '/getList',
                    success: function (data) {
                        if (data.list) {
                            $('#generateButton').prop('hidden', true)
                            $('.confirmButton').prop('hidden', false)
                            $('#add-item').prop('hidden', false)
                            $('#generatedList').append(
                                '<div class="container">' +
                                    '<div class="row">' +
                                        '<h4 class="col-8 border-bottom"><strong>Item</strong></h4>' +
                                        '<h4 class="col-4 border-bottom"><strong>Price(&#163)</strong></h4>' +
                                    '</div>' +
                                '</div>'
                            );
                            $.each(data.list, function (index, itemData) {
                                addItem(itemData.id, itemData.name, itemData.price)
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
                    url: '/postShoppingList',
                    data: JSON.stringify([{
                        'listItems': itemIds
                    }]),
                    success: function () {
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
                delete itemIds[itemId]
                $('#' + itemId).remove()

                if ($.isEmptyObject(itemIds)) {
                    $('#generatedList').append(
                        '<p>No items to display</p>'
                    )
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
                        'addedItems': itemIds,
                        'type': 3
                    }]),
                    success: function (data) {
                        if (data) {
                            $('.searchItems').empty()
                            searchItems = data
                            $.each(searchItems, function (index, itemData) {
                                if (itemData) {
                                    let itemDetails = {
                                        id: itemData.id,
                                        name: itemData.name,
                                        price: itemData.price,
                                        type: 1
                                    }
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
                                        '<button class="btn btn-light" id="' + itemData.id + '" value="' + itemData.name +'" onclick="addItem(this.id, this.value, ' + itemData.price + ')">Add Item</button>' +
                                        '</div>'
                                    )
                                }
                            })
                        }
                    }
                })
            }

            function addItem(id, name, price) {
                itemIds[id] = 1;
                $('#generatedList').append(
                    '<div class="d-flex justify-content-between" id="'+ id+'">' +
                    '<span class="col-10">' + name + '</span>' +
                    '<span class="col-2">' + parseFloat(price).toFixed(2) + '</span>' +
                    '<button class="btn btn-light" onclick="removeItem(' + id +')"><i class="fas fa-times"></i></button>' +
                    '</div>'
                )
            }
        </script>
    </body>
</html>
