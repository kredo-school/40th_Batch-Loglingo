{{-- TODO: set route for bookmark and notification --}}

@props(['user'])

<div class="mt-4 flex w-full gap-x-2 overflow-x-auto lg:overflow-x-visible no-scrollbar">  

    <a href="{{ route('profile.show', $user) }}"
    class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl relative
    {{ request()->routeIs('profile.show') 
            ? 'text-gray-900 font-semibold' 
            : 'text-gray-500 hover:text-gray-900 transition-all duration-200' }}">

        posts

        @if(request()->routeIs('profile.show'))
            <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500 rounded-full"></div>
        @endif
    </a>

    <a href="{{ route('profile.questions', $user) }}"
    class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl relative
    {{ request()->routeIs('profile.questions') 
            ? 'text-gray-900 font-semibold' 
            : 'text-gray-500 hover:text-gray-900 transition-all duration-200' }}">

        questions

        @if(request()->routeIs('profile.questions'))
            <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500 rounded-full"></div>
        @endif
    </a>

    <a href="{{ route('profile.following', $user) }}"
    class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl relative
    {{ request()->routeIs('profile.following') 
            ? 'text-gray-900 font-semibold' 
            : 'text-gray-500 hover:text-gray-900 transition-all duration-200' }}">

        following

        @if(request()->routeIs('profile.following'))
            <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500 rounded-full"></div>
        @endif
    </a>

    <a href="{{ route('profile.followers', $user) }}"
    class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl relative
    {{ request()->routeIs('profile.followers') 
            ? 'text-gray-900 font-semibold' 
            : 'text-gray-500 hover:text-gray-900 transition-all duration-200' }}">

        followers

        @if(request()->routeIs('profile.followers'))
            <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500 rounded-full"></div>
        @endif
    </a>

    <a href="#"
    {{-- {{ route('profile.bookmarks', $user) }} --}}
    class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl relative
    {{ request()->routeIs('profile.bookmarks') 
            ? 'text-gray-900 font-semibold' 
            : 'text-gray-500 hover:text-gray-900 transition-all duration-200' }}">

        bookmarks

        @if(request()->routeIs('profile.bookmarks'))
            <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500 rounded-full"></div>
        @endif
    </a>

    <a href="#"
    {{-- {{ route('profile.notifications', $user) }} --}}
    class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl relative
    {{ request()->routeIs('profile.notifications') 
            ? 'text-gray-900 font-semibold' 
            : 'text-gray-500 hover:text-gray-900 transition-all duration-200' }}">

        notifications

        @if(request()->routeIs('profile.notifications'))
            <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500 rounded-full"></div>
        @endif
    </a>

    

</div>

