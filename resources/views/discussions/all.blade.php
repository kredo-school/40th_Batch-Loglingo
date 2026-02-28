<x-app-layout>
    <div class="py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">

            <!-- Left side -->
            <div class="w-full md:w-2/3">

                <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 mb-3">
                    <div class="flex justify-between items-end m-4">
                        <h2 class="text-[24px] font-bold">Latest Discussions</h2>
                        <a href="{{ route('discussions.index') }}" class="text-sm text-black hover:underline">see latest</a>
                    </div>
                </div>

                <!-- language filter -->
                <x-language-filter
                    :languages="$languages"
                    :action="route('discussions.all')"
                    label="(Language discussed)" />

                <div class="space-y-4">
                    @forelse($discussions as $discussion)
                    <x-discussion-card :discussion="$discussion" />
                    @empty
                    <div class="bg-white rounded-[1rem] p-10 text-center border border-dashed">
                        <p class="text-gray-400">No discussions yet.</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $discussions->links() }}
                </div>

            </div>

            <!-- right side -->
            <div class="w-full md:w-1/3 space-y-6">

                <!-- user profile on the right side using blade -->
                <x-sidebar-profile-teacher-for-discussions />

                <!-- suggested users using blade -->
                <x-suggested-users />

            </div>

        </div>
    </div>
</x-app-layout>