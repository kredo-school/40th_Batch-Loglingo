<div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-6">
  <div class="flex items-center space-x-4">
    <div class="w-16 h-16 rounded-full bg-blue-400 border-4 border-white shadow-sm overflow-hidden">
      <img src="#" alt="teacher" class="w-full h-full object-cover">
    </div>
    <div>
      <h3 class="text-xl font-bold">{{ Auth::user()->name }}</h3>
      <p class="text-sm"><span class="font-bold">3</span> posts</p> {{-- ★show its post count --}}
      <p class="text-sm"><span class="font-bold">3</span> answers</p> {{-- ★show its answer count --}}
    </div>
  </div>

  <a href="{{ route('posts.create') }}" class="block w-full border border-gray-400 hover:bg-[#B178CC] hover:text-white text-center font-bold py-4 mt-4 rounded-[1rem] shadow-md transition-transform hover:scale-[1.02] active:scale-95">
    <span class="text-[22px]"><i class="fa-solid fa-pen-to-square mr-2"></i>Post a new log</span>
  </a>{{--★create a link to Post a new log page--}}
</div>