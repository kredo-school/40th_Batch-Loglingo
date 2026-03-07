<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="min-h-screen flex items-center justify-center p-4 md:p-8 lg:p-12">
            <div class="container mx-auto max-w-6xl">

                <div class="flex flex-col md:flex-row items-center gap-12 lg:gap-20">

                    <div class="w-full md:w-1/2 flex justify-center">
                        <div class="relative w-full max-w-md rounded-[2rem] flex flex-col items-center text-center">
                            <div class="w-full mb-6 flex items-center justify-center">
                                <img src="{{ asset('/images/logo.png') }}" alt="LogLingo Logo">
                            </div>
                            <div class="space-y-4">
                                <p>This app is for language learners. You can log your day in the language you are studying, and interact with your friends and teachers! <br> Let's enjoy and practice together!!</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 max-w-md justify-center">
                        {{ $slot }}
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>