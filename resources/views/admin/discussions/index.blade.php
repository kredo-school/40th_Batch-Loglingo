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
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3 justify-center">
                            <img src="#" alt="user" class="w-10 h-10 rounded-full bg-gray-400 border shadow-sm">
                            <span class="font-medium text-gray-800">user name</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-center text-sm">user1@gmail.com</td>
                    <td class="px-6 py-4 text-gray-500 text-center text-sm">2026-01-30 00:47:34</td>
                    <td class="px-6 py-4 text-center"> <span class="text-gray-600">● </span> <span class="text-gray-800">Inactive</span></td>
                    <td class="px-6 py-4 text-right">
                        <div class="relative inline-block text-left" x-data="{ open: false }">
                            {{-- menu --}}
                            <button @click="open = !open" class="text-gray-400 hover:text-gray-600 transition-colors p-2">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>

                            {{-- dorp down menu --}}
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-md shadow-lg z-50 py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                    <i class="fa-regular fa-eye mr-2 w-4"></i> View Profile
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-blue-600 hover:bg-gray-50 flex items-center border-t border-gray-50">
                                    <i class="fa-solid fa-rotate mr-2 w-4"></i> Change Status
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- user example2--}}
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3 justify-center">
                            <img src="#" alt="user" class="w-10 h-10 rounded-full bg-gray-400 border shadow-sm">
                            <span class="font-medium text-gray-800">user name</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-center text-sm">user1@gmail.com</td>
                    <td class="px-6 py-4 text-gray-500 text-center text-sm">2026-01-30 00:47:34</td>
                    <td class="px-6 py-4 text-center"> <span class="text-green-600">● </span> <span class="text-gray-800">Active</span></td>
                    <td class="px-6 py-4 text-right text-gray-400 cursor-pointer hover:text-gray-600">
                        <i class="fa-solid fa-ellipsis"></i>
                    </td>
                </tr>




            </tbody>
        </table>

        {{-- next page (pagenation) --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
            <span>Showing 1 to 10 of 57 users</span>
            <div class="flex space-x-2">
                <button class="px-3 py-1 border border-gray-300 rounded hover:bg-white transition">Previous</button>
                <button class="px-3 py-1 bg-blue-500 text-white rounded shadow-sm">1</button>
                <button class="px-3 py-1 border border-gray-300 rounded hover:bg-white transition">2</button>
                <button class="px-3 py-1 border border-gray-300 rounded hover:bg-white transition">Next</button>
            </div>
        </div>
    </div>
</x-admin-layout>