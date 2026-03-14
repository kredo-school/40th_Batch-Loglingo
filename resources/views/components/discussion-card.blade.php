@props(['discussion'])

<div x-data="discussionCard" class="space-y-4">

  <div class="relative bg-white rounded-[1rem] shadow-sm border border-gray-100 p-5 flex items-start space-x-4 transition-all hover:border-gray-200" mb-4>

    {{-- user icon --}}
    <div class="flex-shrink-0">
      <div class="w-16 h-16 rounded-full overflow-hidden">

        @if($discussion->user->avatar)
        <img src="{{ $discussion->user->avatar }}" alt="user" class="w-full h-full object-cover">
        @else
        <i class="fa-solid fa-circle-user text-gray-400 text-[4rem] leading-none"></i>
        @endif

      </div>
    </div>

    {{-- content --}}
    <div class="flex-1 min-w-0">
      <div class="flex justify-between items-start mb-2">
        <div class="flex flex-col">
          <a href="{{ route('profile.show' , $discussion->user->id)}}" class="group">
            <h3 class="font-bold text-gray-700 group-hover:text-[#B178CC] transition-colors text-sm">
              {{ $discussion->user->name }}
            </h3>
          </a>

          {{-- quoted question --}}
          @if($discussion->question_id)
          <button @click="toggleModal" class="text-[10px] text-purple-400 hover:underline mt-0.5 text-left focus:outline-none">
            <i class="fa-solid fa-quote-left mr-1"></i> Based on Question #{{ $discussion->question_id }}
          </button>

          {{-- start Question Modal --}}
          <div x-show="openQuestion"
            x-cloak
            class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-black bg-opacity-60 text-gray-800"
            style="display: none;">

            <div @click.away="openQuestion = false"
              class="bg-white rounded-2xl shadow-xl max-w-lg w-full flex flex-col overflow-hidden transform transition-all">

              {{-- Modal Header --}}
              <div class="px-5 py-3 border-b flex justify-between items-center bg-gray-50">
                <span class="text-xs font-bold text-purple-400">
                  <i class="fa-solid fa-circle-question mr-1"></i> Original Question #{{ $discussion->question_id }}
                </span>
                <button @click="toggleModal" class="text-gray-400 hover:text-gray-600"> {{-- ★追加 --}}
                  <i class="fa-solid fa-xmark"></i>
                </button>
              </div>

              {{-- Modal Body --}}
              <div class="p-6 text-left">
                @if($discussion->question)
                <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $discussion->question->q_title }}</h4>
                <div class="max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                  <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap break-words">{{ $discussion->question->q_content }}</p>
                </div>

                <div class="mt-4">
                  <a href="{{ route('questions.show', $discussion->question_id) }}" class="text-xs text-[#B178CC] font-bold hover:underline">
                    View full question page <i class="fa-solid fa-arrow-right ml-1"></i>
                  </a>
                </div>
                @else
                <p class="text-sm text-gray-500 italic">Question data not found.</p>
                @endif
              </div>

              {{-- Modal Footer --}}
              <div class="px-5 py-3 border-t bg-gray-50 text-right">
                <button @click="toggleModal" class="bg-[#B178CC] text-white px-5 py-2 rounded-full text-xs font-bold shadow-md hover:bg-[#a066b8]"> {{-- ★追加 --}}
                  Close
                </button>
              </div>
            </div>
          </div>
          {{-- end Question Modal --}}


          @endif
        </div>

        {{-- Resolved Badge --}}
        @if($discussion->is_resolved)
        <x-resolved-badge class="absolute top-4 right-4" />
        @endif
      </div>

      {{-- title&body  --}}
      <a href="{{ route('discussions.show', $discussion->id) }}" class="group block mt-1">
        {{-- title --}}
        <h4 class="text-xl font-extrabold text-gray-900 leading-tight mb-1 group-hover:underline decoration-gray-400 break-words whitespace-pre-wrap">{{ $discussion->d_title }}</h4>
        {{-- body --}}
        <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed break-words whitespace-pre-wrap">{{ $discussion->d_content }}</p>
      </a>

      {{-- footer --}}
      <div class="flex justify-between items-center mt-4 pt-3 border-t border-gray-50">

        {{-- created at --}}
        <p class="text-[12px] text-gray-400">{{ $discussion->created_at->diffForHumans() }}</p>


        <div class="flex items-center space-x-3">
          {{-- replies --}}
          <span class="text-[12px] text-gray-400 mr-2">
            <i class="fa-regular fa-comment-dots mr-1"></i> {{ $discussion->replies->count() }}
          </span>

          {{-- bookmark --}}
          <x-bookmark-button :model="$discussion" />

          {{-- language tag --}}
          @foreach($discussion->tags as $tag)
          <span class="text-[12px] px-2 py-1 bg-gray-50 rounded-md text-gray-600 font-bold border border-gray-100 flex items-center">
            <i class="fa-solid fa-tag mr-1 text-gray-400"></i> {{ $tag->code }}
          </span>
          @endforeach

          @if($discussion->tags->isEmpty())
          <span class="text-[12px] px-2 py-1 text-gray-400">No Tags</span>
          @endif


          {{-- report discussion --}}
          @php
          $reportedByMe = auth()->check()
          ? $discussion->reports()
          ->where('user_id', auth()->id())
          ->exists()
          : false;
          @endphp

          <x-report-button :model="$discussion" :reported="$reportedByMe" />


        </div>
      </div>


    </div>
  </div>

</div>