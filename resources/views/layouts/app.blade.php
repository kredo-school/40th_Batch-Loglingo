<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mansalva&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mansalva&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- JavaScript(toast notifications) --}}
    <script src="{{ asset('js/toast.js') }}" defer></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#EFEFEF]">
    <div class="min-h-screen flex flex-col bg-gray-100">
        @include('layouts.navigation')

        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <main>
            {{ $slot }}
        </main>

        {{-- copyright --}}
        <footer x-data="{ openTerms: false }" class="mt-auto py-3 bg-[#B178CC] text-white shadow-inner">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-sm font-medium tracking-wide">
                    Copyright &copy; {{ date('Y') }} Kredo Internship 40th Batch. All Rights Reserved.
                </p>

                <div class="mt-1">
                    <a href="#" @click.prevent="openTerms = true" class="text-xs text-purple-100 hover:text-white underline transition-colors">
                        Terms of Service
                    </a>
                </div>

                <div x-show="openTerms" x-cloak
                    class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-black bg-opacity-60 text-gray-800"
                    style="display: none;">

                    <div @click.away="openTerms = false" class="bg-white rounded-2xl shadow-xl max-w-2xl w-full flex flex-col overflow-hidden">
                        <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                            <h3 class="text-lg font-bold">Terms of Service</h3>
                            <button @click="openTerms = false" class="text-gray-400 hover:text-gray-600">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <div class="p-6 overflow-y-auto max-h-[70vh] text-left">
                            <x-terms-content />
                        </div>

                        <div class="px-6 py-4 border-t bg-gray-50 text-right">
                            <button @click="openTerms = false" class="bg-[#B178CC] text-white px-5 py-2 rounded-full text-sm font-bold">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    <div x-data="toastNotification()"
        style="display: none;"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-4"
        x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-5 right-5 z-[100] min-w-[200px]">

        <div class="bg-[#B178CC] text-white px-4 py-3 rounded-2xl shadow-2xl flex items-center gap-3 border border-gray-700">
            <template x-if="type === 'success'">
                <i class="fa-solid fa-circle-check text-white-400"></i>
            </template>
            <template x-if="type === 'error'">
                <i class="fa-solid fa-circle-exclamation text-red-400"></i>
            </template>
            <span x-text="message" class="text-sm font-medium"></span>
        </div>
    </div>


    {{-- Dispatch JS only when it gets php message --}}
    @if (session('error'))
    <script>
        window.addEventListener('load', () => {
            if (typeof dispatchToast === 'function') {
                dispatchToast("{{ session('error') }}", 'error');
            }
        });
    </script>
    @endif

    @if (session('success'))
    <script>
        window.addEventListener('load', () => {
            if (typeof dispatchToast === 'function') {
                dispatchToast("{{ session('success') }}", 'success');
            }
        });
    </script>
    @endif

</body>

</html>