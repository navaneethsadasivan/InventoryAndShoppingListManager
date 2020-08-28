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
            .modal {
                padding-top: 100px;
            }
            .modal-header {
                background-color: #2a9055;
            }
            .modal-header>h3 {
                color: white;
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
                        <p>Items</p>
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
                            <h3>Enter Item Details</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" onclick="clear()">&times;</span>
                            </button>
                        </div>
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
                                    <label><strong>Use By (in weeks)</strong></label>
                                    <input type="text" class="useBy" placeholder="Enter item use by">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" onclick="submit()">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endsection


        <script>
            document.addEventListener('click', function (e) {
                if (e.target.nodeName === 'SPAN' ||e.target.id === 'addItem') {
                    $('.name').val('')
                    $('.price').val('')
                    $('.useBy').val('')
                }
            })

            let itemList = null

            function getData() {
                $.ajax({
                    type: 'GET',
                    url: '/getItems',
                    success: function (data) {
                        itemList = data.items
                        render()
                    }
                })
            }

            function render() {
                if (itemList === null) {
                    $('.items').append('<p>Nothing to render</p>')
                } else {
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
                                    '<button class="btn btn-light"><i class="fas fa-edit"></i></button>' +
                                '</div>' +
                            '</div>'
                        )
                    })
                }
            }

            function submit() {
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/postAddItem',
                    data: JSON.stringify({
                        'name': $('.name').val(),
                        'price': $('.price').val(),
                        'useBy': $('.useBy').val()
                    }),
                    success: function () {
                        location.reload()
                    }
                })
            }

            function clear() {
                console.log('I work')
            }
        </script>
    </body>
</html>
