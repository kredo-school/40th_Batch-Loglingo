<div class="space-y-4">

  <div class="relative bg-white rounded-[1rem] shadow-sm border border-gray-100 p-5 flex space-x-4 transition-all hover:border-gray-200">

    {{-- ★ Answered Badge  @if($question->is_answered)  --}}
    <x-answered-badge class="absolute top-4 right-4" />

    {{-- user icon --}}
    <div class="flex-shrink-0">
      <div class="w-16 h-16 rounded-full bg-orange-400 overflow-hidden border-2 border-white shadow-sm">
        <img src="#" alt="user" class="w-full h-full object-cover">
      </div>
    </div>

    {{-- content --}}
    <div class="flex-1 flex flex-col">
      <div class="flex justify-between items-start mb-2">
        <a href="#" class="group">
          <h3 class="font-bold text-gray-700 group-hover:text-[#B178CC] transition-colors">user name</h3> {{--★$post->user->name --}}
        </a>
      </div>

      {{-- tytle&body  --}}
      <a href="{{ route('questions.show', 1) }}" class="group block mt-1">
        {{-- title --}}
        <h4 class="text-xl font-extrabold text-gray-900 leading-tight mb-1 group-hover:underline decoration-gray-400 pr-24">
          Is "grab" better than "buy" for coffee? {{-- ★$question->title --}}
        </h4>
        {{-- body --}}
        <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
          While "buy" is grammatically correct, using "grab" makes your English sound
          much more like a native speaker's. "Buy" focuses primarily on the financial
          transaction—exchanging money for a product—which can feel a bit formal or
          "dry" in a social context. On the other hand, "grab" shifts the focus to the action {{-- ★$post->body --}}
        </p>
      </a>

      {{-- bookmark&tag&report --}}
      <div class="flex justify-between items-center mt-4 pt-3 border-t border-gray-50">
        <p class="text-[12px] text-gray-400">2 days ago</p> {{-- ★$post->created_at->diffForHumans() --}}

        <div class="flex items-center space-x-3">
          <i class="fa-regular fa-bookmark text-gray-400 hover:text-green-500 cursor-pointer"></i>
          <span class="text-[12px] px-2 py-1 bg-gray-50 rounded-md text-gray-600 font-bold border border-gray-100">
            <i class="fa-solid fa-tag mr-1 text-gray-400"></i> EN {{-- ★$post->language_tag --}}
          </span>
          <i class="fa-regular fa-flag text-gray-400 hover:text-red-500 cursor-pointer"></i> {{-- ★add a report system --}}
        </div>
      </div>
    </div>
  </div>

</div>