<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ config('app.name') }}</title>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css"  rel="stylesheet" />
    
        @stack('styles')
    </head>
    <body class="margin-bottom-30">
        @include('components.layouts.guest.navigation')
        {{ $slot }}
        
        @include('components.layouts.guest.footer')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
        @stack('scripts')
    </body>
</html>