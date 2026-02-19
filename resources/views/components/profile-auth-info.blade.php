@props(['user'])

<!-- upper hedder -->
<div class="flex flex-wrap md:flex-nowrap items-start gap-6 relative">
    
    <!-- avatar -->
    <div class="shrink-0 flex flex-col items-center">
        @if(Auth::user()->avatar)
            <img src="{{ Auth::user()->avatar }}" alt="avatar"
                class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md">
        @else
            <i class="fa-solid fa-circle-user text-gray-400 text-[96px] leading-none"></i>
        @endif
    </div>

    <!-- user info -->
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $user->name }}</h1>
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

    <!-- count & octopus -->
    <div class="hidden lg:flex items-center relative pr-20">
        {{-- speach bubble --}}
        <div class="relative bg-white rounded-xl border border-gray-300 px-4 py-2">

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

            {{-- SHOW OR NOT / HOW TO COUNT??? --}}
            <div class="text-sm text-gray-700 space-y-0.5">
                <p>3 posts</p>
                <p>3 questions</p>
            </div>
        </div>

        <!-- octopus -->
        <div class="absolute right-0 bottom-[-12px]">
            <img src="{{ asset('images/octopus.png') }}" alt="octopus"
                class="w-24 h-24 object-contain">
        </div>
    </div>

    <!-- Edit Profile -->
    <div class="shrink-0 ml-auto">
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-1.5 border border-gray-600 rounded-xl text-gray-600 hover:bg-gray-600 hover:text-white transition-all duration-200">
            <i class="fa-solid fa-gear"></i>
            edit profile
        </a>
    </div>
</div> 


<!-- user intro -->
<div class="mt-6 pl-[120px]">
    <p class="text-gray-700 text-lg leading-relaxed break-words">
        {{ $user->introduction }}
    </p>
</div>