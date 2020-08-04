<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <title>Color Saver</title>
    </head>
    <body>
        <div id="app">
            <colors></colors>
        </div>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>
