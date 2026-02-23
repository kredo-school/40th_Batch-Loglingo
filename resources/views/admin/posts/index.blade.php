<x-admin-layout>
    <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100">
        <table class="w-full text-left border-collapse">
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
                            @foreach($post->tags as $tag)
                            <span class="px-2 py-0.5 bg-blue-50 text-gray-600 text-[12px] font-bold rounded border border-blue-100">
                                {{ $tag->code }}
                            </span>
                            @endforeach
                            @if($post->tags->isEmpty())
                            <span class="text-gray-400 text-xs">No Tags</span>
                            @endif
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
                                    <h3 class="font-extrabold text-xl text-gray-800 italic">LogLingo <span class="text-gray-400 font-normal ml-2 text-sm not-italic">| Post Inspection</span></h3>
                                    <button @click="showViewModal = false" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
                                        <i class="fa-solid fa-xmark text-gray-400"></i>
                                    </button>
                                </div>

                                {{-- Modal Body --}}
                                <div class="p-8 overflow-y-auto custom-scrollbar">

                                    {{-- QuestionにあたるPost部分 --}}
                                    <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-8 mb-6 relative">
                                        {{-- Post Report Count --}}
                                        <div class="absolute top-4 right-8 flex items-center space-x-1 px-3 py-1 bg-red-50 text-red-600 rounded-full border border-red-100">
                                            <i class="fa-solid fa-flag text-xs"></i>
                                            <span class="text-xs font-bold">Reports: {{ $post->reports_count ?? $post->reports->count() }}</span>
                                        </div>

                                        <div class="flex items-start space-x-4 w-full mb-4">
                                            <img src="{{ $post->user->avatar ?? asset('images/baby-octopus.png') }}" class="w-16 h-16 rounded-full object-cover shadow-sm">
                                            <div class="flex-1">
                                                <div class="flex justify-between items-center mb-1">
                                                    <h3 class="font-bold text-lg text-gray-800">{{ $post->user->name }}</h3>
                                                </div>
                                                <h2 class="text-[22px] font-extrabold text-gray-900 mb-2 leading-tight">{{ $post->p_title }}</h2>
                                                <div class="flex items-center space-x-4 text-[13px] text-gray-400">
                                                    <span><i class="fa-regular fa-calendar mr-1"></i>Event: {{ $post->event_date }}</span>
                                                    <span><i class="fa-regular fa-clock mr-1"></i>Posted: {{ $post->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="mt-2 flex flex-wrap gap-2">
                                                    @foreach($post->tags as $tag)
                                                    <span class="text-[11px] px-2 py-0.5 bg-blue-50 rounded text-blue-600 border border-blue-100 font-bold uppercase">
                                                        #{{ $tag->code }}
                                                    </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-gray-700 leading-relaxed text-base break-words pt-4 border-t border-gray-50">
                                            {!! nl2br(e($post->p_content)) !!}
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

                                            <img src="{{ $comment->user->avatar ?? asset('images/baby-octopus.png') }}" class="w-12 h-12 rounded-full object-cover">
                                            <div class="flex-1">
                                                <div class="flex justify-between items-center mb-2 pr-16">
                                                    <div class="flex items-center space-x-2">
                                                        <h4 class="font-bold text-gray-800 text-[15px]">{{ $comment->user->name }}</h4>
                                                        <span class="text-[12px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                                <div class="text-gray-600 text-sm leading-relaxed">
                                                    {!! nl2br(e($comment->body)) !!}
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

        {{-- next page (pagenation) --}}
        <div class="mt-4">
            {{ $posts->links() }}
        </div>


    </div>

</x-admin-layout>