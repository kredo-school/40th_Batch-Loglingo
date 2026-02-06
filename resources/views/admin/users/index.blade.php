<x-admin-layout>
    <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">user name</th>
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">e-mail</th>
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">created-at</th>
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">status</th>
                    <th class="px-6 py-4 text-gray-400"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">

                {{-- user example1--}}
                <tr x-data="{ active: true, open: false, showModal: false}" class="hover:bg-gray-50 transition-colors">

                    {{-- username--}}
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3 justify-center">
                            <img src="#" alt="user" class="w-10 h-10 rounded-full bg-gray-400 border shadow-sm">
                            <span class="font-medium text-gray-800">user name</span>
                        </div>
                    </td>

                    {{-- e-mail--}}
                    <td class="px-6 py-4 text-gray-600 text-center text-sm">user1@gmail.com</td>

                    {{-- created-at --}}
                    <td class="px-6 py-4 text-gray-500 text-center text-sm">2026-01-30 00:47:34</td>

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
                                <a href="#" class="group block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                    <i class="fa-regular fa-eye mr-3 w-5 text-center text-gray-400 group-hover:text-blue-500"></i> View Profile
                                </a>

                                {{--2 Change status--}}
                                <button @click="showModal = true"
                                    class="group w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 flex items-center transition-colors focus:outline-none">
                                    <div class="mr-3 w-5 flex justify-center items-center">
                                        <span :class="active ? 'bg-red-500' : 'bg-green-500'"
                                            class="inline-block w-3 h-3 rounded-full"></span>
                                    </div>
                                    <span x-text="active ? 'Deactivate user1' : 'Activate user1'"></span>
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
                                    <i :class="active ? 'fa-solid fa-user-slash' : 'fa-solid fa-user-check'" class="mr-2"></i>
                                    <span x-text="active ? 'Deactivate User' : 'Activate User'"></span>
                                </div>

                                {{-- Modal Body --}}
                                <div class="p-6 text-left">
                                    <p class="text-gray-700">Are you sure you want to <span x-text="active ? 'deactivate' : 'activate'" class="font-bold"></span> <span class="font-bold text-black">user1</span>?</p>
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

       
            </tbody>
        </table>

        {{-- next page (pagenation) --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">


            <div class="flex items-center justify-between">
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700 class=" leading-5">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">57</span> results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <button class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <button class="relative inline-flex items-center px-4 py-2 border border-blue-500 bg-blue-50 text-sm font-medium text-blue-600 z-10">1</button>
                            <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</button>
                            <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">3</button>
                            <button class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>