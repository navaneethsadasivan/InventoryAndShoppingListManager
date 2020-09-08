<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <style>
            .side-nav {
                height: 100%;
                width: 0;
                background-color: #2a9055;
                position: fixed;
                top: 0;
                left: 0;
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
        </style>
    </head>
    <body>
        @extends('layouts.app')

        @section('content')
        <div class="side-nav">
            <a href="{{route('welcome')}}">Home</a>
            <a href="{{route('item')}}">Items</a>
            <a href="{{route('inventory')}}">Inventory</a>
            <a href="{{route('shoppingList')}}">Shopping List</a>
            <a href="{{route('generate')}}">Generate List [Beta]</a>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{ __('You are logged in!') }}
                        </div>

                        <button onclick="logout()" class="btn btn-primary">
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endsection

        <script>
            function logout() {
                $.ajax({
                    type: 'GET',
                    url: '/logout'
                })
            }
        </script>
    </body>
</html>
