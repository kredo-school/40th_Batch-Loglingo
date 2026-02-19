<x-admin-layout>

    @if (session('status'))
    <div class="mb-4 ms-6 text-green-600 font-bold">
        {{ session('status') }}
    </div>
    @endif


    <form action="{{ route('admin.tags.store') }}" method="POST" class="mb-6 p-6 bg-teal-50 rounded-[1rem] border border-teal-100">
        @csrf
        <h1 class="font-bold mb-4 text-[18px] text-gray-700">Add a new tag</h1>

        <div class="flex flex-wrap items-start gap-4">


            <!--Tag name  -->
            <div class="fex-1 max-w-xs">
                <input type="text"
                    name="name"
                    required
                    placeholder="Tag (e.g. English)"
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-[1rem] focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder:text-gray-400">
                @error('name')
                <p class="text-red-500 text-xs mt-1 ml-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- code name -->
            <div class="w-35">
                <input type="text"
                    name="code"
                    required
                    placeholder="Code (e.g. EN)"
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-[1rem] focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder:text-gray-400">
                @error('code')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Add button -->
            <button class="bg-[#3b82f6] hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-[1rem] flex items-center transition-colors">
                <span class="mr-2 text-[20px]">+</span>
                Add
            </button>

        </div>



    </form>


    <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">#</th>
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">name</th>
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">code</th>
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">count</th>
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">last updated</th>
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">status</th>
                    <th class="px-6 py-4 text-gray-400"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">

                @foreach($languages as $language)

                {{-- display tag--}}
                <tr x-data="{ active: {{ $language->status ? 'true' : 'false'}}, open: false, showModal: false}" class="hover:bg-gray-50 transition-colors">

                    {{-- number--}}
                    <td class="px-6 py-4 text-gray-600 text-center text-sm">{{ $language->id }}</td>

                    {{-- tag name--}}
                    <td class="px-6 py-4 text-gray-600 text-center text-sm">{{ $language->name}}</td>

                    {{-- tag code--}}
                    <td class="px-6 py-4 text-gray-600 text-center text-sm">
                        <span class="px-2 py-0.5 bg-blue-50 text-gray-600 text-[12px] font-bold rounded border border-blue-100">
                            {{ $language->code }}
                        </span>
                    </td>

                    {{-- count --}}
                    <td class="px-6 py-4 text-gray-500 text-center text-sm">{{ $language->questions_count }}</td>

                    {{-- last updated --}}
                    <td class="px-6 py-4 text-gray-500 text-center text-sm">{{ $language->updated_at ? $language->updated_at->format('Y-m-d H:i') : 'no update' }}</td>


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


                                {{-- Change status--}}
                                <button @click="showModal = true"
                                    class="group w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 flex items-center transition-colors focus:outline-none">
                                    <div class="mr-3 w-5 flex justify-center items-center">
                                        <span :class="active ? 'bg-red-500' : 'bg-green-500'"
                                            class="inline-block w-3 h-3 rounded-full"></span>
                                    </div>
                                    <span x-text="active ? 'Deactivate tag' : 'Activate tag'"></span>
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
                                    <span x-text="active ? 'Deactivate Tag' : 'Activate Tag'"></span>
                                </div>

                                {{-- Modal Body --}}
                                <div class="p-6 text-left">
                                    <p class="text-gray-700">Are you sure you want to <span x-text="active ? 'deactivate' : 'activate'" class="font-bold"></span> <span class="font-bold text-black">tag</span>?</p>
                                </div>

                                {{-- Modal Footer --}}
                                <div class="px-4 py-3 bg-gray-50 flex justify-end space-x-3">

                                    <button @click="showModal = false" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Cancel
                                    </button>

                                    <form action=" {{ route('admin.languages.toggle', $language->id )}}" method="POST">
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

                </tr>


                @endforeach
            </tbody>
        </table>

        {{-- next page (pagenation) --}}
        <div class="mt-4">
            {{ $languages->links() }}
        </div>

</x-admin-layout>