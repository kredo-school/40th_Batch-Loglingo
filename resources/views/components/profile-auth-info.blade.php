@props([
    'user',
    'year',
    'month',
    'daysInMonth',
    'startDayOfWeek',
    'activityData'
])

<!-- upper hedder -->
<div class="flex flex-wrap md:flex-nowrap items-start gap-6 relative">
    
    <!-- avatar -->
    <div class="shrink-0 flex flex-col items-center">
        @if(Auth::user()->avatar)
            <img src="{{ Auth::user()->avatar }}" alt="avatar"
                class="w-24 h-24 rounded-full object-cover">
        @else
            <i class="fa-solid fa-circle-user text-gray-400 text-[96px] leading-none"></i>
        @endif
    </div>   

    <!-- user info -->
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 whitespace-nowrap">{{ $user->name }}</h1>
        <div class="space-y-1 text-gray-600">
            <div class="flex items-center gap-2">
                <i class="fa-regular fa-comment text-md"></i>
                <span class="text-md">{{  
                $user->firstLanguage->name ?? $user->f_lang }}</span> 
            </div>
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-pen text-md"></i>
                <span class="text-md">{{ $user->studyLanguage->name ?? $user->s_lang }}</span>
            </div>                                   
        </div>
        
    </div>

    <!-- count streak & octopus -->
    @php
        $todayDone = $user->last_activity_date === now()->toDateString();
    @endphp

    <div class="flex flex-wrap items-center gap-4 ml-auto shrink-0">    
        <div class="flex items-center relative pr-20">
            {{-- speach bubble --}}
            <div class="relative bg-white rounded-xl border border-gray-300 px-4 py-2 min-w-[180px]">

                <!-- triangle -->
                <span class="absolute top-1/2 -right-2 -translate-y-1/2
                            w-0 h-0
                            border-t-8 border-b-8 border-l-8
                            border-t-transparent border-b-transparent border-l-gray-300"></span>

                <!-- inside & count -->
                <span class="absolute top-1/2 -right-[6px] -translate-y-1/2
                            w-0 h-0
                            border-t-6 border-b-6 border-l-6
                            border-t-transparent border-b-transparent border-l-white"></span>

                
                <div class="text-sm text-gray-700 space-y-0.5 whitespace-nowrap">
                    <p><i class="fa-solid fa-fire text-red-500"></i> You've studied for 
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
                        Your best is 
                        <span class="font-semibold">{{ $user->longest_streak }} </span> 
                        <span>
                            @if($user->longest_streak === 1)
                            day!
                            @else
                            days!
                            @endif
                        </span>
                    </p>

                    @if($todayDone)
                        <p class="text-green-600 text-xs animate-pulse">
                            <i class="fa-solid fa-thumbs-up"></i> Your streak saved today!
                        </p>
                        @else
                        <p class="text-orange-500 text-xs animate-pulse underline">
                            <i class="fa-solid fa-bolt"></i> Don't forget today's log!
                        </p>                    
                    @endif
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

            <div class="absolute right-0 -bottom-3 md:-bottom-2">
                <img src="{{ asset('images/'.$character) }}" alt="octopus"
                    class="w-24 h-24 object-contain animate-pulsetransition transform hover:scale-110 ps-3">
            </div>
        </div>

        <!-- Edit Profile -->
        {{-- <div class="shrink-0 ml-auto">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-1.5 border border-gray-600 rounded-xl text-gray-600 hover:bg-gray-600 hover:text-white transition-all duration-200">
                <i class="fa-solid fa-gear"></i>
                edit profile
            </a>
        </div> --}}
    </div>
</div> 

<div class="mt-6 grid grid-cols-[auto_1fr_auto] gap-8 items-start">

    <!-- edit button -->
    <div>
        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-2 px-2 py-2 text-xs border border-gray-600 rounded-xl text-gray-600 hover:bg-gray-600 hover:text-white transition whitespace-nowrap">
            <i class="fa-solid fa-gear"></i>
            edit profile
        </a>
    </div>

    <!-- intro -->
    <div>
        <p class="text-gray-700 text-lg leading-relaxed break-words">
            {{ $user->introduction }}
        </p>
    </div>

    <!-- calendar -->
    <div class="w-[180px]">
        <x-activity-calendar
            :year="$year"
            :month="$month"
            :daysInMonth="$daysInMonth"
            :startDayOfWeek="$startDayOfWeek"
            :activityData="$activityData"
        />
    </div>

</div>
