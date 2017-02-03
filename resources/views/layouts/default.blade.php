<!doctype html>
<html>
<head>
    @include('includes.head')
    <link rel="icon" href="{{ URL::asset('img/icon.png') }}">
    <link href='{{ URL::asset('css/main.css') }}' rel='stylesheet'>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    @yield('head')
</head>
<body>

<header>
    @include('includes.header')
</header>

<div id="main">

    @yield('content')

</div>

<footer>
    @include('includes.footer')
</footer>

</body>
</html>