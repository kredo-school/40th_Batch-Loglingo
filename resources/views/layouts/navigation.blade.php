<nav x-data="{ open: false }" class="bg-[#B178CC] p-3 shadow-lg rounded-[1rem] mx-4 mt-2">
    <div class="max-w-full mx-auto flex justify-between items-center">

        <a href="{{ route('posts.index')}}" class="flex items-center space-x-2 min-w-0">
            <img src="{{ asset('images/Logo.png') }}" alt="LogLingo Logo" class="h-10 md:h-12 w-auto rounded-[0.5rem] me-2 shrink-0">
            <span class="text-white text-2xl md:text-3xl font-mansalva leading-none">Log Lingo</span>
        </a>

        {{-- PC menu --}}
        <div class="hidden md:flex items-center space-x-8 text-white font-bold">
            <a href="{{ route('posts.index') }}"
                class="{{ request()->routeIs('posts.*') ? 'text-gray-800' : 'hover:text-gray-800' }} text-xl lg:text-[27px]">
                Post
            </a>

            <a href="{{ route('questions.index') }}"
                class="{{ request()->routeIs('questions.*') ? 'text-gray-800' : 'hover:text-gray-800' }} text-xl lg:text-[27px]">
                Q&A
            </a>

            <a href="{{ route('search') }}"
                class="{{ request()->routeIs('search') ? 'text-gray-800' : 'hover:text-gray-800' }} text-xl lg:text-[27px]">
                Search
            </a>

            @if(Auth::user()->role_id == 3 || Auth::user()->role_id == 1)
            <a href="{{ route('discussions.index') }}"
                class="{{ request()->routeIs('discussions.*') ? 'text-gray-800' : 'hover:text-gray-800' }} text-xl lg:text-[27px]">
                Discussion
            </a>
            @endif
        </div>

        {{-- Right icons --}}
        <div class="flex items-center space-x-3 md:space-x-5 text-2xl md:text-[30px] shrink-0">
            <a href="{{ route('posts.index')}}" class="hidden md:inline text-white hover:text-gray-800">
                <i class="fa-solid fa-house"></i>
            </a>

            @php
              $unreadCount = auth()->user()->unreadNotifications()->count();
            @endphp

            <a href="{{ route('profile.notifications', auth()->id()) }}" class="relative text-white hover:text-gray-800">
                <i class="fa-regular fa-bell"></i>
                @if($unreadCount > 0)
                    <span class="absolute -bottom-0.5 -right-3 w-5 h-5 bg-red-500 text-white text-[12px] font-bold rounded-full flex items-center justify-center">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center transition duration-150 ease-in-out">
                        <div class="w-10 h-10 md:w-11 md:h-11 rounded-full border-2 border-white/30 overflow-hidden shadow-sm hover:opacity-80 bg-white flex items-center justify-center">
                            @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                            @else
                            <i class="fa-solid fa-circle-user text-gray-400 text-[40px] md:text-[45px]"></i>
                            @endif
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    @if(Auth::user()->isAdmin())
                    <x-dropdown-link :href="route('admin.users.index')">
                        {{ __('Admin') }}
                    </x-dropdown-link>
                    @endif

                    <x-dropdown-link :href="route('profile.show', Auth::id())">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>

            {{-- Mobile menu button --}}
            <button @click="open = !open" class="md:hidden text-white hover:text-gray-800">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-cloak class="md:hidden mt-4 pt-4 border-t border-white/20 space-y-3">
        <a href="{{ route('posts.index') }}"
            class="block text-white font-bold text-lg {{ request()->routeIs('posts.*') ? 'text-gray-800' : 'hover:text-gray-800' }}">
            Post
        </a>

        <a href="{{ route('questions.index') }}"
            class="block text-white font-bold text-lg {{ request()->routeIs('questions.*') ? 'text-gray-800' : 'hover:text-gray-800' }}">
            Q&A
        </a>

        <a href="{{ route('search') }}"
            class="block text-white font-bold text-lg {{ request()->routeIs('search') ? 'text-gray-800' : 'hover:text-gray-800' }}">
            Search
        </a>

        @if(Auth::user()->role_id == 3 || Auth::user()->role_id == 1)
        <a href="{{ route('discussions.index') }}"
            class="block text-white font-bold text-lg {{ request()->routeIs('discussions.*') ? 'text-gray-800' : 'hover:text-gray-800' }}">
            Discussion
        </a>
        @endif

        <a href="{{ route('posts.index')}}" class="block text-white font-bold text-lg hover:text-gray-800">
            Home
        </a>
    </div>
</nav>