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
                width: 250px;
            }

            .history>i, .history>strong {
                color: #2a9055;
            }

            .listItems, .historyListItems {
                background-color: #fff8b3;
                width:100%;
            }

            .quantity {
                width: 20px;
            }

            .finalPrice, .price {
                width:50px;
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
    <body onload="defaultPage()">
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
                <div class="d-flex mb-3 justify-content-end">
                    <button class="btn history" onclick="getHistory()">
                        <i class="fas fa-paper-plane mr-2"></i>
                        <strong>View History</strong>
                    </button>
                </div>
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
                        <div class="container">
                            <div class="row">
                                <h3>Expired Items</h3>
                            </div>
                            <div class="row">
                                <div class="expiredItems"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3>Shopping History</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" onclick="clear()">&times;</span>
                                </button>
                            </div>
                            <div class="alert-notification"></div>
                            <div class="modal-body">
                                <div class="listHistory d-flex flex-wrap"></div>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-danger">
                    You must be logged in to access this feature
                </div>
            @endauth
        @endsection
        <script>
            document.addEventListener('click', function (e) {
                if (e.target.nodeName === 'SPAN') {
                    $('.listHistory').empty()
                }
            })

            let historyItems = {}
            let expiredItems = {}
            let addItems = 0
            let totalPrice = 0

            function defaultPage() {
                $('#searchElement').val('')
                $('.finalPrice').val(0)
                $.ajax({
                    type: 'GET',
                    url: '/getExpiringItems',
                    success: function (data) {
                        console.log(data.expiringItems)
                        if (data.expiringItems) {
                            renderExpiredItems(data.expiringItems)
                        } else {
                            $('.expiredItems').append(
                                '<p>No items have expired</p>'
                            )
                        }
                    }
                })
            }

            function renderExpiredItems(items) {
                $('.expiredItems').empty()
                $.each(items, function (index, itemData) {
                    expiredItems[itemData.itemDetails.id] = itemData.itemDetails
                    $('.expiredItems').append(
                        '<div class="border-box" id="' + itemData.itemDetails.id + '">' +
                            '<div class="d-flex flex-wrap>"' +
                                '<label><strong>Name: </strong></label>' +
                                itemData.itemDetails.name + '<br>' +
                            '</div>' +
                            '<label><strong>Price:</strong></label>' +
                                itemData.itemDetails.price + '<br>' +
                            '<label><strong>Last Bought:</strong></label>' +
                                itemData.lastBought + '<br>' +
                            '<label><strong>Use By:</strong></label>' +
                                itemData.itemDetails.use_by + '<span> week(s) </span>' + '<br>' +
                            '<button class="btn btn-light" onclick="addRenderedItem(' + itemData.itemDetails.id + ')">Add Item</button>' +
                        '</div>'
                    )
                })
            }

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
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/postShoppingList',
                    data: JSON.stringify({0: historyItems}),
                    success: function (data) {
                        $('.finalPrice').val(0)
                        $('#searchElement').val('')
                        $.each(historyItems, function (id, quantity) {
                            $('#' + id).remove()
                        })
                        $('.defaultList').empty().append(
                            '<p>No items in list</p>'
                        )
                        $('.alert-notification').append(
                            '<div class="alert alert-success">List Saved</div>'
                        ).delay(3000).slideUp(200, function () {
                            $(this).alert('close')
                        })
                    }
                })
            }

            let item = null;
            let itemAdd = false

            function search() {
                item = window.document.getElementById('searchElement').value;

                if (item) {
                    $('.searchRender').empty()
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
                        'addedItems': historyItems,
                        'type': 2
                    }]),
                    success: function (data) {
                        if (data.data.length !== 0) {
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
                        } else {
                            $('.searchRender').append(
                                '<p>No items found in database/ All similar items are shown/added</p>'
                            )
                        }
                    }
                })
            }

            function addItem(id, name, price) {
                $('.defaultList').empty()
                if (totalPrice === '0.00') {
                    totalPrice = 0
                }

                addItems += 1
                historyItems[id] = 1
                totalPrice += price

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

            function increaseQuantity(id, price) {
                $('#' + id + ' .quantity').val(function (i, oldVal) {
                    historyItems[id] += 1
                    $('#' + id + ' .price').val(function () {
                        totalPrice += price
                        return historyItems[id]*price
                    })
                    return ++oldVal
                })
                $('.finalPrice').val(totalPrice)
            }

            function decreaseQuantity(id, price) {
                historyItems[id] -= 1
                $('#' + id + ' .quantity').val(function (i, oldVal) {
                    if (oldVal != 1) {
                        $('#' + id + ' .price').val(function () {
                            totalPrice = (totalPrice - price).toFixed(2)
                            return historyItems[id]*price
                        })
                        return --oldVal
                    } else {
                        if (historyItems[id] === 0) {
                            delete historyItems[id]
                            $('#' + id).remove()

                            if (expiredItems[id]) {
                                $('.expiredItems').append(
                                    '<div class="border-box" id="' + id+ '">' +
                                        '<div class="d-flex flex-wrap>"' +
                                            '<label><strong>Name: </strong></label>' +
                                            expiredItems[id].name + '<br>' +
                                        '</div>' +
                                        '<label><strong>Price:</strong></label>' +
                                        expiredItems[id].price + '<br>' +
                                        '<label><strong>Last Bought:</strong></label>' +
                                        expiredItems[id].lastBought + '<br>' +
                                        '<label><strong>Use By:</strong></label>' +
                                        expiredItems[id].use_by + '<span> week(s) </span>' + '<br>' +
                                        '<button class="btn btn-light" onclick="addRenderedItem(' + expiredItems[id].id + ')">Add Item</button>' +
                                    '</div>'
                                )
                            }

                            addItems -= 1
                            totalPrice = (totalPrice - price).toFixed(2)
                        }
                        if (addItems === 0) {
                            $('.defaultList').append(
                                '<p>No items in list</p>'
                            )
                        }
                    }
                })
                $('.finalPrice').val(totalPrice)
            }

            function getHistory() {
                $('.listHistory').empty()
                $.ajax({
                    type: 'GET',
                    url: '/getHistory',
                    success: function (data) {
                        $.each(data.history, function (index, listHistoryDetails) {
                            $('.listHistory').append(
                                '<div class="p-4 d-flex border-bottom">' +
                                    '<div class="d-flex">' +
                                        '<div class="container">' +
                                            '<div class="row">' +
                                                '<div class="col-12">' +
                                                    '<h3>' + listHistoryDetails.listId + '</h3>' +
                                                '</div>' +
                                            '</div>' +
                                            '<div class="row">' +
                                                '<div class="col-12">' +
                                                    '<label><strong>Date Created:</strong></label>' + listHistoryDetails.createdAt +
                                                '</div>' +
                                                '<div class="col-12">' +
                                                    '<label><strong>Total Items:</strong></label>' + listHistoryDetails.totalItems +
                                                '</div>' +
                                                '<div class="col-12">' +
                                                    '<label><strong>Total Price(&#163):</strong></label>' + listHistoryDetails.totalPrice +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="d-flex">' +
                                        '<div class="historyListItems" id="' + listHistoryDetails.listId + '">' +
                                            '<div class="d-flex border">' +
                                                '<div class="col-6">' +
                                                    '<p>Name</p>' +
                                                '</div>' +
                                                '<div class="col-2">' +
                                                    '<p>Quantity</p>' +
                                                '</div>' +
                                            '</div>' +
                                            '<div class="historyRender"></div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>'
                            )

                            $.each(listHistoryDetails.items, function (itemName, itemQuantity) {
                                $('#' + listHistoryDetails.listId + ' .historyRender').append(
                                    '<div class="d-flex border">' +
                                        '<div class="col-6">' +
                                            itemName +
                                        '</div>' +
                                        '<div class="col-2">' +
                                            itemQuantity +
                                        '</div>' +
                                    '</div>'
                                )
                            })
                        })
                    }
                })
                $('.modal').modal('show')
            }

            function addRenderedItem(id) {
                $('#' + id).remove();
                $('.defaultList').empty()
                if (totalPrice === '0.00') {
                    totalPrice = 0
                }

                addItems += 1
                historyItems[id] = 1
                totalPrice += expiredItems[id].price

                $('.finalPrice').val(totalPrice)
                $('.listItems').append(
                    '<div class="d-flex border" id="' + id + '">' +
                        '<div class="col-6">' +
                            expiredItems[id].name +
                        '</div>' +
                        '<div class="col-2">' +
                            '<input class="quantity" value="' + historyItems[id] + '">' +
                        '</div>' +
                        '<div class="col-2">' +
                            '<input class="price" value="' + expiredItems[id].price + '">' +
                        '</div>' +
                        '<div class="col-2">' +
                            '<button class="btn btn-light" onclick="decreaseQuantity(' + id + ', ' + expiredItems[id].price + ')"><i class="fas fa-minus"></i></button>' +
                            '<button class="btn btn-light" onclick="increaseQuantity(' + id + ', ' + expiredItems[id].price + ')"><i class="fas fa-plus"></i></button>' +
                        '</div>' +
                    '</div>'
                )
                $('.alert-notification').empty().append(
                    '<div class="alert alert-success">Item Added</div>'
                ).delay(3000).slideUp(200, function () {
                    $(this).alert('close')
                })
            }
        </script>
    </body>
</html>
