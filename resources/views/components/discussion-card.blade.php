@props(['discussion'])

<div class="space-y-4">

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
          <a href="{{ route('questions.show', $discussion->question_id) }}" class="text-[10px] text-purple-400 hover:underline mt-0.5">
            <i class="fa-solid fa-quote-left mr-1"></i> Based on Question #{{ $discussion->question_id }}
          </a>
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
        <h4 class="text-xl font-extrabold text-gray-900 leading-tight mb-1 group-hover:underline decoration-gray-400 break-all whitespace-pre-wrap">{{ $discussion->d_title }}</h4>
        {{-- body --}}
        <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed break-all whitespace-pre-wrap">{{ $discussion->d_content }}</p>
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