<x-admin-layout>
    <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">report</th>
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">answer</th>
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">tag</th>
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">user name</th>
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">title</th>
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">created at</th>
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">status</th>
                    <th class="px-6 py-4 text-gray-400"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">

                  {{--★need to update later  $question->answers->count() --}}
                  {{--★need to update later  $question->reports->count() --}}
                @php
                $reports1 = 1;
                $answers1 = 2;
                @endphp

                {{-- user example1--}}
                @foreach($questions as $question)

                <tr x-data="{ active: false, open: false, showModal: false, reports: {{ $reports1 }} }"
                    :class="reports >= 10 ? 'bg-red-50 hover:bg-red-100' : 'hover:bg-gray-50'"
                    class="transition-colors">

                    {{-- report --}}
                    <td class="px-6 py-4 text-center font-bold" :class="reports >=10 ? 'text-red-600' : 'text-gray-600'" x-text="reports"></td>

                    {{-- answer --}}
                    <td class="px-6 py-4 text-center">
                        @if($answers1 > 0)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border-2 border-red-500 text-red-500">
                            answered
                        </span>

                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                            no answer
                        </span>
                        @endif
                    </td>

                    {{-- tag --}}
                    <td class="px-6 py-4 text-center">
                        <div class="flex flex-wrap justify-center gap-1">
                            @foreach($question->tags as $tag)
                            <span class="px-2 py-0.5 bg-blue-50 text-gray-600 text-[12px] font-bold rounded border border-blue-100">
                                {{ $tag->name }}
                            </span>
                            @endforeach
                            @if($question->tags->isEmpty())
                            <span class="text-gray-400 text-xs">No Tags</span>
                            @endif
                        </div>
                    </td>

                    {{-- username--}}
                    <td class="px-6 py-4 text-gray-600 text-center text-sm">{{$question->user->name }}</td>

                    {{-- title --}}
                    <td class="px-6 py-4 text-gray-500 text-center text-sm">{{ Str::limit($question->q_title, 25) }}</td>

                    {{-- created at --}}
                    <td class="px-6 py-4 text-gray-600 text-center text-sm">{{ $question->created_at->format('Y-m-d') }}</td>

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

                                {{--1 view profile --}}
                                <a href="{{ route('profile.show', $question->user->id )}}" class="group block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                    <i class="fa-regular fa-eye mr-3 w-5 text-center text-gray-400 group-hover:text-blue-500"></i> View Q&A
                                </a>

                                {{--2 Change status--}}
                                <button @click="showModal = true"
                                    class="group w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 flex items-center transition-colors focus:outline-none">
                                    <div class="mr-3 w-5 flex justify-center items-center">
                                        <span :class="active ? 'bg-red-500' : 'bg-green-500'"
                                            class="inline-block w-3 h-3 rounded-full"></span>
                                    </div>
                                    <span x-text="active ? 'Deactivate Q&A' : 'Activate Q&A'"></span>
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
                                    <span x-text="active ? 'Deactivate Q&A' : 'Activate Q&A'"></span>
                                </div>

                                {{-- Modal Body --}}
                                <div class="p-6 text-left">
                                    <p class="text-gray-700">Are you sure you want to <span x-text="active ? 'deactivate' : 'activate'" class="font-bold"></span> <span class="font-bold text-black">Q&A</span>?</p>
                                </div>

                                {{-- Modal Footer --}}
                                <div class="px-4 py-3 bg-gray-50 flex justify-end space-x-3">
                                    <button @click="showModal = false" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Cancel
                                    </button>
                                    <button @click="active = !active; showModal = false"
                                        :class="active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'"
                                        class="px-4 py-2 text-sm font-medium text-white rounded-md transition-colors">
                                        <span x-text="active ? 'Deactivate' : 'Activate'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>

                </tr>
                @endforeach

            </tbody>
        </table>

        <!-- pagenation -->
        <div class="mt-4">
            {{ $questions->links() }}
        </div>

</x-admin-layout>