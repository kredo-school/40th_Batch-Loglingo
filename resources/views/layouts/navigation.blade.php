<nav class="bg-[#B178CC] p-3 shadow-lg rounded-[1rem] mx-4 mt-2">
    <div class="max-w-full mx-auto flex justify-between items-center">

        <a href="{{ route('dashboard')}}" class="flex items-center space-x-2">
            <img src="{{ asset('images/Logo.png') }}" alt="LogLingo Logo" class="h-12 w-auto rounded-[0.5rem] me-2">
            <span class="text-white  text-3xl font-mansalva">Log Lingo</span>
        </a>

        <div class="hidden sm:flex space-x-12 text-white font-bold">
            {{-- Post --}}
            <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.index') ? 'text-gray-800' : 'hover:text-gray-800' }} text-[27px]">Post</a>

            {{-- Q&A --}}
            <a href="{{ route('questions.index') }}"
                class="{{ request()->routeIs('questions.index') ? 'text-gray-800' : 'hover:text-gray-800' }} text-[27px]">
                Q&A
            </a>

            {{-- Search --}}
            <a href="{{ route('search') }}"
                class="{{ request()->routeIs('search') ? 'text-gray-800' : 'hover:text-gray-800' }} text-[27px]">
                Search
            </a>

            <a href="{{ route('discussions.index') }}"
                class="{{ request()->routeIs('discussions.index') ? 'text-gray-800' : 'hover:text-gray-800' }} text-[27px]">
                Discussion
            </a>
        </div>

        <div class="flex items-center space-x-5 text-[30px]">
            <a href="{{ route('dashboard')}}" class="text-white hover:text-gray-800"><i class="fa-solid fa-house"></i></a>
            <a href="{{ route('dashboard')}}" class="text-white hover:text-gray-800"><i class="fa-regular fa-bell"></i></a> {{--★need to adjust the route --}}

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center transition duration-150 ease-in-out">
                        <div class="w-11 h-11 rounded-full bg-yellow-400 overflow-hidden shadow-sm hover:opacity-80">
                            <img src="#" alt="user" class="w-full h-full object-cover">
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    {{-- ★need to adjust @if(Auth::user()->is_admin)  --}}
                    <x-dropdown-link :href="route('dashboard')"> {{-- ★need to adjust the route --}}
                        {{ __('Admin') }}
                    </x-dropdown-link>
                    {{-- ★need to adjust @endif  --}}

                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                    this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>

        </div>

    </div>
</nav>