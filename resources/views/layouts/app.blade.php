<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('extra-css')
</head>
<body>
<div id="navigation">
    <nav class="navbar">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <div class="navbar-burger burger" :class="{'is-active' : open}" @click="toggleNav" data-target="navMenu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <a href="{{ route('cart') }}" class="navbar-item is-hidden-desktop"><b-icon icon="cart"></b-icon> <span class="badge" v-if="cartQty" v-text="cartQty"></span></a>
        </div>
        <div id="navMenu" class="navbar-menu" :class="{'is-active': open}">
            @if (Auth::guest())
            @else
                <div class="navbar-start">
                    @if(Auth::user()->role === "ADMIN")
                        <a href="/admin/categories" class="navbar-item">Categories</a>
                        <a href="/admin/users" class="navbar-item">Users</a>
                    @else
                        <a href="/home" class="navbar-item">Items</a>
                    @endif
                </div>
        @endif
        <!-- Authentication Links -->
            <div class="navbar-end">
                <a href="{{ route('cart') }}" class="navbar-item"><b-icon icon="cart"></b-icon> Cart <span class="badge" v-if="cartQty" v-text="cartQty"></span></a>
                @if (Auth::guest())
                    <a class="navbar-item" href="{{ route('login') }}">Login</a>
                    <a class="navbar-item" href="{{ route('register') }}">Register</a>
                @else
                    <div class="navbar-item is-hoverable has-dropdown">
                        <a href="#" class="navbar-link is-active">{{ Auth::user()->name }}</a>
                        <div class="navbar-dropdown" role="menu">
                            <a class="navbar-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </nav>
</div>
@yield('content')
@yield('extra-js')
</body>
</html>
