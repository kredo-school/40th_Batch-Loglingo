<div class="space-y-3">

  <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100">
    <div class="flex justify-between items-end m-4">
      <h2 class="text-[24px] font-bold">Suggested Users</h2>
      <a href="#" class="text-sm text-black hover:underline">see more</a> {{--★need to create a link to show more posts --}}
    </div>
  </div>

  <div class="space-y-2">

    <!-- user profile example1 -->
    @forelse($users as $user)
    <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-14 h-14 rounded-full overflow-hidden flex items-center justify-center">
            @if($user->avatar)
              <img src="{{ $user->avatar }}" class="w-full h-full object-cover">
            @else
              <i class="fa-solid fa-circle-user text-gray-400 text-[56px]"></i>
            @endif
          </div>

          <div>
            <p class="text-[16px] font-bold">
              <a href="{{ route('profile.show', $user) }}">
                {{ $user->name }}
              </a>
            </p>
            <p class="text-[16px]">
              <i class="fa-solid fa-message text-gray-600"></i>
              <span>{{ $user->firstLanguage->name ?? $user->f_lang }}</span>
            </p>
            <p class="text-[15px]">
              <i class="fa-solid fa-pen text-gray-600"></i>
              <span>{{ $user->studyLanguage->name ?? $user->s_lang }}</span>
            </p>
          </div>
        </div>

        <form method="POST" action="{{ route('follow.store', $user) }}">
          @csrf
          <button
            class="bg-[#B178CC] text-white text-[13px] font-bold px-3 py-1 rounded-full hover:bg-[#a068ba] transition-all hover:scale-105 active:scale-95">
            Follow
          </button>
        </form>
      </div>
    </div>
  @empty
    <p class="text-gray-400 text-sm text-center py-4">
      No suggestions yet.
    </p>
  @endforelse

  </div>

</div>