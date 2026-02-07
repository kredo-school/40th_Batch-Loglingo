<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">

            <!-- Left side (Main Content 2/3) -->
            <div class="w-full md:w-2/3">
                <div class="bg-white mb-4 p-6 pb-1 border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                                            
                    @if(Auth::check() && Auth::id() === $user->id)
                        <x-profile-auth-info :user="$user" />
                    @else
                        <x-profile-user-info :user="$user" />
                    @endif
                                                
                        <!-- Tab -->
                            <div class="mt-4 flex w-full gap-x-2 overflow-x-auto lg:overflow-x-visible no-scrollbar">                               

                            {{-- REPLACEMENT for all each tabs -> make route name --}}

                                {{-- <a href="{{ route('profile.posts', $user->id) }}" class="flex-1 text-center pb-4 px-2 min-w-fit text-lg md:text-xl relative {{ request()->routeIs('profile.posts') ? 'text-gray-900 font-semibold' : 'text-gray-500 hover:text-gray-900 hover:font-semibold transition-all duration-200' }}">
                                    posts
                                    @if(request()->routeIs('profile.posts'))
                                        <x-profile-show-post :posts="$posts" />
                                    @endif
                                </a> --}}


                                {{-- NEED TO REPLACE  --}}
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

                    </div> <!-- headder end -->

                </div> <!-- profile end -->

                <!-- show  -->                
                <x-profile-show-posts />

            </div>


            <!-- Right side (Sidebar 1/3) -->
            <div class="w-full md:w-1/3 space-y-6">

                <x-profile-post-log-button />
            
                <x-suggested-users />
            
            </div>

        </div>
    </div>
</x-app-layout>