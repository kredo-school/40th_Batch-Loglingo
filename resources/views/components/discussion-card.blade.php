@props(['discussion'])

<div class="space-y-4">

  <div class="relative bg-white rounded-[1rem] shadow-sm border border-gray-100 p-5 flex space-x-4 transition-all hover:border-gray-200" mb-4>

    {{-- Resolved Badge --}}
    @if($discussion->is_resolved)
    <x-resolved-badge class="absolute top-4 right-4" />
    @endif

    {{-- user icon --}}
    <div class="flex-shrink-0">
      <div class="w-16 h-16 rounded-full bg-orange-400 overflow-hidden border-2 border-white shadow-sm">
        <img src="{{ $discussion->user->avatar ?? asset('images/baby-octopus.png') }}" alt="user" class="w-full h-full object-cover">
      </div>
    </div>

    {{-- content --}}
    <div class="flex-1 flex flex-col">
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
      </div>

      {{-- title&body  --}}
      <a href="{{ route('discussions.show', $discussion->id) }}" class="group block mt-1">
        {{-- title --}}
        <h4 class="text-xl font-extrabold text-gray-900 leading-tight mb-1 group-hover:underline decoration-gray-400 pr-24 break-all whitespace-pre-wrap">{{ $discussion->d_title }}</h4>
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

          @if (!$reportedByMe)
          <form action="{{ route('report.store') }}" method="POST" onsubmit="return confirm('Are you sure you want to report this?');">
            @csrf
            <input type="hidden" name="reportable_id" value="{{ $discussion->id }}">
            <input type="hidden" name="reportable_type" value="{{ \App\Models\Discussion::class }}">

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