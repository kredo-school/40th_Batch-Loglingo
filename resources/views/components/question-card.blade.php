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
                    <h3 class="font-bold text-gray-700 group-hover:text-[#B178CC] transition-colors">{{ $question->user->name }}</h3>
                </a>
            </div>

            @if($question->answers->count() > 0)
            <x-answered-badge class="absolute top-4 right-4" />
            @endif

            {{-- tytle&body  --}}
            <a href="{{ route('questions.show', $question->id) }}" class="group block mt-1">
                {{-- title --}}
                <h4 class="text-xl font-extrabold text-gray-900 leading-tight mb-1 group-hover:underline decoration-gray-400">
                    {{ $question->q_title }}
                </h4>
                {{-- body --}}
                <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed break-all whitespace-pre-wrap">{{ $question->q_content }}</p>
            </a>

            {{-- bookmark&tag&report --}}
            <div class="flex justify-between items-center mt-4 pt-3 border-t border-gray-50">

                {{-- created at --}}
                <p class="text-[12px] text-gray-400">{{ $question->created_at->diffForHumans() }}</p>


                <div class="flex items-center space-x-3">
                    {{-- ★create a bookmark function --}}
                    <i class="fa-regular fa-bookmark text-gray-400 hover:text-green-500 cursor-pointer"></i>

                    {{-- language tag --}}
                    @foreach($question->tags as $tag)
                    <span class="text-[12px] px-2 py-1 bg-gray-50 rounded-md text-gray-600 font-bold border border-gray-100 flex items-center">
                        <i class="fa-solid fa-tag mr-1 text-gray-400"></i> {{ $tag->code }}
                    </span>
                    @endforeach

                    @if($question->tags->isEmpty())
                    <span class="text-[12px] px-2 py-1 text-gray-400">No Tags</span>
                    @endif


                    {{-- report system --}}
                    @php
                    $reportedByMe = auth()->check()
                    ? $question->reports()
                    ->where('user_id', auth()->id())
                    ->exists()
                    : false;
                    @endphp

                    @if (!$reportedByMe)
                    <form action="{{ route('report.store') }}" method="POST" onsubmit="return confirm('Are you sure you want to report this?');">
                        @csrf
                        <input type="hidden" name="reportable_id" value="{{ $question->id }}">
                        <input type="hidden" name="reportable_type" value="{{ \App\Models\Question::class }}">

                        <button type="submit" title="Report this question">
                            <i class="fa-regular fa-flag text-gray-400 hover:text-red-500 cursor-pointer"></i>
                        </button>
                    </form>
                    @else
                    <i class="fa-solid fa-flag text-red-500"></i>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>