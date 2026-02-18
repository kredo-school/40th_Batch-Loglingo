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
                    <x-profile-tabs :user="$user" />

                </div> <!-- profile end -->
                
                <div>
                @if(request()->routeIs('profile.show'))
                    <x-profile-show-posts :posts="$posts" />
                @elseif(request()->routeIs('profile.questions'))
                    <x-profile-show-questions :questions="$questions" />
                @elseif(request()->routeIs('profile.following'))
                    <x-profile-show-following :followings="$followings"/>
                @elseif(request()->routeIs('profile.followers'))
                    <x-profile-show-followers :user="$user" :followers="$followers"/>
                @endif
                </div>


            </div>


            <!-- Right side (Sidebar 1/3) -->
            <div class="w-full md:w-1/3 space-y-6">

                <x-profile-post-log-button />
            
                <x-suggested-users />
            
            </div>

        </div>
    </div>
</x-app-layout>





