@props(['post'])

<div class="space-y-4">

  <!-- post example1 -->
  <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-5 flex space-x-4 transition-all hover:border-gray-200">

    {{-- user icon --}}
    <div class="flex-shrink-0">
      <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-white shadow-sm">
     
      @if($post->user->avatar)
        <img src="{{ $post->user->avatar }}" alt="user" class="text-[50px] object-cover">
      @else
          <i class="fa-solid fa-circle-user text-gray-400 text-[50px] leading-none"></i>
      @endif

      </div>
    </div>

    {{-- content --}}
    <div class="flex-1 flex flex-col">
      <div class="flex justify-between items-start mb-2">
        <a href="{{ route('profile.show',$post->user->id) }}" class="group">
          <h3 class="font-bold text-gray-700 group-hover:text-[#B178CC] transition-colors"> {{ $post->user->name }} </h3> 
        </a>
        <span class="text-gray-400 text-[13px] underline">{{ $post->event_date->format('m/d/Y') }}</span> 
      </div>

      {{-- tytle&body  --}}
      <a href="{{ route('posts.show', $post->id) }}" class="group block mt-1">
        {{-- title --}}
        <h4 class="text-xl font-extrabold text-gray-900 leading-tight mb-1 group-hover:underline decoration-gray-400">
          {{ $post->p_title }}
        </h4>
        {{-- body --}}
        <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
           {{ $post->p_content }}
        </p>
      </a>

      {{-- tag --}}
      <div class="flex justify-between items-center mt-4 pt-3 border-t border-gray-50">
        <p class="text-[12px] text-gray-400">{{ $post->created_at->diffForHumans() }}</p> 

        <div class="flex items-center space-x-3">
          @forelse($post->tags as $tag)
            <span class="text-[12px] px-2 py-1 bg-gray-50 rounded-md text-gray-600 font-bold border border-gray-100">
              <i class="fa-solid fa-tag mr-1 text-gray-400"></i> {{ $tag->code }}
            </span>
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
          
          @if (!$reportedByMe)
          <form action="{{ route('report.store') }}" method="POST" onsubmit="return confirm('Are you sure you want to report this?');">
              @csrf
              <input type="hidden" name="reportable_id" value="{{ $post->id }}">
              <input type="hidden" name="reportable_type" value="{{ \App\Models\Post::class }}">

              <button type="submit">
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