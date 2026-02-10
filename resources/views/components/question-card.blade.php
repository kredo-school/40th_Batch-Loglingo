@props(['question'])

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
          <h3 class="font-bold text-gray-700 group-hover:text-[#B178CC] transition-colors">{{ $question->user->name }}</h3>
        </a>
      </div>

      {{-- tytle&body  --}}
      <a href="{{ route('questions.show', $question->id) }}" class="group block mt-1">
        {{-- title --}}
        <h4 class="text-xl font-extrabold text-gray-900 leading-tight mb-1 group-hover:underline decoration-gray-400 pr-24">
          {{ $question->q_title }}
        </h4>
        {{-- body --}}
        <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
          {{ $question->q_content }}
        </p>
      </a>

      {{-- bookmark&tag&report --}}
      <div class="flex justify-between items-center mt-4 pt-3 border-t border-gray-50">

        {{-- created at --}}
        <p class="text-[12px] text-gray-400">{{ $question->created_at->diffForHumans() }}</p>


        <div class="flex items-center space-x-3">
          {{-- ★create a bookmark function --}}
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

          {{-- ★create a report system --}}
          <i class="fa-regular fa-flag text-gray-400 hover:text-red-500 cursor-pointer"></i>
        </div>
      </div>
    </div>
  </div>

</div>