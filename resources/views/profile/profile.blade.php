<x-app-layout>
    <div class="py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">

            <!-- Left side (Main Content 2/3) -->
            <div class="w-full md:w-2/3">
                <div class="bg-white mb-4 p-6 pb-1 border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                                            
                    @if(Auth::check() && Auth::id() === $user->id)
                        <x-profile-auth-info 
                            :user="$user"
                            :year="$year"
                            :month="$month"
                            :daysInMonth="$daysInMonth"
                            :startDayOfWeek="$startDayOfWeek"
                            :activityData="$activityData"
                        />
                    @else
                        <x-profile-user-info 
                            :user="$user"
                            :year="$year"
                            :month="$month"
                            :daysInMonth="$daysInMonth"
                            :startDayOfWeek="$startDayOfWeek"
                            :activityData="$activityData"
                        />
                    @endif
                                                
                    <!-- Tab -->
                    <x-profile-tabs :user="$user" />

                </div> <!-- profile end -->
                
                <div>
                @if(request()->routeIs('profile.show'))
                    <x-profile-show-posts :posts="$posts" />
                @elseif(request()->routeIs('profile.questions'))
                    <x-profile-show-questions :questions="$questions" />
                @elseif(request()->routeIs('profile.discussions'))
                    <x-profile-show-discussions :discussions="$discussions" />
                @elseif(request()->routeIs('profile.following'))
                    <x-profile-show-following :followings="$followings" :count="$user->followings_count"/>
                @elseif(request()->routeIs('profile.followers'))
                    <x-profile-show-followers :user="$user" :followers="$followers" :count="$user->followers_count"/>
                @elseif(request()->routeIs('profile.bookmarks'))
                    <x-profile-show-bookmarks :bookmarks="$bookmarks" />
                @elseif(request()->routeIs('profile.notifications'))
                    <x-profile-show-notifications :notifications="$notifications" />
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





