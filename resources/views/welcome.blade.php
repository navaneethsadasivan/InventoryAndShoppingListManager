<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Home</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .btn:focus {
                outline: none;
                box-shadow: none;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .top-left {
                position: absolute;
                left: 10px;
                top: 5px;
            }

            .header {
                background-color: #2a9055;
                width: 100%;
                padding: 10px;
                text-align: right;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .menu-icon {
                color: #ced4da;
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

            .side-nav-header {
                position: absolute;
                top: 5px;
                left: 23px;
                font-size: 36px;
                margin-right: 50px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            @media only screen and (max-width: 600px) {
                .title {
                    font-size: 40px;
                }

                .side-nav-header {
                    font-size: 12px;
                }

                .side-nav a {
                    font-size: 10px;
                }

                .links > a {
                    font-size: 10px;
                }
            }
        </style>
    </head>
    <body>
        @extends('layouts.app')

        <div id="sideNav" class="side-nav">
            <p class="side-nav-header">Home</p>
            <button class="btn closebtn" onclick="closeNavBar()"><i class="fas fa-times"></i></button>
            <a href="{{route('item')}}">Items<i class="fas fa-database p-2"></i></a>
            <a href="{{route('inventory')}}">Inventory<i class="fas fa-warehouse p-2"></i></a>
            <a href="{{route('shoppingList')}}">Shopping List<i class="fas fa-clipboard-check p-2"></i></a>
            <a href="{{route('generate')}}">Generate List [Beta]<i class="fas fa-laptop-code p-2"></i></a>
        </div>
        <div id="main-body">
            @if (Route::has('login'))
                <div class="links header">
                    <div class="top-left">
                        <button class="btn" onclick="openNavBar()"><i class="fas fa-bars fa-2x menu-icon"></i></button>
                    </div>
                    @auth
                        <a href="{{ url('/home') }}">Welcome {{\Illuminate\Support\Facades\Auth::user()->name}}</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content full-height flex-center">
                <div class="title m-b-md">
                    Shopping and Inventory Manager
                </div>
            </div>
        </div>

        <script>
            const width = window.matchMedia("(max-width: 600px)")

            function openNavBar() {
                $('#sideNav').css('width', "250px")
                $('#main-body').css('marginLeft', "250px")

                if (width.matches) {
                    $('#sideNav').css('width', "100px")
                    $('#main-body').css('marginLeft', "100px")
                }
            }

            function closeNavBar() {
                $('#sideNav').css('width', 0)
                $('#main-body').css('marginLeft', 0)
            }
        </script>
    </body>
</html>
