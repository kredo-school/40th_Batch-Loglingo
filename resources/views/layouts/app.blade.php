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

    {{-- JavaScript(Modal quoted question on discussion page) --}}
    <script src="{{ asset('js/discussion.js') }}" defer></script>

    {{-- JavaScript(comment) --}}
    <script src="{{ asset('js/comment.js') }}" defer></script>

    {{-- Google Maps API --}}
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}"></script>
    {{-- JavaScript(map) --}}
    <script src="{{ asset('js/map.js') }}" defer></script>

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
        <footer x-data="{ openTerms: false, openContact: false }" class="mt-auto py-3 bg-[#B178CC] text-white shadow-inner">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-sm font-medium tracking-wide">
                    Copyright &copy; {{ date('Y') }} Kredo Internship 40th Batch. All Rights Reserved.
                </p>

                <div class="mt-1 flex items-center justify-center gap-3">
                    <a href="#" @click.prevent="openTerms = true" class="text-xs text-purple-100 hover:text-white underline transition-colors">
                        Terms of Service
                    </a>

                    <span class="text-purple-200 text-xs text-opacity-50">|</span>

                    {{-- call JS function--}}
                    <a href="#" @click.prevent="openContact = true; $nextTick(() => initContactMap())" class="text-xs text-purple-100 hover:text-white underline transition-colors">
                        Contact Us
                    </a>

                </div>

                {{-- Terms Modal --}}
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

                {{-- Contact Modal --}}
                <div x-show="openContact" x-cloak
                    class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-black bg-opacity-60 text-gray-800"
                    style="display: none;">

                    <div @click.away="openContact = false" class="bg-white rounded-2xl shadow-xl max-w-2xl w-full flex flex-col overflow-hidden">
                        <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                            <h3 class="text-lg font-bold text-[#B178CC]">Contact Us</h3>
                            <button @click="openContact = false" class="text-gray-400 hover:text-gray-600">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <div class="p-6 text-left">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                                <div class="space-y-4 text-sm">
                                    <div>
                                        <h4 class="font-bold text-gray-700">Location</h4>
                                        <p class="text-gray-600">Roppongi Hills Mori Tower,<br>Tokyo, Japan</p>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-700">Email</h4>
                                        <p class="text-gray-600">support@loglingo.test</p>
                                    </div>
                                </div>
                                {{-- show map --}}
                                <div id="modal-map" class="w-full h-48 bg-gray-100 rounded-xl border border-gray-200"></div>
                            </div>
                        </div>

                        <div class="px-6 py-4 border-t bg-gray-50 text-right">
                            <button @click="openContact = false" class="bg-[#B178CC] text-white px-5 py-2 rounded-full text-sm font-bold shadow-md hover:bg-[#a066b8]">
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
        x-transition:enter-start="opacity-0 transform translate-x-8"
        x-transition:enter-end="opacity-100 transform translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-x-0"
        x-transition:leave-end="opacity-0 transform translate-x-8"
        class="fixed top-8 right-8 z-[9999] w-full max-w-[320px] pointer-events-none">

        <div class="bg-white border-l-4 p-4 shadow-[0_15px_40px_rgba(0,0,0,0.2)] pointer-events-auto flex items-center gap-4"
            :class="{
                'border-[#B178CC]': type === 'success',
                'border-red-500': type === 'error'
             }">

            <div class="flex-shrink-0 text-lg">
                <template x-if="type === 'success'">
                    <i class="fa-solid fa-circle-check text-[#B178CC]"></i>
                </template>
                <template x-if="type === 'error'">
                    <i class="fa-solid fa-circle-exclamation text-red-400"></i>
                </template>
            </div>

            <div class="flex-1">
                <span x-text="message" class="text-sm font-bold text-gray-700"></span>
            </div>

            <button @click="show = false" class="text-gray-300 hover:text-gray-500 transition-colors">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>

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

    
    {{-- receive custom event from JavaScript(AJAX) --}}
    <script>
        window.addEventListener('notify', (event) => {
            if (typeof dispatchToast === 'function') {
                const message = typeof event.detail === 'string' ? event.detail : event.detail.message;
                const type = event.detail.type || 'success';
                dispatchToast(message, type);
            }
        });
    </script>

</body>

</html>