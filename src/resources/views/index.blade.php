<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Graffiti Wall</title>

        <!-- Compiled Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>

        <!-- VueJS App -->
        <div id="app">
            <home-page></home-page>
        </div>
        
        <!-- Compiled JS -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>
