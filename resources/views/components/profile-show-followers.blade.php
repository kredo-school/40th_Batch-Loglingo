@props(['user','followers'])

{{-- TODO: REPLACE user info  forelse --}}
<div class="space-y-4">
  @forelse ($followers as $follower)
    
    <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-14 h-14 rounded-full bg-pink-400 border-2 border-white shadow-sm overflow-hidden">
            <img src="#" alt="user" class="w-full h-full object-cover">
          </div>
          <div>
            <p class="text-[16px] font-bold">
            {{-- User name A --}}
            {{$follower->name }}
            </p>
            <p class="text-[15px]"><i class="fa-solid fa-message text-gray-600"></i> 
            {{-- <span>Japanese</span> --}}
            <span>{{ $follower->firstLanguage->name ?? $followerr->f_lang }}</span>
            </p>
            <p class="text-[15px]"><i class="fa-solid fa-pen text-gray-600"></i> 
            {{-- <span>English</span> --}}
            <span>{{ $follower->studyLanguage->name ?? $follower->s_lang }}</span>
            </p>
          </div>
        </div>


        {{-- follow button  --}}
        {{-- <button class="px-10 py-1 bg-[#fda211] border border-[#fda211] text-white font-bold rounded-xl hover:bg-[#fdb211] border-[#fdb211] transition-all duration-300 active:translate-y-1">
          Follow
        </button> --}}
        {{-- TODO: REPLACE TO BELOW --}}
        @auth
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
        @endauth


      </div>
    </div>
  @empty
        <p class="text-gray-400 text-center py-10">
            Not following yet.
        </p>
    @endforelse
</div>
