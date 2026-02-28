<x-app-layout>
  <div class="py-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">

      {{--left side--}}
      <div class="w-full md:w-2/3 space-y-6">
        <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-8">


          {{-- post header --}}
          <div class="mb-3">
            <div class="flex items-start space-x-4 w-full">
              @if($question->user->avatar)
                <img src="{{ $question->user->avatar }}"  alt="user" class="w-16 h-16 rounded-full object-cover">
              @else
                  <i class="fa-solid fa-circle-user text-gray-400 text-[96px] leading-none"></i>
              @endif

              <div class="flex-1">
                <div class="flex justify-between items-center mb-1">
                  <a href="{{ route('profile.show',$question->user->id )}}">
                    <h3 class="font-bold text-lg text-gray-800">{{ $question->user->name }}</h3>
                  </a>

                  @if($question->answers->count() > 0)
                  <x-answered-badge />
                  @endif

                </div>

                {{-- post title --}}
                <div class="flex justify-between items-center mb-2">
                  <h2 class="text-[20px] font-extrabold text-gray-900 mb-2">
                    {{ $question->q_title }}
                  </h2>

                  {{-- delete button --}}
                  @if(Auth::id() === $question->user_id)
                  <form action="{{ route('questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Really delete this question?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white text-sm px-3 py-1 rounded-full font-bold shadow-sm hover:bg-red-600 transition-colors">delete</button>
                  </form>
                  @endif

                </div>


                {{-- footer(post date/tag/report) --}}
                <div class="flex justify-between items-center w-full">

                  {{-- created at --}}
                  <p class="text-[13px] text-gray-400">{{ $question->created_at->diffForHumans() }}</p>

                  {{--★ create a bookmark function --}}
                  <div class="flex items-center space-x-4">
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

                    {{-- report function--}}
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

          {{-- question body --}}
          <div class="pb-2 mb-5 border-b">
            <p class="text-gray-700 leading-relaxed break-words">
              {{ $question->q_content }}
            </p>

            {{-- Start Discussion button --}}
            @if(auth()->check() && auth()->user()->role_id == 3)
            <div class="flex justify-end">
              <a href="{{ route('discussions.create', ['question_id' => $question->id]) }}"
                class="inline-flex items-center my-2 px-4 py-2 bg-purple-400 border border-transparent rounded-full font-bold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                <i class="fa-solid fa-quote-left mr-2"></i> Start Discussion
              </a>
              @endif
            </div>

          </div>


          {{-- answer form--}}
          @if(auth()->check() && auth()->user()->role_id == 3)
          <div class="pb-4 border-b">
            <form action="{{ route('answers.store') }}" method="POST">
              @csrf
              <input type="hidden" name="question_id" value="{{ $question->id }}">

              <div class="flex items-start space-x-4">
                @if($question->user->avatar)
                <img src="{{ $question->user->avatar }}"  alt="user" class="w-16 h-16 rounded-full object-cover">
                @else
                  <i class="fa-solid fa-circle-user text-gray-400 text-[96px] leading-none"></i>
                @endif
                <div class="flex-1">
                  <h4 class="font-bold text-s text-gray-700 mb-1">{{ Auth::user()->name }}</h4>
                  <textarea name="a_content" placeholder="write an answer here.." class="w-full border-gray-200 rounded-lg focus:ring-[#B178CC] focus:border-[#B178CC] text-s" rows="5" required></textarea>
                  <div class="flex justify-end mt-2">
                    <button type="submit" class="bg-[#56A5E1] text-white px-6 py-1 rounded-full text-sm font-bold shadow-sm hover:bg-blue-500 transition-colors">Post</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          @endif

          {{-- display answers --}}
          @foreach($question->answers as $answer)
          <div class="space-y-6">
            <div class="flex items-start space-x-4 border-b py-4">
              @if($answer->user->avatar)
                <img src="{{ $qanswer->user->avatar }}"  alt="user" class="w-12 h-12 rounded-full object-cover">
              @else
                  <i class="fa-solid fa-circle-user text-gray-400 text-[96px] leading-none"></i>
              @endif
              <div class="flex-1">
                <div class="flex justify-between items-center mb-4">
                  <div class="flex items-center space-x-4">
                    <h4 class="font-bold text-[16px]">{{ $answer->user->name }}</h4>
                    <span class="text-[13px] text-gray-400">{{ $answer->created_at->diffForHumans() }}</span>
                  </div>

                  <div class="flex items-center space-x-4">
                    {{-- delete button --}}
                    @if(Auth::id() === $answer->user_id)
                    <form action="{{ route('answers.destroy', $answer->id) }}" method="POST" onsubmit="return confirm('Delete this answer?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="bg-red-500 text-white text-[14px] px-3 py-0.5 rounded-full font-bold hover:bg-red-600 transition-colors">delete</button>
                    </form>
                    @endif

                    {{-- report function --}}
                    @php
                    $reportedByMe = auth()->check()
                    ? $answer->reports()->where('user_id', auth()->id())->exists()
                    : false;
                    @endphp

                    @if (!$reportedByMe)
                    <form action="{{ route('report.store') }}" method="POST" onsubmit="return confirm('Report this answer?');">
                      @csrf
                      <input type="hidden" name="reportable_id" value="{{ $answer->id }}">
                      <input type="hidden" name="reportable_type" value="App\Models\Answer">
                      <button type="submit">
                        <i class="fa-regular fa-flag text-[18px] text-gray-400 hover:text-red-500 cursor-pointer"></i>
                      </button>
                    </form>
                    @else
                    <i class="fa-solid fa-flag text-red-500"></i>
                    @endif
                  </div>
                </div>

                <div class="text-s text-gray-700 leading-relaxed break-words">
                  {!! nl2br(e($answer->a_content)) !!}
                </div>
              </div>
            </div>
          </div>
          @endforeach




        </div>
      </div>

      {{-- right side:component --}}
      <div class="w-full md:w-1/3 space-y-6">
        <x-sidebar-profile-for-questions />
        <x-suggested-users />
      </div>
    </div>
  </div>
</x-app-layout>