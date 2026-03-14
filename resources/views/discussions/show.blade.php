<x-app-layout>
  <div x-data="discussionCard" class="py-8 bg-[#F9FAFB] min-h-screen">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">

      {{-- Left Side --}}
      <div class="w-full md:w-2/3 space-y-6">

        {{-- Referenced Question --}}
        @if($discussion->question)
        <div class="bg-white rounded-[1rem] shadow-sm border border-purple-100 p-6 relative overflow-hidden group">
          {{-- quote icon --}}
          <i class="fa-solid fa-quote-right absolute right-4 bottom-[-10px] text-purple-50 text-6xl opacity-40"></i>

          <div class="relative z-10">
            <p class="text-[11px] font-extrabold text-purple-400 uppercase tracking-widest mb-2 flex items-center">
              <i class="fa-solid fa-link mr-2"></i> Referenced Question
            </p>
            <h3 class="text-md font-bold text-gray-700 mb-1 leading-snug">{{ $discussion->question->q_title }}</h3>

            {{-- check if q_content is overfloating --}}
            <p x-ref="content"
              x-init="checkTruncation($refs.content)"
              class="text-xs text-gray-500 italic mb-3 line-clamp-5 leading-relaxed whitespace-pre-wrap">"{{ $discussion->question->q_content }}"</p>

            <div class="flex items-center justify-between mt-3">
              <span class="text-xs text-gray-400">Asked by {{ $discussion->question->user->name }}</span>

              <div class="flex items-center space-x-4">
                {{-- show button when isTruncated is true --}}
                <button x-show="isTruncated"
                  @click="toggleModal"
                  class="text-xs font-bold text-purple-500 hover:text-purple-700 transition-colors flex items-center"
                  style="display: none;">
                  <i class="fa-solid fa-expand-alt mr-1.5"></i> Read Full Text
                </button>

                <a href="{{ route('questions.show', $discussion->question_id) }}" class="text-xs font-bold text-gray-400 hover:text-purple-500 transition-colors">
                  View full question page <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
              </div>
            </div>
          </div>

          {{-- Question Modal --}}
          <div x-show="openQuestion"
            x-cloak
            class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-black bg-opacity-60 text-gray-800"
            style="display: none;">

            <div @click.away="openQuestion = false"
              class="bg-white rounded-2xl shadow-xl max-w-lg w-full flex flex-col overflow-hidden transform transition-all">

              <div class="px-5 py-3 border-b flex justify-between items-center bg-gray-50">
                <span class="text-xs font-bold text-purple-400">
                  <i class="fa-solid fa-circle-question mr-1"></i> Original Question #{{ $discussion->question_id }}
                </span>
                <button @click="toggleModal" class="text-gray-400 hover:text-gray-600">
                  <i class="fa-solid fa-xmark"></i>
                </button>
              </div>

              <div class="p-6 text-left">
                <h4 class="text-lg font-bold text-gray-900 mb-3">{{ $discussion->question->q_title }}</h4>
                <div class="max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                  <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap break-words">{{ $discussion->question->q_content }}</p>
                </div>
              </div>

              <div class="px-5 py-3 border-t bg-gray-50 text-right">
                <button @click="toggleModal" class="bg-[#B178CC] text-white px-5 py-2 rounded-full text-xs font-bold shadow-md hover:bg-[#a066b8]">
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>
        @endif
        {{-- End Referenced Question --}}




        {{-- Main Discussion Card --}}
        <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-8">

          {{-- Section A: Discussion Header & Body --}}
          <div class="pb-6 mb-6 border-b">
            <div class="flex items-start space-x-4 mb-4">
              @if($discussion->user->avatar)
              <img src="{{ $discussion->user->avatar }}" alt="user" class="w-16 h-16 rounded-full object-cover">
              @else
              <i class="fa-solid fa-circle-user text-gray-400 text-[96px] leading-none"></i>
              @endif

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
                  <h2 class="text-[20px] font-extrabold text-gray-900 leading-tight mb-2 break-words">
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
                      <button type="submit" class="bg-blue-500 text-white text-xs px-3 py-1 rounded-full font-bold hover:bg-blue-600">Mark Resolved</button>
                    </form>
                    @endif

                    {{-- bookmark --}}
                    <x-bookmark-button :model="$discussion" />

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

                    <x-report-button :model="$discussion" :reported="$reportedByMe" />


                  </div>
                </div>
              </div>
            </div>
            <p class="text-gray-700 leading-relaxed break-words whitespace-pre-wrap">{{ $discussion->d_content }}</p>
          </div>

          {{-- Reply Form --}}
          @if(auth()->check() && auth()->user()->role_id == 3)
          <div class="pb-6 mb-1 border-b" x-data="commentForm">
            <form action="{{ route('replies.store', $discussion->id) }}" method="POST" @submit="submit()">
              @csrf
              <div class="flex items-start space-x-4">
                {{-- avatar --}}

                @if( auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}" alt="user" class="w-12 h-12 object-cover">
                @else
                <i class="fa-solid fa-circle-user text-gray-400 text-[50px] leading-none"></i>
                @endif


                <div class="flex-1">
                  <h4 class="font-bold text-gray-700 mb-2">{{ Auth::user()->name }}</h4>

                  <textarea
                    name="r_content"
                    x-model="content"
                    @input="resize($el)"
                    placeholder="write an insight here.."
                    class="w-full border-gray-200 rounded-lg focus:ring-purple-400 focus:border-purple-400 text-sm resize-none overflow-hidden transition-all"
                    rows="2" required></textarea>

                  <div class="flex justify-end mt-2">
                    <button
                      type="submit"
                      :disabled="!content.trim() || isSubmitting"
                      class="bg-purple-500 text-white px-6 py-1 rounded-full text-sm font-bold hover:bg-purple-600 transition-colors flex items-center disabled:opacity-50 disabled:cursor-not-allowed">

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
          @endif

          {{-- display replies --}}
          <div class="space-y-1">
            @foreach($discussion->replies as $reply)
            <div class="flex items-start space-x-4 border-b last:border-0 py-4">
              {{-- avatar --}}
              @if( $reply->user->avatar)
              <img src="{{ $reply->user->avatar }}" alt="user" class="w-12 h-12 rounded-full object-cover">
              @else
              <i class="fa-solid fa-circle-user text-gray-400 text-[50px] leading-none"></i>
              @endif

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

                    <x-report-button :model="$discussion" :reported="$reportedByMe" />



                  </div>


                </div>
                <div class="text-sm text-gray-700 leading-relaxed break-words whitespace-pre-wrap">{{ $reply->r_content }}</div>
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