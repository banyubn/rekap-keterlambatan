<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rekap Keterlambatan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap');

        body {
            font-family: 'Source Sans 3', sans-serif;
        }
    </style>
    @vite('resources/js/app.js')
</head>

<body>
    <div id="app">
        @yield('content')
    </div>

    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
    @stack('script')
</body>

</html>
