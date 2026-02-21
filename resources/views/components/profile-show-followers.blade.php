@props(['user','followers'])


<div class="space-y-4">
  @forelse ($followers as $follower)
    
    <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-14 h-14 rounded-full shadow-sm overflow-hidden">
            @if($follower->avatar)
              <img src="{{ $follower->avatar }}" alt="avatar" class="w-full h-full object-cover">
            @else
              <i class="fa-solid fa-circle-user text-gray-400 text-[3.5rem] leading-none"></i>
            @endif
          </div>
          
          <div>
            <p class="text-[16px] font-bold">
              <a
                href="{{ route('profile.show', $follower) }}"
                class="hover:text-[#B178CC] transition-colors">
                {{ $follower->name }}
              </a>
            </p>
            <p class="text-[15px]"><i class="fa-solid fa-message text-gray-600"></i> 
            <span>{{ $follower->firstLanguage->name ?? $follower->f_lang }}</span>
            </p>
            <p class="text-[15px]"><i class="fa-solid fa-pen text-gray-600"></i> 
            <span>{{ $follower->studyLanguage->name ?? $follower->s_lang }}</span>
            </p>
          </div>
        </div>


        {{-- follow button  --}}
        {{-- version 1 : my(auth) profile is not shown on the follwer list, even if this user is followed by me --}}
        {{-- @auth
          @if(Auth::id() !== $follower->id)
              <div class="pt-4">
                  @if(Auth::user()->isFollowing($follower))
                      <!-- unfollow -->
                      <form method="POST" action="{{ route('follow.destroy', $follower) }}">
                          @csrf
                          @method('DELETE')
                          <button
                              class="px-10 py-1 bg-[#fda211] border border-[#fda211] text-white font-bold rounded-xl hover:bg-[#fdb211] border-[#fdb211] transition-all duration-300 active:translate-y-1">
                              Unfollow
                          </button>
                      </form>
                  @else
                      <!-- follow -->
                      <form method="POST" action="{{ route('follow.store', $follower) }}">
                          @csrf
                          <button
                              class="px-10 py-1 bg-white border-2 border-[#fda211] text-[#fda211] font-bold rounded-xl hover:border-[#fdbe11] hover:text-[#fdbe11] transition-all duration-300 active:translate-y-1">
                              Follow
                          </button>
                      </form>
                  @endif
              </div>
          @endif
        @endauth --}}




        {{-- version 2 : my(auth) profile is shown but follow button is disable to click, if this user is followed by me --}}
        @auth
          <div class="pt-4">
            @if(Auth::user()->isFollowing($follower))
              <!-- unfollow -->
              <form method="POST" action="{{ route('follow.destroy', $follower) }}">
                @csrf
                @method('DELETE')
                <button
                  @if(Auth::id() === $follower->id) disabled @endif
                  class="px-10 py-1 font-bold rounded-xl rounded-xl
                    {{ Auth::id() === $follower->id
                      ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                      : 'bg-[#fda211] text-white hover:bg-[#fdb211]'
                    }}">
                  Unfollow
                </button>
              </form>
            @else
              <!-- follow -->
              <form method="POST" action="{{ route('follow.store', $follower) }}">
                @csrf
                <button
                  @if(Auth::id() === $follower->id) disabled @endif
                  class="px-10 py-1 font-bold rounded-xl
                    {{ Auth::id() === $follower->id
                      ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                      : 'bg-white border-2 border-[#fda211] text-[#fda211] hover:border-[#fdbe11]'
                    }}">
                  Follow
                </button>
              </form>
            @endif
          </div>
        @endauth


      </div>
    </div>
  @empty
        <p class="text-gray-400 text-center py-10">
            No followers yet.
        </p>
    @endforelse
</div>
