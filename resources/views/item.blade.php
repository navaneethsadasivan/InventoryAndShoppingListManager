<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <body onload="getData()">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @extends('layouts.app')

        @section('content')
            <navbar title="Items"></navbar>
        @endsection


        <script>
            let itemList = null

            function getData() {
                $.ajax({
                    type: 'GET',
                    url: '/getItems',
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
                        $('.items').append('<item-card></item-card>')
                    })
                }
            }

            function show() {
                return itemList.length
            }
        </script>
    </body>
</html>
