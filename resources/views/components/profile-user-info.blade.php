@props([
    'user',
    'year',
    'month',
    'daysInMonth',
    'startDayOfWeek',
    'activityData'
])

<!-- upper hedder -->
<div class="grid grid-cols-1 md:grid-cols-[auto_1fr_auto] gap-x-8 gap-y-6 items-center md:items-start text-center md:text-left">

    <div class="flex flex-col items-center gap-4"> 
    
        <!-- avatar -->
        <div class="shrink-0">
            @if($user->avatar)
                <img src="{{ $user->avatar }}" alt="avatar"
                    class="w-24 h-24 rounded-full object-cover">
            @else
                <i class="fa-solid fa-circle-user text-gray-400 text-[96px] leading-none"></i>
            @endif
        </div>
        {{-- follow / unfollow --}}
        @auth
            @if(Auth::id() !== $user->id)
                <div class="pt-4">
                    @if(Auth::user()->isFollowing($user))
                        {{-- unfollow --}}
                        <form method="POST" action="{{ route('follow.destroy', $user) }}">
                            @csrf
                            @method('DELETE')
                            <button
                                class="px-6 py-1 bg-[#fda211] border border-[#fda211] text-white font-bold rounded-xl hover:bg-[#fdb211] border-[#fdb211] transition-all duration-300 active:translate-y-1">
                                Unfollow
                            </button>
                        </form>
                    @else
                        {{-- follow --}}
                        <form method="POST" action="{{ route('follow.store', $user) }}">
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

    <div class="space-y-4"> 
        <!-- user info -->
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2 whitespace-nowrap">{{ $user->name }}</h1>
            <div class="flex flex-col md:flex-row items-center md:items-start justify-center md:justify-start gap-2 md:gap-4 text-gray-600">
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-comment text-lg"></i>
                    <span class="text-md">{{ $user->firstLanguage->name ?? $user->f_lang}}</span> 
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-pen text-md"></i>
                    <span class="text-md">{{ $user->studyLanguage->name ?? $user->s_lang }}</span>
                </div>                                   
            </div>        
        </div>

        <!-- intro -->
        <div class="pt-8 border-t border-gray-100 md:border-none">
            <p class="text-gray-700 text-md leading-relaxed break-words">
                {{ $user->introduction }}
            </p>
        </div>
    </div>

    <div class="flex flex-col items-center md:items-end gap-3 w-full mx-auto md:mr-0">
        <!-- count streak & octopus -->
        <div class="flex items-end justify-center md:justify-end gap-0 -mt-7">
            @php
                $todayDone = $user->last_activity_date === now()->toDateString();
            @endphp

            {{-- speach bubble --}}
            <div class="relative bg-white rounded-xl border border-gray-300 px-3 py-2 min-h-[60px] max-w-[260px]">

                <!-- triangle -->
                <span class="absolute top-1/2 -right-2 -translate-y-1/2
                            w-0 h-0
                            border-t-8 border-b-8 border-l-8
                            border-t-transparent border-b-transparent border-l-gray-300"></span>

                <span class="absolute top-1/2 -right-[6px] -translate-y-1/2
                            w-0 h-0
                            border-t-6 border-b-6 border-l-6
                            border-t-transparent border-b-transparent border-l-white"></span>

                <!-- inside & count -->
                  <div class="text-[11px] text-gray-700 space-y-0.5 text-left leading-tight whitespace-nowrap">
                    <p><i class="fa-solid fa-fire text-red-500"></i> I've studied for 
                    <span class="font-semibold">{{ $user->current_streak }}</span> 
                    <span>
                            @if($user->current_streak === 1)
                            day!
                            @else
                            days!
                            @endif
                        </span>
                    </p>
                    <p><i class="fa-solid fa-trophy text-yellow-500"></i> 
                        My best is 
                        <span class="font-semibold">{{ $user->longest_streak }} </span> 
                        <span>
                            @if($user->longest_streak === 1)
                            day!
                            @else
                            days!
                            @endif
                        </span>
                    </p>
                    <p class="text-[11px] text-gray-600">
                        <i class="fa-regular fa-face-grin"></i> Let's study together!
                    </p>

                </div>
            </div>

            <!-- octopus -->
            @php
                $streak = $user->current_streak;

                $character = match(true) {
                    $streak >= 30 => 'king-octopus.png',
                    $streak >= 14 => 'zoomed-octopus.png',
                    $streak >= 7 => 'princess-octopus.png',
                    default => 'baby-octopus.png'
                    
                };
            @endphp

            <div class="flex-none">
                <img src="{{ asset('images/'.$character) }}" alt="octopus"
                    class="w-24 h-24 object-contain animate-pulsetransition transform hover:scale-110 pt-3">
            </div>
        </div>    

        <!-- calendar -->
        <div class="w-[220px] bg-gray-50 rounded-lg p-2 md:p-0 md:bg-transparent">
            <x-activity-calendar
                :year="$year"
                :month="$month"
                :daysInMonth="$daysInMonth"
                :startDayOfWeek="$startDayOfWeek"
                :activityData="$activityData"
            />
        </div>
    </div>
</div>