<x-app-layout>
  <div class="py-8 bg-[#F9FAFB] min-h-screen">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">

      {{-- Left Side --}}
      <div class="w-full md:w-2/3 space-y-6">

        {{-- Referenced Question --}}
        @if($discussion->question)
        <div class="bg-white rounded-[1rem] shadow-sm border border-purple-100 p-6 relative overflow-hidden">
          <p class="text-[11px] font-extrabold text-purple-400 uppercase tracking-widest mb-2 flex items-center">
            <i class="fa-solid fa-link mr-2"></i> Referenced Question
          </p>
          <h3 class="text-md font-bold text-gray-700 mb-1">{{ $discussion->question->q_title }}</h3>
          <div class="flex items-center justify-between mt-3">
            <span class="text-xs text-gray-400">Asked by {{ $discussion->question->user->name }}</span>
            <a href="{{ route('questions.show', $discussion->question_id) }}" class="text-xs font-bold text-purple-500 hover:underline">
              View original <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>
        @endif

        {{-- Main Discussion Card --}}
        <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-8">

          {{-- Section A: Discussion Header & Body --}}
          <div class="pb-6 mb-6 border-b">
            <div class="flex items-start space-x-4 mb-4">
              <img src="{{ $discussion->user->avatar ?? asset('images/baby-octopus.png') }}" class="w-16 h-16 rounded-full object-cover">

              <div class="flex-1">
                <div class="flex justify-between items-center mb-1">
                  <a href="{{ route('profile.show',$discussion->user->id)}}">
                    <h3 class="font-bold text-lg text-gray-800">{{ $discussion->user->name }}</h3>
                  </a>


                  @if($discussion->is_resolved)
                  <x-resolved-badge />
                  @endif

                </div>

                {{-- discussion title --}}
                <div class="flex justify-between items-center mb-2">
                  <h2 class="text-[20px] font-extrabold text-gray-900 leading-tight mb-2">
                    {{ $discussion->d_title }}
                  </h2>

                  {{-- Delete Button --}}
                  @if(Auth::id() === $discussion->user_id)
                  <form action="{{ route('discussions.destroy', $discussion->id) }}" method="POST" onsubmit="return confirm('Really delete this discussion?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white text-sm px-3 py-1.5 rounded-full font-bold shadow-sm hover:bg-red-600 transition-colors">
                      delete
                    </button>
                  </form>
                  @endif

                </div>

                {{-- footer --}}
                <div class="flex justify-between items-center text-[13px] text-gray-400">

                  {{-- created at --}}
                  <p>{{ $discussion->created_at->diffForHumans() }}</p>

                  <div class="flex items-center space-x-3">
                    {{-- Mark resolved --}}
                    @if(Auth::id() === $discussion->user_id && !$discussion->is_resolved)
                    <form action="{{ route('discussions.resolve', $discussion->id) }}" method="POST">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="bg-green-500 text-white text-xs px-3 py-1 rounded-full font-bold hover:bg-green-600">Mark Resolved</button>
                    </form>
                    @endif

                    {{-- language tag --}}
                    @foreach($discussion->tags as $tag)
                    <span class="text-[12px] px-2 py-1 bg-gray-50 rounded-md text-gray-600 font-bold border border-gray-100 flex items-center">
                      <i class="fa-solid fa-tag mr-1 text-gray-400"></i> {{ $tag->code }}
                    </span>
                    @endforeach

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
            <p class="text-gray-700 leading-relaxed break-words whitespace-pre-wrap">{{ $discussion->d_content }}</p>
          </div>

          {{-- Reply Form --}}
          @if(auth()->check() && auth()->user()->role_id == 3)
          <div class="pb-6 mb-1 border-b">
            <form action="{{ route('replies.store', $discussion->id) }}" method="POST">
              @csrf
              <div class="flex items-start space-x-4">
                <img src="{{ auth()->user()->avatar ?? asset('images/baby-octopus.png') }}" class="w-14 h-14 rounded-full object-cover">
                <div class="flex-1">
                  <h4 class="font-bold text-gray-700 mb-2">{{ Auth::user()->name }}</h4>
                  <textarea name="r_content" placeholder="write an insight here.." class="w-full border-gray-200 rounded-lg focus:ring-purple-400 focus:border-purple-400 text-sm" rows="4" required></textarea>
                  <div class="flex justify-end mt-2">
                    <button type="submit" class="bg-purple-500 text-white px-6 py-1 rounded-full text-sm font-bold hover:bg-purple-600 transition-colors">Post</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          @endif

          {{-- display replies --}}
          <div class="space-y-1">
            @foreach($discussion->replies as $reply)
            <div class="flex items-start space-x-4 border-b last:border-0 py-4">
              <img src="{{ $reply->user->avatar ?? asset('images/baby-octopus.png') }}" class="w-12 h-12 rounded-full object-cover">

              <div class="flex-1">
                <div class="flex justify-between items-center mb-2">
                  <div class="flex items-center space-x-2">
                    <a href="{{ route('profile.show',$discussion->user->id)}}">
                      <h4 class="font-bold text-[16px]">{{ $reply->user->name }}</h4>
                    </a>
                    <span class="text-[13px] text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                  </div>

                  <div class="flex items-center space-x-4">
                    {{-- Delete Button --}}
                    @if(Auth::id() === $reply->user_id)
                    <form action="{{ route('replies.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('Really delete this reply?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="bg-red-500 text-white text-xs px-3 py-1.5 rounded-full font-bold shadow-sm hover:bg-red-600 transition-colors">
                        delete
                      </button>
                    </form>
                    @endif


                    {{-- report reply --}}
                    @php
                    $reportedByMe = auth()->check()
                    ? $reply->reports()
                    ->where('user_id', auth()->id())
                    ->exists()
                    : false;
                    @endphp

                    @if (!$reportedByMe)
                    <form action="{{ route('report.store') }}" method="POST" onsubmit="return confirm('Are you sure you want to report this?');">
                      @csrf
                      <input type="hidden" name="reportable_id" value="{{ $reply->id }}">
                      <input type="hidden" name="reportable_type" value="{{ \App\Models\Reply::class }}">

                      <button type="submit" title="Report this question">
                        <i class="fa-regular fa-flag text-gray-400 hover:text-red-500 cursor-pointer"></i>
                      </button>
                    </form>
                    @else
                    <i class="fa-solid fa-flag text-red-500"></i>
                    @endif


                  </div>


                </div>
                <div class="text-sm text-gray-700 leading-relaxed break-all whitespace-pre-wrap">{{ $reply->r_content }}</div>
              </div>
            </div>
            @endforeach
          </div>

        </div> {{-- End Main Card --}}
      </div>

      {{-- Right Side --}}
      <div class="w-full md:w-1/3 space-y-6">
        <x-sidebar-profile-teacher-for-discussions />
        <x-suggested-teachers />
      </div>

    </div>
  </div>
</x-app-layout>