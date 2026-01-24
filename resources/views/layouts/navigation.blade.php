<nav class="bg-[#B178CC] p-3 shadow-lg rounded-[1rem] mx-4 mt-2">
    <div class="max-w-full mx-auto flex justify-between items-center">

        <div class="flex items-center space-x-2">
            {{-- ★put logo here --}}
            <span class="text-white  text-3xl font-mansalva">Log Lingo</span>
        </div>

        <div class="hidden sm:flex space-x-12 text-white font-bold">
            <a href="#" class="hover:text-gray-800 text-[27px]">Post</a>
            <a href="#" class="hover:text-gray-800 text-[27px]">Q&A</a>
            <a href="#" class="hover:text-gray-800 text-[27px]">Search</a>
            <a href="#" class="hover:text-gray-800 text-[27px]">Discussion</a>
        </div>

        <div class="flex items-center space-x-5 text-[30px]">
            <button class="text-white hover:text-gray-800"><i class="fa-solid fa-house"></i></button>
            <button class="text-white hover:text-gray-800"><i class="fa-regular fa-bell"></i></button>

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center transition duration-150 ease-in-out">
                        <div class="w-11 h-11 rounded-full bg-yellow-400 overflow-hidden shadow-sm hover:opacity-80">
                            <img src="https://via.placeholder.com/150" alt="user" class="w-full h-full object-cover">
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    @if(Auth::user()->is_admin) {{-- ★need to adjust --}}
                    <x-dropdown-link :href="route('dashboard')"> {{-- ★need to adjust the route --}}
                        {{ __('Admin') }}
                    </x-dropdown-link>
                    @endif

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