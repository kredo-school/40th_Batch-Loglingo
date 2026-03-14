<x-app-layout>
  <div class="py-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">

      {{--left side--}}
      <div class="w-full md:w-2/3 space-y-6">
        <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-8">

          {{-- post header --}}
          <div class="mb-6">
            <div class="flex items-start space-x-4 w-full">
              @if($post->user->avatar)
              <img src="{{ $post->user->avatar }}" alt="user" class="w-16 h-16 rounded-full object-cover">
              @else
              <i class="fa-solid fa-circle-user text-gray-400 text-[60px] leading-none"></i>
              @endif

              <div class="flex-1">
                <div class="flex justify-between items-center mb-1">
                  <a href="{{ route('profile.show',$post->user->id) }}">
                    <h3 class="font-bold text-lg text-gray-800">{{ $post->user->name }}</h3>
                  </a>


                  {{-- delete --}}
                  @if(Auth::id() === $post->user_id)
                  <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Really delete this post?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white text-sm px-3 py-1 rounded-full font-bold shadow-sm hover:bg-red-600 transition-colors">delete</button>
                  </form>
                  @endif

                </div>

                {{-- event date --}}
                <p class="text-[15px] text-gray-600 block mb-1">{{ $post->event_date->format('m/d/Y') }}</p>

                {{-- post title --}}
                <h2 class="text-[20px] font-extrabold text-gray-900 mb-2 break-words">
                  {{ $post->p_title }}
                </h2>

                {{-- footer(post date/tag/report) --}}
                <div class="flex justify-between items-center w-full">

                  {{-- created_at --}}
                  <p class="text-[13px] text-gray-400">{{ $post->created_at->diffForHumans() }}</p>

                  {{-- footer --}}
                  <div class="flex items-center space-x-3">

                    {{-- bookmark --}}
                    <x-bookmark-button :model="$post" />


                    {{-- tag --}}
                    @foreach($post->tags as $tag)
                    <span class="text-[12px] px-2 py-1 bg-gray-50 rounded-md text-gray-600 font-bold border border-gray-100">
                      <i class="fa-solid fa-tag mr-1 text-gray-400"></i> {{ $tag->code }}
                    </span>
                    @endforeach

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

          {{-- post body --}}
          <p class="text-gray-700 leading-relaxed pb-2 mb-5 border-b">
            {{ $post->p_content}}
          </p>

          {{-- comment form --}}
          <div class="pb-4 border-b" x-data="commentForm">
            <form action="{{ route('comments.store') }}" method="POST" @submit="submit()">
              @csrf
              <div class="flex items-start space-x-4">

                @if(Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" alt="user" class="w-12 h-12 rounded-full object-cover">
                @else
                <i class="fa-solid fa-circle-user text-gray-400 text-[50px] leading-none"></i>
                @endif

                <div class="flex-1">
                  <h4 class="font-bold text-s text-gray-700 mb-1">{{ Auth::user()->name }}</h4>

                  <textarea
                    name="c_content"
                    x-model="content"
                    @input="resize($el)"
                    placeholder="write a comment here.."
                    class="w-full border-gray-200 rounded-lg focus:ring-[#B178CC] focus:border-[#B178CC] text-s resize-none overflow-hidden transition-all" rows="2"
                    required></textarea>

                  <input type="hidden" name="post_id" value="{{ $post->id }}">

                  <div class="flex justify-end mt-2">
                    <button
                      type="submit"
                      :disabled="!content.trim() || isSubmitting"
                      class="bg-[#56A5E1] text-white px-6 py-1 rounded-full text-sm font-bold shadow-sm hover:bg-blue-500 transition-colors flex items-center disabled:opacity-50 disabled:cursor-not-allowed">

                      <template x-if="isSubmitting">
                        <i class="fa-solid fa-circle-notch animate-spin mr-2"></i>
                      </template>
                      <span x-text="isSubmitting ? 'Posting...' : 'Post'"></span>
                    </button>
                  </div>

                </div>
              </div>
            </form>
          </div>

          {{-- comments --}}
          <div class="space-y-6">
            @foreach($post->comments as $comment)
            <div class="flex items-start space-x-4 border-b py-4">
              @if($comment->user->avatar)
              <img src="{{ $comment->user->avatar }}" class="w-12 h-12 rounded-full object-cover">
              @else
              <i class="fa-solid fa-circle-user text-gray-400 text-[50px] leading-none"></i>
              @endif
              {{-- comment owner & date --}}
              <div class="flex-1">
                <div class="flex justify-between items-center mb-1">
                  <div class="flex items-center space-x-4">
                    <a href="{{ route('profile.show', $comment->user->id) }}">
                      <h4 class="font-bold text-[16px]">{{ $comment->user->name }}</h4>
                    </a>
                    <span class="text-[13px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                  </div>

                  <div class="flex items-center space-x-4">
                    {{-- delete comment--}}
                    @if(Auth::id() === $comment->user_id)
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Really delete this comment?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="bg-red-500 text-white text-[14px] px-3 py-0.5 rounded-full font-bold hover:bg-red-600 transition-colors">delete</button>
                    </form>
                    @endif


                    {{-- report --}}
                    @php
                    $reportedByMe = auth()->check()
                    ? $comment->reports()
                    ->where('user_id', auth()->id())
                    ->exists()
                    : false;
                    @endphp

                    <x-report-button :model="$post" :reported="$reportedByMe" />


                  </div>
                </div>


                {{-- display comment --}}
                <div>
                  <span class="text-s text-gray-700 leading-relaxed break-words">{{ $comment->c_content}} </span>
                </div>
              </div>
            </div>
            @endforeach
          </div>






        </div>
      </div>

      {{-- right side:component --}}
      <div class="w-full md:w-1/3 space-y-6">
        <x-sidebar-profile />
        <x-suggested-users />
      </div>
    </div>
  </div>
</x-app-layout>