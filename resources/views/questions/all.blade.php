<x-app-layout>
    <div class="py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">

            <!-- Left side -->
            <div class="w-full md:w-2/3">

                <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 mb-3">
                    <div class="flex justify-between items-end m-4">
                        <h2 class="text-[24px] font-bold">
                            @if(request()->filled('languages'))
                            All Q&As in selected languages
                            @else
                            All Q&As
                            @endif
                        </h2>
                        <a href="{{ route('questions.index') }}" class="text-sm text-black hover:underline">see latest</a>
                    </div>
                </div>

                <!-- Language filter -->
                <x-language-filter :languages="$languages" :action="route('questions.all')" />


                <!-- Question example-->
                @forelse($questions as $question)
                <x-question-card :question="$question" />
                <div class="mb-4"></div>

                @empty
                <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-50 rounded-full mb-4">
                        <i class="fa-solid fa-magnifying-glass text-3xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 text-lg font-medium">No questions found.</p>
                    <p class="text-gray-400 mt-1">Try adjusting your filter.</p>

                    @if(request()->has('languages'))
                    <a href="{{ route('questions.all') }}" class="inline-block mt-4 text-[#56A5E1] hover:underline text-sm">
                        Clear all filters
                    </a>
                    @endif
                </div>

                @endforelse

                <div class="mt-8 px-4">
                    {{ $questions->appends(request()->query())->links() }}
                </div>


            </div>

            <!-- right side -->
            <div class="w-full md:w-1/3 space-y-6">

                <!-- user profile on the right side using blade -->
                <x-sidebar-profile-for-questions />

                <!-- suggested users using blade -->
                <x-suggested-users />

            </div>

        </div>
    </div>
</x-app-layout>