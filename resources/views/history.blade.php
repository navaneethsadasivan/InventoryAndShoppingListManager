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

            .listItems {
                background-color: #fff8b3;
                width:100%;
            }

            .quantity {
                width: 20px;
            }

            .finalPrice, .price {
                width:50px;
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
                        <p>Shopping List</p>
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
                <div class="d-flex justify-content-around">
                    <div class="col-8">
                        <div class="d-flex align-items-center justify-content-center p-5">
                            <input id="searchElement" class="p-2 mr-2" type="text" placeholder="Type in the item">
                            <button onclick="search()" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="searchRender d-flex justify-content-center flex-wrap"></div>
                        <div class="d-flex align-items-center justify-content-center my-4">
                            <div class="listItems">
                                <div class="d-flex border">
                                    <div class="col-6">
                                        <p>Name</p>
                                    </div>
                                    <div class="col-2">
                                        <p>Quantity</p>
                                    </div>
                                    <div class="col-2">
                                        <p>Price</p>
                                    </div>
                                    <div class="col-2">
                                        <p>Action</p>
                                    </div>
                                </div>
                                <div class="defaultList d-flex justify-content-around border">
                                    <p>No items in list</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center my-4">
                            <div class="d-flex justify-content-end p-2">
                                <span>Total Price(&#163): </span>
                                <input class="finalPrice" value="0">
                            </div>
                            <button id="final-submit" class="btn btn-success" onclick="finalSubmit()">Confirm</button>
                        </div>
                    </div>
                    <div class="d-flex col-4 border-left">
                        <h3>Expired Items</h3>
                    </div>
                </div>
            @else
                <div class="alert alert-danger">
                    You must be logged in to access this feature
                </div>
            @endauth
        @endsection
        <script>
            let historyItems = {}
            let addItems = 0
            let totalPrice = 0

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
                console.log(historyItems)
                // $.ajax({
                //     headers : {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     },
                //     type: 'POST',
                //     url: '/postHistory',
                //     data: JSON.stringify({0: historyItems}),
                //     success: function (data) {
                //     }
                // })
            }

            let item = null;
            let itemAdd = false

            function search() {
                item = window.document.getElementById('searchElement').value;

                if (item) {
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
                    data: JSON.stringify([{
                        'itemName': item,
                        'type': 1
                    }]),
                    success: function (data) {
                        if (data) {
                            $.each(data.data, function (index, item) {
                                $('.searchRender').append(
                                    '<div class="border-box">' +
                                    '<div class="d-flex flex-wrap">' +
                                        '<label><strong>Name:</strong></label>' +
                                        item.name + '<br>'+
                                    '</div>' +
                                    '<label><strong>Price:</strong></label>' +
                                    item.price + '<br>'+
                                    '<label><strong>Use By:</strong></label>' +
                                    item.use_by + '<span> week(s) </span>'+ '<br>'+
                                    '<button class="btn btn-light" id="' + item.id + '" value="' + item.name + '"onclick="addItem(this.id, this.value,' + item.price + ')">Add Item</button>' +
                                    '</div>'
                                )
                            })
                        }
                    }
                })
            }

            function addItem(id, name, price) {
                $('.defaultList').empty()

                if (historyItems[id]) {
                    $('#' + id + ' .quantity').val(function (i, oldVal) {
                        historyItems[id] += 1
                        return ++oldVal
                    })
                } else {
                    addItems += 1
                    historyItems[id] = 1
                    totalPrice += Number.parseFloat(price).toFixed(2)
                    $('.finalPrice').val(totalPrice)
                    $('.listItems').append(
                        '<div class="d-flex border" id="' + id + '">' +
                            '<div class="col-6">' +
                                name +
                            '</div>' +
                            '<div class="col-2">' +
                                '<input class="quantity" value="' + historyItems[id] + '">' +
                            '</div>' +
                            '<div class="col-2">' +
                                '<input class="price" value="' + price + '">' +
                            '</div>' +
                            '<div class="col-2">' +
                                '<button class="btn btn-light" onclick="decreaseQuantity(' + id + ', ' + price + ')"><i class="fas fa-minus"></i></button>' +
                                '<button class="btn btn-light" onclick="increaseQuantity(' + id + ', ' + price + ')"><i class="fas fa-plus"></i></button>' +
                            '</div>' +
                        '</div>'
                    )
                    $('.searchRender').empty();
                    $('.alert-notification').empty().append(
                        '<div class="alert alert-success">Item Added</div>'
                    ).delay(3000).slideUp(200, function () {
                        $(this).alert('close')
                    })
                }
            }

            function increaseQuantity(id, price) {
                $('#' + id + ' .quantity').val(function (i, oldVal) {
                    historyItems[id] += 1
                    $('#' + id + ' .price').val(function () {
                        totalPrice += Number.parseFloat(price).toFixed(2)
                        return historyItems[id]*price
                    })
                    return ++oldVal
                })
                console.log(totalPrice)
                $('.finalPrice').val(totalPrice)
            }

            function decreaseQuantity(id, price) {
                historyItems[id] -= 1
                $('#' + id + ' .quantity').val(function (i, oldVal) {
                    if (oldVal != 1) {
                        $('#' + id + ' .price').val(function () {
                            totalPrice -= Number.parseFloat(price).toFixed(2)
                            return historyItems[id]*price
                        })
                        return --oldVal
                    } else {
                        if (historyItems[id] === 0) {
                            delete historyItems[id]
                            $('#' + id).remove()
                            addItems -= 1
                            totalPrice -= Number.parseFloat(price).toFixed(2)
                        }
                        if (addItems === 0) {
                            $('.defaultList').append(
                                '<p>No items in list</p>'
                            )
                            $('.finalPrice').val(totalPrice)
                        }
                    }
                })
                console.log(totalPrice)
                $('.finalPrice').val(totalPrice)
            }
        </script>
    </body>
</html>
