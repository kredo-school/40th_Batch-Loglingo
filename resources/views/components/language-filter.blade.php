@props(['languages', 'action', 'label' => '(Question written in)'])

<div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-6 mb-6">

    <form action="{{ $action }}" method="GET">

        <div class="flex flex-wrap items-center gap-4">
            {{-- Search Bar --}}
            <div class="relative flex-1 min-w-[240px]">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search title or content..."
                    class="w-full pl-10 pr-4 py-2 border-gray-200 rounded-full text-sm focus:ring-[#56A5E1] focus:border-[#56A5E1]">
            </div>

            {{-- Resolved/Answered Filter --}}

            @unless(request()->routeIs('search'))
            <div class="min-w-[150px]">
                <select name="resolved" class="w-full border-gray-200 rounded-full text-sm py-2 px-4 focus:ring-[#56A5E1]" onchange="this.form.submit()">

                    @if(request()->routeIs('questions.*'))
                    {{-- Question pages --}}
                    <option value="">All Questions</option>
                    <option value="false" {{ request('resolved') === 'false' ? 'selected' : '' }}>Unanswered</option>
                    <option value="true" {{ request('resolved') === 'true' ? 'selected' : '' }}>Answered</option>

                    @elseif(request()->routeIs('discussions.*'))
                    {{-- Discussion pages --}}
                    <option value="">All Issues</option>
                    <option value="false" {{ request('resolved') === 'false' ? 'selected' : '' }}>Unresolved</option>
                    <option value="true" {{ request('resolved') === 'true' ? 'selected' : '' }}>Resolved</option>
                    @endif

                </select>
            </div>
            @endunless

        </div>

        <hr class="border-gray-50">


        {{-- language check-box --}}
        <div class="flex flex-wrap items-center gap-4">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mr-2">{{ $label }}</p>

            <div class="flex flex-wrap gap-4">
                @foreach($languages as $language)
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="languages[]" value="{{ $language->id }}"
                        {{ is_array(request('languages')) && in_array($language->id, request('languages')) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-[#56A5E1] focus:ring-[#56A5E1]">
                    <span class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ $language->name }}</span>
                </label>
                @endforeach
            </div>

            {{-- Apply button --}}
            <div class="ml-auto flex gap-2 mt-2">
                @if(request()->anyFilled(['search', 'resolved', 'languages']))
                <a href="{{ $action }}" class="text-sm text-gray-400 hover:text-gray-600 self-center mr-2">Reset</a>
                @endif
                <button type="submit" class="bg-[#56A5E1] hover:bg-blue-600 text-white font-bold py-1 px-6 rounded-full transition-transform hover:scale-[1.02] active:scale-95">
                    Apply
                </button>
            </div>
        </div>

    </form>
</div>