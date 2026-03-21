<x-admin-layout>
    <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-6">

        {{-- filter function --}}
        <div class="mb-6">
            <form action="{{ route('admin.posts.index') }}" method="GET" class="flex flex-wrap gap-3 items-end">

                {{-- search bar --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Keywords..." class="form-control w-64 border-gray-300 rounded-md shadow-sm text-sm">
                </div>

                {{-- status filter --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Status</label>
                    <select name="status" class="form-control border-gray-300 rounded-md shadow-sm text-sm" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Only</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                    </select>
                </div>

                {{-- Sort by --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Sort By</label>
                    <select name="sort" class="form-control border-gray-300 rounded-md shadow-sm text-sm" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                        <option value="reports" {{ request('sort') == 'reports' ? 'selected' : '' }}>Most Reported</option>
                    </select>
                </div>

                {{-- apply button --}}
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-bold transition-colors">
                        Apply
                    </button>
                    @if(request()->anyFilled(['search', 'status', 'sort']))
                    <a href="{{ route('admin.posts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-bold transition-colors">
                        Reset
                    </a>
                    @endif
                </div>
            </form>

            <div class="mb-2 text-sm text-gray-500 font-medium">
                @if($posts->total() > 1)
                Showing {{ $posts->firstItem() }} - {{ $posts->lastItem() }} of {{ $posts->total() }} posts
                @elseif($posts->total() === 1)
                Showing 1 post
                @else
                No posts found
                @endif
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-6 py-4 font-bold text-gray-700 text-center">report</th>
                        <th class="px-6 py-4 font-bold text-gray-700 text-center">tag</th>
                        <th class="px-6 py-4 font-bold text-gray-700 text-center">user name</th>
                        <th class="px-6 py-4 font-bold text-gray-700 text-center">date</th>
                        <th class="px-6 py-4 font-bold text-gray-700 text-center">title</th>
                        <th class="px-6 py-4 font-bold text-gray-700 text-center">created at</th>
                        <th class="px-6 py-4 font-bold text-gray-700 text-center">status</th>
                        <th class="px-6 py-4 text-gray-400"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">


                    @foreach($posts as $post)

                    @php
                    $totalReports = $post->total_reports_count;
                    @endphp

                    {{-- display post--}}
                    <tr x-data="{ active: {{ $post->status ? 'true' : 'false'}}, open: false, showModal: false, showViewModal: false, reports: {{ $totalReports }} }"
                        :class="reports >= 10 ? 'bg-red-50 hover:bg-red-100' : 'hover:bg-gray-50'"
                        class="transition-colors">

                        {{-- report --}}
                        <td class="px-6 py-4 text-center font-bold" :class="reports >=10 ? 'text-red-600' : 'text-gray-600'" x-text="reports"></td>

                        {{-- tag --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-wrap justify-center gap-1">
                                @forelse($post->tags as $tag)
                                <x-language-badge :language="$tag" :icon="false" />
                                @empty
                                <span class="text-[12px] text-gray-400">No Tags</span>
                                @endforelse
                            </div>
                        </td>


                        {{-- username--}}
                        <td class="px-6 py-4 text-gray-600 text-center text-sm">{{$post->user->name }}</td>

                        {{-- date --}}
                        <td class="px-6 py-4 text-gray-600 text-center text-sm">{{ $post->event_date }}</td>

                        {{-- title --}}
                        <td class="px-6 py-4 text-gray-500 text-center text-sm">{{ Str::limit($post->p_title, 25) }}</td>

                        {{-- created at --}}
                        <td class="px-6 py-4 text-gray-600 text-center text-sm">{{ $post->created_at->format('Y-m-d') }}</td>

                        {{-- status--}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <span :class="active ? 'text-green-600' : 'text-gray-400'">●</span>
                                <span class="text-gray-800" x-text="active ? 'Active' : 'Inactive'"></span>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="relative inline-block text-left">

                                {{-- menu button --}}
                                <button @click="open = !open" class="text-gray-400 hover:text-gray-600 transition-colors p-2">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>

                                {{-- dorp down menu --}}
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-md shadow-lg z-50 py-1">

                                    {{--1 view post --}}
                                    <button @click="showViewModal = true; open = false" class="group w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                        <i class="fa-regular fa-eye mr-3 w-5 text-center text-gray-400 group-hover:text-blue-500"></i> View Post
                                    </button>

                                    {{--2 Change status--}}
                                    <button @click="showModal = true"
                                        class="group w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 flex items-center transition-colors focus:outline-none">
                                        <div class="mr-3 w-5 flex justify-center items-center">
                                            <span :class="active ? 'bg-red-500' : 'bg-green-500'"
                                                class="inline-block w-3 h-3 rounded-full"></span>
                                        </div>
                                        <span x-text="active ? 'Deactivate post' : 'Activate post'"></span>
                                    </button>

                                </div>
                            </div>
                        </td>



                        {{-- --- Confirmation Modal --- --}}
                        <template x-teleport="body">
                            <div x-show="showModal"
                                class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-black bg-opacity-50"
                                x-cloak>

                                {{-- Modal Content --}}
                                <div @click.away="showModal = false"
                                    class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden transform transition-all border border-gray-200">

                                    {{-- Modal Header --}}
                                    <div :class="active ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600'"
                                        class="px-4 py-3 border-b flex items-center font-bold">
                                        <i :class="active ? 'fa-solid fa-ban' : 'fa-solid fa-circle-check'" class="mr-2"></i>
                                        <span x-text="active ? 'Deactivate Post' : 'Activate Post'"></span>
                                    </div>

                                    {{-- Modal Body --}}
                                    <div class="p-6 text-left">
                                        <p class="text-gray-700">Are you sure you want to <span x-text="active ? 'deactivate' : 'activate'" class="font-bold"></span> <span class="font-bold text-black">post</span>?</p>
                                    </div>

                                    {{-- Modal Footer --}}
                                    <div class="px-4 py-3 bg-gray-50 flex justify-end space-x-3">

                                        <button @click="showModal = false" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                            Cancel
                                        </button>

                                        <form action="{{ route('admin.posts.toggle' , $post->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                :class="active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'"
                                                class="px-4 py-2 text-sm font-medium text-white rounded-md transition-colors">
                                                <span x-text="active ? 'Deactivate' : 'Activate'"></span>
                                            </button>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </template>





                        {{-- --- View Detail Modal (Posts) --- --}}
                        <template x-teleport="body">
                            <div x-show="showViewModal"
                                class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60"
                                x-cloak>
                                <div @click.away="showViewModal = false"
                                    class="bg-[#F9FAFB] rounded-[1.5rem] shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col transform transition-all">

                                    {{-- Modal Header --}}
                                    <div class="px-8 py-4 bg-white border-b flex justify-between items-center">
                                        <h3 class="font-extrabold text-xl text-gray-800 italic">LogLingo <span class="text-gray-400 font-normal ml-2 text-sm not-italic">| Inspection mode</span></h3>
                                        <button @click="showViewModal = false" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
                                            <i class="fa-solid fa-xmark text-gray-400"></i>
                                        </button>
                                    </div>

                                    {{-- Modal Body --}}
                                    <div class="p-8 overflow-y-auto custom-scrollbar">

                                        {{-- Post Part --}}
                                        <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-8 mb-6 relative">

                                            {{-- Post Report Count --}}
                                            <div class="absolute top-4 right-8 flex items-center space-x-1 px-3 py-1 bg-red-50 text-red-600 rounded-full border border-red-100">
                                                <i class="fa-solid fa-flag text-xs"></i>
                                                <span class="text-xs font-bold">Reports: {{ $post->reports_count ?? $post->reports->count() }}</span>
                                            </div>

                                            <div class="flex items-start space-x-4 w-full mb-4">
                                                {{-- avatar --}}
                                                @if($post->user->avatar)
                                                <img src="{{ $post->user->avatar }}" alt="user" class="w-16 h-16 rounded-full object-cover">
                                                @else
                                                <i class="fa-solid fa-circle-user text-gray-400 text-[60px] leading-none"></i>
                                                @endif

                                                <div class="flex-1 min-w-0">
                                                    {{-- username --}}
                                                    <div class="flex justify-between items-start mb-1">
                                                        <h3 class="font-bold text-lg text-gray-800">{{ $post->user->name }}</h3>
                                                    </div>

                                                    {{-- post titile --}}
                                                    <h2 class="text-[22px] font-extrabold text-gray-900 mb-2 leading-tight break-all">{{ $post->p_title }}</h2>

                                                    {{-- post footer --}}
                                                    <div class="flex items-center space-x-4 text-[13px] text-gray-400 mb-3">
                                                        {{-- post date --}}
                                                        <span><i class="fa-regular fa-calendar mr-1"></i>Event: {{ $post->event_date }}</span>
                                                        <span><i class="fa-regular fa-clock mr-1"></i>Posted: {{ $post->created_at->diffForHumans() }}</span>

                                                        {{-- post tag --}}
                                                        <span>@forelse($post->tags as $tag)
                                                            <x-language-badge :language="$tag" :icon="false" />
                                                            @empty
                                                            <span class="text-[12px] text-gray-400">No Tags</span>
                                                            @endforelse</span>
                                                    </div>

                                                    <div class="text-gray-700 leading-relaxed text-base break-words pt-4 border-t border-gray-50">
                                                        {!! nl2br(e($post->p_content)) !!}
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="mt-4 flex justify-end">
                                                <a href="{{ route('posts.show', $post->id) }}" class="text-xs text-[#B178CC] font-bold hover:underline">
                                                    View full post page <i class="fa-solid fa-arrow-right ml-1"></i>
                                                </a>
                                            </div>
                                        </div>

                                        {{-- Comments Part --}}
                                        <div class="space-y-4">
                                            <h4 class="px-4 font-bold text-gray-500 text-sm uppercase tracking-widest flex items-center">
                                                <i class="fa-solid fa-comments mr-2"></i> Comments ({{ $post->comments->count() }})
                                            </h4>

                                            @forelse($post->comments as $comment)
                                            <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-6 flex items-start space-x-4 mx-4 relative">
                                                {{-- Comment Report Count --}}
                                                <div class="absolute top-4 right-6 flex items-center space-x-1 px-2 py-0.5 bg-red-50 text-red-500 rounded-full border border-red-100">
                                                    <i class="fa-solid fa-flag text-[10px]"></i>
                                                    <span class="text-[11px] font-bold">{{ $comment->reports_count ?? $comment->reports->count() }}</span>
                                                </div>

                                                <!-- comment avatar -->
                                                @if($comment->user->avatar)
                                                <img src="{{ $comment->user->avatar }}" alt="user" class="w-12 h-12 rounded-full object-cover">
                                                @else
                                                <i class="fa-solid fa-circle-user text-gray-400 text-[45px] leading-none"></i>
                                                @endif

                                                <div class="flex-1">
                                                    <div class="flex justify-between items-center mb-2 pr-16">
                                                        <div class="flex items-center space-x-2">
                                                            <h4 class="font-bold text-gray-800 text-[15px]">{{ $comment->user->name }}</h4>
                                                            <span class="text-[12px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-gray-600 text-sm leading-relaxed break-all whitespace-pre-wrap">{!! nl2br(e($comment->c_content)) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="text-center py-10">
                                                <p class="text-gray-400 italic">No comments yet.</p>
                                            </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    {{-- Modal Footer --}}
                                    <div class="px-8 py-4 bg-white border-t flex justify-end">
                                        <button @click="showViewModal = false" class="px-6 py-2 bg-gray-900 text-white rounded-full text-sm font-bold hover:bg-gray-800 transition-all shadow-md">
                                            Finish Review
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>



                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{-- next page (pagenation) --}}
        <div class="mt-4">
            {{ $posts->links() }}
        </div>


    </div>

</x-admin-layout>