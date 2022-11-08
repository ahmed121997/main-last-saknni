@php
$locale = app()->getLocale();
$margin = $locale === 'en' ? true : false;
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{$locale == 'en'? 'ltr':'rtl'}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="author" content="saknni"/>
    <meta name="description" content="Saknni services allow you to buy or sell a property while providing essential information to help you take one of life’s biggest financial decisions."/>
    <meta name=”robots” content="index, follow">

    <title>{{ config('app.name', 'Saknni') }}</title>

    <link rel="icon" href="{{asset('public/logo.jpg')}}"/>

    {{-- pre links --}}
    @yield('pre-links')

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}" defer></script>
    <script src="{{ asset('public/js/all.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{asset('public/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/all.css') }}" rel="stylesheet">
    @yield('links')
</head>
<body>
    <div id="app">

        @include('layouts.navbar')
        <main class="py-4">
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>

<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
<script src="https://js.pusher.com/6.0/pusher.min.js"></script>

@yield('script')

</body>
</html>
<!--lgofko kokgobknk k-->

