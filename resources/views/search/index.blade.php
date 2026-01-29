<x-app-layout>
    <div class="py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">

            <!-- Left side -->
            <div class="w-full md:w-2/3">

                <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 mb-3">
                    <div class="flex justify-between items-end m-4">
                        <h2 class="text-[24px] font-bold">Latest posts</h2>
                        <a href="{{ route('posts.index') }}" class="text-sm text-black hover:underline">see more</a> {{--★need to adjust the route --}}
                    </div>
                </div>

                <!-- Language filter -->
                <x-language-filter :action="route('search')" /> {{--★need to adjust the route --}}

                <!-- Post example-->
                <x-post-card />

            </div>

            <!-- right side -->
            <div class="w-full md:w-1/3 space-y-6">

                <!-- user profile on the right side using blade -->
                <x-sidebar-profile />

                <!-- suggested users using blade -->
                <x-suggested-users />

            </div>

        </div>
    </div>
</x-app-layout>