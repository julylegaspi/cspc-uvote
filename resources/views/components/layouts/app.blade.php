<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ config('app.name') }}</title>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css"  rel="stylesheet" />

        <link rel="stylesheet" href="https://flowbite-admin-dashboard.vercel.app//app.css">
    
        @stack('styles')
    </head>
    <body class="bg-gray-50 dark:bg-gray-800">
        @include('components.layouts.navigation')

        <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
    
            @include('components.layouts.aside')
    
            <div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>
    
            <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
                <main>
                    <div class="px-4 pt-6">
                        <div class="mb-4 col-span-full xl:mb-2">
                            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{ ucfirst(request()->segment(1)) }}</h1>
                        </div>
                        {{ $slot }}
                    <div>
                </main>
                
                @include('components.layouts.footer')
    
            </div>
    
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <script src="https://flowbite-admin-dashboard.vercel.app//app.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.2/datepicker.min.js"></script>
        @stack('scripts')
    </body>
</html>
