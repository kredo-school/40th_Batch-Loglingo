
<div class="space-y-4">

    @forelse ($posts as $post)


    <!-- post card-->
    <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-5 flex space-x-4 transition-all hover:border-gray-200">

        <!-- user icon  -->
        <div class="flex-shrink-0">
            @if ($post->user->avatar)
            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-white shadow-sm">
                <img src="{{$post->user->avatar}}" alt="user avatar" class="w-full h-full object-cover">
            </div>
            @else
            <i class="fa-solid fa-circle-user text-gray-400 text-[64px] leading-none"></i>
            @endif
        </div>

        <!--  content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!--  header -->
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-bold text-gray-700">{{ $post->user->name }}</h3>
                </a>
                <span class="text-gray-400 text-[13px] underline"> {{ $post->event_date->format('m/d/Y') }}</span>

            </div>

            <!--  tytle & body  -->
            <a href="{{ route('posts.show',  $post->id) }}" class="group block mt-1 min-w-0">
                <!--  title -->
                <h4 class="text-xl font-extrabold text-gray-900 leading-tight mb-1 group-hover:underline decoration-gray-400 truncate w-full">
                    {{ $post->p_title }}
                </h4>
                <!-- body -->
                <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed break-words">
                    {{ $post->p_content }}
                </p>
            </a>

            <!-- tag & report -->
            <div class="flex justify-between items-center mt-4 pt-3 border-t border-gray-50">
                <p class="text-[12px] text-gray-400">{{ $post->created_at->diffForHumans() }} </p>


                <div class="flex items-center space-x-3">
                    {{-- replies --}}
                    <span class="text-[12px] text-gray-400 mr-2">
                        <i class="fa-regular fa-comment-dots mr-1"></i> {{ $post->comments->count() }}
                    </span>


                    {{-- bookmark --}}
                    <x-bookmark-button :model="$post" />


                    {{-- tag --}}
                    @forelse($post->tags as $tag)
                    <span class="text-[12px] px-2 py-1 bg-gray-50 rounded-md text-gray-600 font-bold border border-gray-100">
                        <i class="fa-solid fa-tag mr-1 text-gray-400"></i> {{ $tag->code }}
                    </span>
                    @empty
                    <span class="text-[12px] text-gray-400">No Tags</span>
                    @endforelse


                    {{-- report system --}}
                    @php
                    $reportedByMe = auth()->check()
                    ? $post->reports()
                    ->where('user_id', auth()->id())
                    ->exists()
                    : false;
                    @endphp

                    <x-report-button :model="$post" :reported="$reportedByMe" />


                </div>
            </div>
        </div>

    </div>
    @empty
    <p class="text-gray-400 text-center py-10">
        No posts yet.
    </p>
    @endforelse
</div>