<div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-6">
  <div class="flex items-center space-x-4">
    <div class="w-16 h-16 rounded-full overflow-hidden">
      @if(Auth::user()->avatar)
        <img src="{{ Auth::user()->avatar }}" alt="user" class="w-full h-full object-cover">
      @else
        <i class="fa-solid fa-circle-user text-gray-400 text-[4rem] leading-none"></i>
      @endif
    </div>
    <div>
      <h3 class="text-xl font-bold">{{ Auth::user()->name }}</h3>
      <p class="text-sm"><span class="font-bold">{{ Auth::user()->posts_count ?? 0 }}</span> posts</p> 
      <p class="text-sm"><span class="font-bold">{{ Auth::user()->questions_count ?? 0 }}</span> questions</p> 
    </div>
  </div>

  <a href="{{ route('questions.create') }}" class="block w-full border border-gray-400 hover:bg-[#B178CC] hover:text-white text-center font-bold py-4 mt-4 rounded-[1rem] transition-transform hover:scale-[1.02] active:scale-95">
    <span class="text-[22px]"><i class="fa-regular fa-circle-question"></i></i> Ask a question </span>
  </a>{{--★create a link to Post a new log page--}}
</div>