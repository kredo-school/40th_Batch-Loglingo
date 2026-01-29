<div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-6 mb-6">
    <p class="text-gray-600 mb-4">Filter (Question written in )</p>
    
    <form action="{{-- $action --}}" method="GET">
        <div class="flex flex-wrap items-center gap-6">
            {{-- language check-box --}}
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" name="languages[]" value="ja" class="rounded border-gray-300 text-[#56A5E1] focus:ring-[#56A5E1]">
                <span class="text-gray-700">Japanese</span>
            </label>

            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" name="languages[]" value="zh" class="rounded border-gray-300 text-[#56A5E1] focus:ring-[#56A5E1]">
                <span class="text-gray-700">Chinese</span>
            </label>

            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" name="languages[]" value="es" class="rounded border-gray-300 text-[#56A5E1] focus:ring-[#56A5E1]">
                <span class="text-gray-700">Spanish</span>
            </label>

            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" name="languages[]" value="en" class="rounded border-gray-300 text-[#56A5E1] focus:ring-[#56A5E1]">
                <span class="text-gray-700">English</span>
            </label>

            {{-- Apply button --}}
            <div class="ml-auto">
                <button type="submit" class="bg-[#56A5E1] hover:bg-blue-600 text-white font-bold py-1 px-6 rounded-full shadow-md transition-transform hover:scale-[1.02] active:scale-95">
                    Apply
                </button>
            </div>
        </div>
    </form>
</div>