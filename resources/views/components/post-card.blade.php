@props(['post'])

<div class="space-y-4">

  <!-- post example1 -->
  <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-5 flex items-start space-x-4 transition-all hover:border-gray-200">

    {{-- user icon --}}
    <div class="flex-shrink-0">
      <div class="w-16 h-16 rounded-full overflow-hidden">

        @if($post->user->avatar)
        <img src="{{ $post->user->avatar }}" alt="user" class="w-full h-full object-cover">
        @else
        <i class="fa-solid fa-circle-user text-gray-400 text-[4rem] leading-none"></i>
        @endif

      </div>
    </div>

    {{-- content --}}
    <div class="flex-1 min-w-0">
      <div class="flex justify-between items-start mb-2">
        <a href="{{ route('profile.show',$post->user->id) }}" class="group">
          <h3 class="font-bold text-gray-700 group-hover:text-[#B178CC] transition-colors truncate max-w-full"> {{ $post->user->name }} </h3>
        </a>
        <span class="text-gray-400 text-[13px] underline">{{ $post->event_date->format('m/d/Y') }}</span>
      </div>

      {{-- tytle&body  --}}
      <a href="{{ route('posts.show', $post->id) }}" class="group block mt-1 truncate">
        {{-- title --}}
        <h4 class="text-xl font-extrabold text-gray-900 leading-tight mb-1 group-hover:underline decoration-gray-400 break-words">
          {{ $post->p_title }}
        </h4>
        {{-- body --}}
        <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed break-words whitespace-pre-wrap">{{ $post->p_content }}</p>
      </a>



      {{-- footer --}}
      <div class="flex justify-between items-center mt-4 pt-3 border-t border-gray-50">

        {{-- created at --}}
        <p class="text-[12px] text-gray-400">{{ $post->created_at->diffForHumans() }}</p>


        <div class="flex items-center space-x-3">
          {{-- replies --}}
          <span class="text-[12px] text-gray-400 mr-2">
            <i class="fa-regular fa-comment-dots mr-1"></i> {{ $post->comments->count() }}
          </span>


          {{-- bookmark --}}
          <x-bookmark-button :model="$post" />


          {{-- tag --}}
          @forelse($post->tags as $tag)
          <x-language-badge :language="$tag" :icon="true" />
          @empty
          <span class="text-[12px] text-gray-400">No Tags</span>
          @endforelse


          {{-- report system --}}
          @php
          $reportedByMe = auth()->check()
          ? $post->reports()
          ->where('user_id', auth()->id())
          ->exists()
          : false;
          @endphp

          <x-report-button :model="$post" :reported="$reportedByMe" />



        </div>
      </div>
    </div>
  </div>




</div>