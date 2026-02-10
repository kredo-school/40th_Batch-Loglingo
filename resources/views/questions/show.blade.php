<x-app-layout>
  <div class="py-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">

      {{--left side--}}
      <div class="w-full md:w-2/3 space-y-6">
        <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-8">


          {{-- post header --}}
          <div class="mb-3">
            <div class="flex items-start space-x-4 w-full">
              <img src="#" alt="user" class="w-16 h-16 rounded-full object-cover bg-orange-400">

              <div class="flex-1">
                <div class="flex justify-between items-center mb-1">
                  <a href="{{ route('profile.show',$question->user->id) }}">
                    <h3 class="font-bold text-lg text-gray-800">{{ $question->user->name }}</h3>
                  </a>

                  <x-answered-badge />

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
                      <i class="fa-solid fa-tag mr-1 text-gray-400"></i> {{ $tag->name }}
                    </span>
                    @endforeach

                    @if($question->tags->isEmpty())
                    <span class="text-[12px] px-2 py-1 text-gray-400">No Tags</span>
                    @endif

                    {{-- ★create a report function--}}
                    <i class="fa-regular fa-flag text-gray-400 hover:text-red-500 cursor-pointer"></i>
                  </div>

                </div>

              </div>
            </div>
          </div>

          {{-- question body --}}
          <p class="text-gray-700 leading-relaxed pb-2 mb-5 border-b break-words"> {{ $question->q_content }}
            {{ $question->q_content }} {{ $question->q_content }} {{ $question->q_content }} {{ $question->q_content }} {{ $question->q_content }}
          </p>

          {{-- comment form ★need to set a route--}}
          <div class="pb-4 border-b">
            <form action="#" method="POST">
              @csrf
              <div class="flex items-start space-x-4">
                <img src="#" alt="user" class="w-14 h-14 rounded-full object-cover bg-yellow-400">
                <div class="flex-1">
                  <h4 class="font-bold text-s text-gray-700 mb-1">{{ Auth::user()->name }}</h4>
                  <textarea name="comment" placeholder="write an answer here.." class="w-full border-gray-200 rounded-lg focus:ring-[#B178CC] focus:border-[#B178CC] text-s" rows="5" required></textarea>
                  <div class="flex justify-end mt-2">
                    <button type="submit" class="bg-[#56A5E1] text-white px-6 py-1 rounded-full text-sm font-bold shadow-sm hover:bg-blue-500 transition-colors">Post</button>
                  </div>
                </div>
              </div>
            </form>
          </div>

          {{-- display answers --}}
          {{-- answer example1 --}}
          <div class="space-y-6">
            <div class="flex items-start space-x-4 border-b py-4">
              <img src="#" alt="teacher" class="w-12 h-12 rounded-full object-cover bg-blue-400">

              <div class="flex-1">
                <div class="flex justify-between items-center mb-4">
                  <div class="flex items-center space-x-4">
                    <h4 class="font-bold text-[16px]">teacher name</h4>
                    <span class="text-[13px] text-gray-400">2 days ago</span>
                  </div>

                  <div class="flex items-center space-x-4">
                    {{-- delete ★need to set a route --}}
                    <form action="#" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="bg-red-500 text-white text-[14px] px-3 py-0.5 rounded-full font-bold hover:bg-red-600 transition-colors">delete</button>
                    </form>

                    {{-- ★need to create a report function --}}
                    <i class="fa-regular fa-flag text-[18px] text-gray-400 hover:text-red-500 cursor-pointer"></i>
                  </div>
                </div>

                <div>
                  <span class="text-s text-gray-700 leading-relaxed">While "buy" is grammatically correct, using "grab" makes your English sound
                    much more like a native speaker's. "Buy" focuses primarily on the financial
                    transaction—exchanging money for a product—which can feel a bit formal or
                    "dry" in a social context. On the other hand, "grab" shifts the focus to the action
                    and the experience. It implies that the activity is quick, easy, and informal, fitting
                    perfectly with the lifestyle of getting a coffee on the go. Furthermore, "grab" carries
                    a sense of spontaneity; it suggests an invitation to hang out without making it
                    feel like a big, scheduled event. You'll often hear phrases like "Let's grab a bite
                    " or "Let's grab a drink," where the word serves as a friendly social "lubricant.
                    " Using "grab" shows that you are comfortable with the casual rhythm of the
                    language, making the interaction feel more natural and relaxed. So, next time
                    you're heading to Starbucks, saying "I'm going to grab a coffee" will definitely
                    make you sound like a pro!
                    and get that second cup while you still can!</span>
                </div>
              </div>
            </div>
          </div>


          {{-- answer example2 --}}
          <div class="space-y-6">
            <div class="flex items-start space-x-4 border-b py-4">
              <img src="#" alt="teacher" class="w-12 h-12 rounded-full object-cover bg-blue-400">

              <div class="flex-1">
                <div class="flex justify-between items-center mb-4">
                  <div class="flex items-center space-x-4">
                    <h4 class="font-bold text-[16px]">teacher name</h4>
                    <span class="text-[13px] text-gray-400">2 days ago</span>
                  </div>

                  <div class="flex items-center space-x-4">
                    {{-- delete ★need to set a route --}}
                    <form action="#" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="bg-red-500 text-white text-[14px] px-3 py-0.5 rounded-full font-bold hover:bg-red-600 transition-colors">delete</button>
                    </form>

                    {{-- ★need to create a report function --}}
                    <i class="fa-regular fa-flag text-[18px] text-gray-400 hover:text-red-500 cursor-pointer"></i>
                  </div>
                </div>

                <div>
                  <span class="text-s text-gray-700 leading-relaxed">While "buy" is grammatically correct, using "grab" makes your English sound
                    much more like a native speaker's. "Buy" focuses primarily on the financial
                    transaction—exchanging money for a product—which can feel a bit formal or
                    "dry" in a social context. On the other hand, "grab" shifts the focus to the action
                    and the experience. It implies that the activity is quick, easy, and informal, fitting
                    perfectly with the lifestyle of getting a coffee on the go. Furthermore, "grab" carries
                    a sense of spontaneity; it suggests an invitation to hang out without making it
                    feel like a big, scheduled event. You’ll often hear phrases like "Let's grab a bite
                    " or "Let's grab a drink," where the word serves as a friendly social "lubricant.
                    " Using "grab" shows that you are comfortable with the casual rhythm of the
                    language, making the interaction feel more natural and relaxed. So, next time
                    you're heading to Starbucks, saying "I'm going to grab a coffee" will definitely
                    make you sound like a pro!
                    and get that second cup while you still can!</span>
                </div>
              </div>
            </div>
          </div>





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