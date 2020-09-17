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
                width: 400px;
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

            .modal-header>h3 {
                color: white;
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
        </style>
        <title>Database</title>
    </head>
    <body onload="getData()">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @extends('layouts.app')

        @section('content')
            <div id="sideNav" class="side-nav">
                <button class="btn closebtn" onclick="closeNavBar()"><i class="fas fa-times"></i></button>
                <a href="{{route('welcome')}}">Home<i class="fas fa-home p-2"></i></a>
                <a href="{{route('inventory')}}">Inventory<i class="fas fa-warehouse p-2"></i></a>
                <a href="{{route('shoppingList')}}">Shopping List<i class="fas fa-clipboard-check p-2"></i></a>
                <a href="{{route('generate')}}">Generate List [Beta]<i class="fas fa-laptop-code p-2"></i></a>
            </div>
            <div id="main-body">
                @if (Route::has('login'))
                    <div class="header row">
                        <div class="page-title col-6">
                            <div class="d-flex align-items-center">
                                <button class="btn menu-icon" onclick="openNavBar()"><i class="fas fa-bars fa-2x"></i></button>
                                <p>Items</p>
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
                <div class="d-flex p-4 justify-content-end">
                    <button id="addItem" class="btn btn-success" data-toggle="modal" data-target=".modal">
                        <i class="fas fa-plus"></i>Add New Item
                    </button>
                </div>
                <div class="items d-flex justify-content-around flex-wrap"></div>

                <div class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3></h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" onclick="clear()">&times;</span>
                                </button>
                            </div>
                            <div class="alert-notification"></div>
                            <div class="modal-body">
                                <div class="d-flex row p-5">
                                    <div class="d-flex p-2 col-12 justify-content-between">
                                        <label><strong>Name</strong></label>
                                        <input type="text" class="name" placeholder="Enter item name">
                                    </div>
                                    <div class="d-flex p-2 col-12 justify-content-between">
                                        <label><strong>Price</strong></label>
                                        <input type="text" class="price" placeholder="Enter item price">
                                    </div>
                                    <div class="d-flex p-2 col-12 justify-content-between">
                                        <label><strong>Category</strong></label>
                                        <input type="text" class="type" placeholder="Enter item type">
                                    </div>
                                    <div class="d-flex p-2 col-12 justify-content-between">
                                        <label><strong>Use By (in weeks)</strong></label>
                                        <input type="text" class="useBy" placeholder="Enter item use by">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection


        <script>
            document.addEventListener('click', function (e) {
                if (e.target.nodeName === 'SPAN' || e.target.id === 'addItem') {
                    $('.modal-header h3').html('Enter Item Details')
                    $('.name').val('')
                    $('.price').val('')
                    $('.useBy').val('')
                    $('.type').val('')
                    $('.modal-footer').empty().append(
                        '<button class="btn btn-success" onclick="submit()">' +
                            '<i class="fas fa-paper-plane"></i>' +
                        '</button>'
                    )
                }
            })

            function openNavBar() {
                $('#sideNav').css('width', "250px")
                $('#main-body').css('marginLeft', "250px")
            }

            function closeNavBar() {
                $('#sideNav').css('width', 0)
                $('#main-body').css('marginLeft', 0)
            }

            let itemList = null
            let itemToEdit = null

            function getData() {
                $.ajax({
                    type: 'GET',
                    url: '/getItems',
                    success: function (data) {
                        if (data.items) {
                            itemList = data.items
                            render()
                        } else {
                            $('.items').empty().append(
                                '<p>' + data.message + '</p>'
                            )
                        }
                    }
                })
            }

            function render() {
                $('.items').empty()
                $.each(itemList, function (index, itemData) {
                    $('.items').append(
                        '<div class="d-flex border-box">' +
                            '<div class="d-flex col-8">' +
                                '<div class="d-inline-block">' +
                                    '<label>Name:  </label>' +
                                        itemData.name + '<br>'+
                                    '<label>Price:  </label>' +
                                        itemData.price + '<br>'+
                                    '<label>Category:  </label>' +
                                        itemData.type + '<br>'+
                                    '<label>Use By:  </label>' +
                                        itemData.use_by + '<span> week(s) </span>'+ '<br>'+
                                '</div>' +
                            '</div>' +
                            '<div class="d-flex col-3">' +
                                '<button class="btn btn-light" id="' + itemData.id + '" onclick="editItem(this.id)"><i class="fas fa-edit"></i></button>' +
                                '<button class="btn btn-danger" onclick="deleteItem(' + itemData.id + ')"><i class="fas fa-times"></i></button>' +
                            '</div>' +
                        '</div>'
                    )
                })
            }

            function submit() {
                let name = $('.name').val()
                let price = $('.price').val()
                let useBy = $('.useBy').val()
                let type = $('.type').val()

                if (name && price && useBy && type) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/postAddItem',
                        data: JSON.stringify([{
                            'name': name,
                            'price': price,
                            'useBy': useBy,
                            'type': type
                        }]),
                        success: function (data) {
                            if (data.Message !== 'Item added') {
                                $('.alert-notification').empty().append(
                                    '<div class="alert-danger">' + data.Message + '</div>'
                                ).slideDown(200).delay(2000).slideUp(200)
                            } else {
                                location.reload()
                            }
                        },
                    })
                } else {
                    $('.alert-notification').empty().append(
                        '<div class="alert-danger">Enter item details</div>'
                    ).slideDown(200).delay(3000).slideUp(200)
                }
            }

            function editItem(id) {
                $.each(itemList, function (index, itemData) {
                    if (itemData.id === Number.parseInt(id)) {
                        itemToEdit = itemData
                    }
                })

                $('.modal-header h3').html('Update Item')
                $('.name').val(itemToEdit.name)
                $('.price').val(itemToEdit.price)
                $('.type').val(itemToEdit.type)
                $('.useBy').val(itemToEdit.use_by)
                $('.modal-footer').empty().append(
                    '<button class="btn btn-success"">' +
                        '<i class="fas fa-check"></i>' +
                    '</button>'
                )
                $('.modal-footer button').click(function () {
                    let name = $('.name').val()
                    let price = $('.price').val()
                    let useBy = $('.useBy').val()
                    let type = $('.type').val()

                    if (
                        name === itemToEdit.name &&
                        price === (itemToEdit.price).toString() &&
                        useBy === (itemToEdit.use_by).toString() &&
                        type === itemToEdit.type
                    ) {
                        $('.alert-notification').empty().append(
                            '<div class="alert-danger">No changes made</div>'
                        ).slideDown(200).delay(2000).slideUp(200)
                    }else if (name === '' || price === '' || useBy === '') {
                        $('.alert-notification').empty().append(
                            '<div class="alert-danger">Item Detail cant be empty</div>'
                        ).slideDown(200).delay(2000).slideUp(200)
                    } else {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'PUT',
                            url: '/putUpdateItem',
                            data: JSON.stringify([{
                                'id': itemToEdit.id,
                                'name': name,
                                'type': type,
                                'price': price,
                                'useBy': useBy
                            }]),
                            success: function (data) {
                                if (data.Message !== 'Item updated') {
                                    $('.alert-notification').empty().append(
                                        '<div class="alert-danger">' + data.Message + '</div>'
                                    ).slideDown(200).delay(2000).slideUp(200)
                                } else {
                                    location.reload()
                                }
                            },
                        })
                    }
                })
                $('.modal').modal('show')
            }

            function deleteItem(id) {
                $.ajax({
                    type: 'DELETE',
                    url: '/deleteItem',
                    data: JSON.stringify([{
                        'id': id
                    }]),
                    success: function () {
                        location.reload()
                    }
                })
            }
        </script>
    </body>
</html>
