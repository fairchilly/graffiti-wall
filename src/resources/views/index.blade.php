<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Graffiti Wall</title>

        <!-- Compiled Styles -->
        <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>

        <!-- VueJS App -->
        <div id="app">
            <master-layout></master-layout>
        </div>
        
        <!-- Compiled JS -->
        <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        
    </body>
</html>
