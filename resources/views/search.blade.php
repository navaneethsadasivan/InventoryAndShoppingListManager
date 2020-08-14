<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <body>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @extends('layouts.app')

        @section('content')
            <navbar title="Search"></navbar>

            <input id="searchElement" type="text" placeholder="Type in the item">
            <button onclick="search()">Search</button>

            <div id="searchRender"></div>

            <div style="display: inline-block">
                <button onclick="createNewItem()" style="display: none" id="addItem">Add Item</button>
                <button onclick="min()" style="display: none" id="min">^</button>
            </div>
            <div style="display: none" id="newItem">
                <form>
                    <label for="name">Name:</label>
                    <input type="text" name="name"><br>
                    <label for="price">Price:</label>
                    <input type="text" name="price"><br>
                    <label for="use_by">Use By:</label>
                    <input type="text" name="useBy"><br>
                </form>
                <button onclick="submitNewItem()">Submit</button>
            </div>
        @endsection

        <script>
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
                        if (data['data'].length !== 0) {
                            data['data'].forEach(render)
                        } else {
                            window.document.getElementById('addItem').style.display = 'block'
                        }
                    }
                })
            }

            function render(item, index) {
                window.document.getElementById('searchRender').innerHTML += 'Name: ' + item.name + '<br>' + 'Price: ' + item.price + '<br>' + 'Expiry: ' + item.use_by + '<br><hr>'
                window.document.getElementById('addItem').style.display = 'block'
            }

            function createNewItem() {
                window.document.getElementById('newItem').style.display = 'block'
                window.document.getElementById('min').style.display = 'block'
            }

            function min() {
                window.document.getElementById('newItem').style.display = 'none'
                window.document.getElementById('min').style.display = 'none'
            }

            function submitNewItem() {
                let newItem = $('form').serializeArray()
                console.log(newItem)
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/postAddItem',
                    data: JSON.stringify(newItem),
                    success: function (data) {

                    }
                })
            }
        </script>
    </body>
</html>
