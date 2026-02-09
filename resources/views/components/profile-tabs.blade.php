<!-- Tab -->

{{-- NEED TO REPLACE  --> check if out put is same as below--}}


{{-- @props(['user'])

<div class="mt-4 flex w-full gap-x-2 overflow-x-auto lg:overflow-x-visible no-scrollbar">  

    <a href="{{ route('profile.posts', $user) }}"
    class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl relative
    {{ request()->routeIs('profile.posts') 
            ? 'text-gray-900 font-semibold' 
            : 'text-gray-500 hover:text-gray-900 hover:font-semibold transition-all duration-200' }}">

        posts

        @if(request()->routeIs('profile.posts'))
            <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500 rounded-full"></div>
        @endif
    </a>

    <a href="{{ route('profile.questions', $user) }}"
    class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl relative
    {{ request()->routeIs('profile.questions') 
            ? 'text-gray-900 font-semibold' 
            : 'text-gray-500 hover:text-gray-900 hover:font-semibold transition-all duration-200' }}">

        questions

        @if(request()->routeIs('profile.questions'))
            <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500 rounded-full"></div>
        @endif
    </a>

    <a href="{{ route('profile.following', $user) }}"
    class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl relative
    {{ request()->routeIs('profile.following') 
            ? 'text-gray-900 font-semibold' 
            : 'text-gray-500 hover:text-gray-900 hover:font-semibold transition-all duration-200' }}">

        following

        @if(request()->routeIs('profile.following'))
            <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500 rounded-full"></div>
        @endif
    </a>

    <a href="{{ route('profile.followers', $user) }}"
    class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl relative
    {{ request()->routeIs('profile.followers') 
            ? 'text-gray-900 font-semibold' 
            : 'text-gray-500 hover:text-gray-900 hover:font-semibold transition-all duration-200' }}">

        followers

        @if(request()->routeIs('profile.followers'))
            <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500 rounded-full"></div>
        @endif
    </a>

    <a href="{{ route('profile.bookmarks', $user) }}"
    class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl relative
    {{ request()->routeIs('profile.bookmarks') 
            ? 'text-gray-900 font-semibold' 
            : 'text-gray-500 hover:text-gray-900 hover:font-semibold transition-all duration-200' }}">

        bookmarks

        @if(request()->routeIs('profile.bookmarks'))
            <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500 rounded-full"></div>
        @endif
    </a>

    <a href="{{ route('profile.notifications', $user) }}"
    class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl relative
    {{ request()->routeIs('profile.notifications') 
            ? 'text-gray-900 font-semibold' 
            : 'text-gray-500 hover:text-gray-900 hover:font-semibold transition-all duration-200' }}">

        notifications

        @if(request()->routeIs('profile.notifications'))
            <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500 rounded-full"></div>
        @endif
    </a>

    

</div> --}}

<div class="mt-4 flex w-full gap-x-2 overflow-x-auto lg:overflow-x-visible no-scrollbar">   
    <!-- 1. Posts  -->
    <a href="#" 
    class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl relative text-gray-900 font-semibold">
        posts
        <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500 rounded-full"></div>
    </a>

    <!-- 2. Questions -->
    <a href="#" 
    class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl text-gray-500 font-semibold hover:text-gray-900 hover:font-semibold transition-all duration-200">
        questions
    </a>

    <!-- 3. Following  -->
    <a href="#" 
    class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl text-gray-500 font-semibold hover:text-gray-900 hover:font-semibold transition-all duration-200">
        following
    </a>

    <!-- 4. Followers -->
    <a href="#" class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl text-gray-500 font-semibold hover:text-gray-900 hover:font-semibold transition-all duration-200">
        followers
    </a>

    <!-- 5. Bookmarks -->
    <a href="#" class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl text-gray-500 font-semibold hover:text-gray-900 hover:font-semibold transition-all duration-200">
        bookmarks
    </a>

    <!-- 6. Notifications -->
    <a href="#" class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl text-gray-500 font-semibold hover:text-gray-900 hover:font-semibold transition-all duration-200">
        notifications
    </a>
</div>
