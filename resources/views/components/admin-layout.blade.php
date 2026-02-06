<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Loglingo', 'Admin') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mansalva&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mansalva&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        [x-cloak] { display: none !important; }
    </style>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased">

    @include('layouts.navigation')

    <div class="flex pt-4 h-auto overflow-hidden">
        {{-- left side bar --}}
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col m-4 rounded-[1rem] shadow-sm">

            {{-- Admin Profile Section --}}
            <div class="p-6 border-b border-gray-100 flex items-center space-x-3">
                <i class="fa-solid fa-gear text-[22px] bg-white p-1 rounded-full shadow-sm text-gray-500"></i>
                <span class="font-bold text-gray-700 text-lg">Admin</span>
            </div>

            {{-- Navigation Menu --}}
            <nav class="flex-1 p-1 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.users.index') }}"
                    class="flex justify-between items- px-4 py-3 rounded-lg font-bold transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-gray-50 text-gray-900 border-r-4 border-blue-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    users
                </a>

                <a href="{{ route('admin.teachers.index') }}"
                    class="flex justify-between items-center px-4 py-3 rounded-lg font-bold transition-colors {{ request()->routeIs('admin.teachers.*') ? 'bg-gray-50 text-gray-900 border-r-4 border-blue-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    teachers
                </a>

                <a href="{{ route('admin.posts.index') }}"
                    class="flex justify-between items-center px-4 py-3 rounded-lg font-bold transition-colors {{ request()->routeIs('admin.posts.*') ? 'bg-gray-50 text-gray-900 border-r-4 border-blue-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    posts
                </a>

                <a href="{{ route('admin.qna.index') }}"
                    class="flex justify-between items-center px-4 py-3 rounded-lg font-bold transition-colors {{ request()->routeIs('admin.qna.*') ? 'bg-gray-50 text-gray-900 border-r-4 border-blue-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    Q&As
                </a>

                <a href="{{ route('admin.tags.index') }}"
                    class="flex justify-between items-center px-4 py-3 rounded-lg font-bold transition-colors {{ request()->routeIs('admin.tags.*') ? 'bg-gray-50 text-gray-900 border-r-4 border-blue-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    tags
                </a>

                <a href="{{ route('admin.discussions.index') }}"
                    class="flex justify-between items-center px-4 py-3 rounded-lg font-bold transition-colors {{ request()->routeIs('admin.discussions.*') ? 'bg-gray-50 text-gray-900 border-r-4 border-blue-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    discussions
                </a>


            </nav>
        </aside>

        {{-- right side(content) --}}
        <main class="flex-1 overflow-y-auto p-4">
            {{ $slot }}
        </main>
    </div>
</body>

</html>