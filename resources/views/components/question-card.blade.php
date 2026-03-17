@props(['question'])

<div class="space-y-4">

    <div class="relative bg-white rounded-[1rem] shadow-sm border border-gray-100 p-5 flex items-start space-x-4 transition-all hover:border-gray-200">

        {{-- user icon --}}
        <div class="flex-shrink-0">
            <div class="w-16 h-16 rounded-full overflow-hidden">

                @if($question->user->avatar)
                <img src="{{ $question->user->avatar }}" alt="user" class="w-full h-full object-cover">
                @else
                <i class="fa-solid fa-circle-user text-gray-400 text-[4rem] leading-none"></i>
                @endif

            </div>
        </div>

        {{-- content --}}
        <div class="flex-1 min-w-0">
            <div class="flex justify-between items-start mb-2">
                <a href="{{ route('profile.show',$question->user->id) }} " class="group">
                    <h3 class="font-bold text-gray-700 group-hover:text-[#B178CC] transition-colors truncate max-w-full break-words">{{ $question->user->name }}</h3>
                </a>
            </div>

            @if($question->answers->count() > 0)
            <x-answered-badge class="absolute top-4 right-4" />
            @endif

            {{-- tytle&body  --}}
            <a href="{{ route('questions.show', $question->id) }}" class="group block mt-1">
                {{-- title --}}
                <h4 class="text-xl font-extrabold text-gray-900 leading-tight mb-1 group-hover:underline decoration-gray-400 break-words">
                    {{ $question->q_title }}
                </h4>
                {{-- body --}}
                <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed break-words whitespace-pre-wrap">{{ $question->q_content }}</p>
            </a>

            {{-- bookmark&tag&report --}}
            <div class="flex justify-between items-center mt-4 pt-3 border-t border-gray-50">

                {{-- created at --}}
                <p class="text-[12px] text-gray-400">{{ $question->created_at->diffForHumans() }}</p>


                <div class="flex items-center space-x-3">
                    {{-- replies --}}
                    <span class="text-[12px] text-gray-400 mr-2">
                        <i class="fa-regular fa-comment-dots mr-1"></i> {{ $question->answers->count() }}
                    </span>


                    {{-- bookmark --}}
                    <x-bookmark-button :model="$question" />


                    {{-- language tag --}}
                    @forelse($question->tags as $tag)
                    <x-language-badge :language="$tag" :icon="true" />
                    @empty
                    <span class="text-[12px] text-gray-400">No Tags</span>
                    @endforelse


                    {{-- report system --}}
                    @php
                    $reportedByMe = auth()->check()
                    ? $question->reports()
                    ->where('user_id', auth()->id())
                    ->exists()
                    : false;
                    @endphp

                    <x-report-button :model="$question" :reported="$reportedByMe" />


                </div>
            </div>
        </div>
    </div>

</div>