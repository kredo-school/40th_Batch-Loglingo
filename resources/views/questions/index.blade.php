<x-app-layout>
    <div class="py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">

            <!-- Left side -->
            <div class="w-full md:w-2/3">

                <div class="flex justify-between items-end mb-4">
                    <h2 class="text-2xl text-gray-800 font-bold">Latest Q&As</h2>
                    <a href="#" class="text-sm text-black hover:underline">see more</a> {{--★need to create a link to show more posts --}}
                </div>

                <!-- Question example-->
                 replace this with Question card component
                <x-post-card />
            </div>

            <!-- right side -->
            <div class="w-full md:w-1/3 space-y-6">

                <!-- user profile on the right side using blade -->
                <x-sidebar-profile />  replace this with ask a question component

                <!-- suggested users using blade -->
                <x-suggested-users />

            </div>

        </div>
    </div>
</x-app-layout>