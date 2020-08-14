<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <body>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @extends('layouts.app')

        @section('content')
            <navbar title="History"></navbar>

{{--        <div class="list-1">--}}
{{--            <p>Enter the items in list 1</p>--}}
{{--            <textarea id="item-list-1"></textarea>--}}
{{--            <button onclick="enter('item-list-1', 'list-items-1')">Enter</button>--}}
{{--            <p id="list-items-1"></p>--}}
{{--            <button onclick="submit('list-items-1')">Submit</button>--}}
{{--        </div>--}}
{{--        <hr>--}}
{{--        <div class="list-2">--}}
{{--            <p>Enter the items in list 2</p>--}}
{{--            <textarea id="item-list-2"></textarea>--}}
{{--            <button onclick="enter('item-list-2','list-items-2')">Enter</button>--}}
{{--            <p id="list-items-2"></p>--}}
{{--            <button onclick="submit('list-items-2')">Submit</button>--}}
{{--        </div>--}}
{{--        <hr>--}}
{{--        <div class="list-3">--}}
{{--            <p>Enter the items in list 3</p>--}}
{{--            <textarea id="item-list-3"></textarea>--}}
{{--            <button onclick="enter('item-list-3','list-items-3')">Enter</button>--}}
{{--            <p id="list-items-3"></p>--}}
{{--            <button onclick="submit('list-items-3')">Submit</button>--}}
{{--        </div>--}}
{{--        <hr>--}}
{{--        <div class="list-4">--}}
{{--            <p>Enter the items in list 4</p>--}}
{{--            <textarea id="item-list-4"></textarea>--}}
{{--            <button onclick="enter('item-list-4','list-items-4')">Enter</button>--}}
{{--            <p id="list-items-4"></p>--}}
{{--            <button onclick="submit('list-items-4')">Submit</button>--}}
{{--        </div>--}}
{{--        <hr>--}}
{{--        <div class="list-5">--}}
{{--            <p>Enter the items in list 5</p>--}}
{{--            <textarea id="item-list-5"></textarea>--}}
{{--            <button onclick="enter('item-list-5','list-items-5')">Enter</button>--}}
{{--            <p id="list-items-5"></p>--}}
{{--            <button onclick="submit('list-items-5')">Submit</button>--}}
{{--        </div>--}}

            <input id="searchElement" type="text" placeholder="Type in the item">
            <button onclick="search()">Search</button>

            <div id="searchRender"></div>

            <div id="listItems"></div>
            <button id="final-submit" onclick="finalSubmit()">Confirm</button>
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
                    window.document.getElementById('searchRender').innerHTML = 'Enter an item to search';
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
                window.document.getElementById('searchRender').innerHTML += 'Name: ' + item.name + '<br>' +
                                                                            'Price: ' + item.price + '<br>' +
                                                                            'Use By: ' + item.use_by + '<br>'
                let button = window.document.createElement('BUTTON');
                button.setAttribute('id', item.id)
                button.setAttribute('value', item.name)
                button.innerHTML = 'Add Item'
                document.addEventListener('click', function (e) {
                    if (Number(e.target.id) === item.id) {
                        console.log(e.target.id, item.name)
                        window.document.getElementById('searchElement').value = ''
                        window.document.getElementById('listItems').innerHTML += item.name + '<br>'
                        historyItems.push(e.target.id)
                        window.document.getElementById('searchRender').innerHTML = ''
                        // alert('Item Added')
                    }
                })

                window.document.getElementById('searchRender').appendChild(button)
                window.document.getElementById('searchRender').innerHTML += '<hr>'
            }
        </script>

        <style>
            #final-submit {
                align-content: center;
                background-color: cornflowerblue;
            }
        </style>
    </body>
</html>
