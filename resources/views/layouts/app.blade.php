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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#EFEFEF]">
    <div class="min-h-screen">
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


        <footer class="mt-auto py-4 bg-[#B178CC] text-white shadow-inner">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-sm font-medium tracking-wide">
                    Copyright &copy; {{ date('Y') }} Kredo Internship 40th Batch. All Rights Reserved.
                </p>
            </div>
        </footer>

    </div>

    <div x-data="{ 
                show: false, 
                message: '',
                type: 'success',
                showToast(detail) {
                    this.message = typeof detail === 'string' ? detail : detail.message;
                    this.type = detail.type || 'success';
                    this.show = true;
                    setTimeout(() => { this.show = false }, 3000);
                }
            }"
        @toast.window="showToast($event.detail)"
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


    {{-- PHPからセッションメッセージがある場合、JavaScriptのイベントを発火させる --}}
    @if (session('error'))
    <script>
        // 100ミリ秒だけ待ってからイベントを発火させる
        setTimeout(() => {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: {
                    message: "{{ session('error') }}",
                    type: 'error'
                }
            }));
        }, 100);
    </script>
    @endif

    @if (session('success'))
    <script>
        setTimeout(() => {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: {
                    message: "{{ session('success') }}",
                    type: 'success'
                }
            }));
        }, 100);
    </script>
    @endif

</body>

</html>