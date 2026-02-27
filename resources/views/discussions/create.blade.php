<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-6">
        <h2 class="text-2xl font-bold mb-6">Start a New Discussion</h2>

        <form action="{{ route('discussions.store') }}" method="POST" class="space-y-6">
            @csrf

            @if($question)
            <input type="hidden" name="question_id" value="{{ $question->id }}">
            <div class="bg-purple-50 border border-purple-100 rounded-xl p-4 mb-6">

                <div class="flex justify-between items-start mb-2">
                    <p class="text-[10px] font-extrabold text-purple-600 uppercase tracking-widest">Quoting Question</p>
                    <div class="flex gap-1">
                        @foreach($question->tags as $lang)
                        <span class="bg-purple-200 text-purple-700 text-[10px] px-2 py-0.5 rounded font-bold">#{{ $lang->code }}</span>
                        @endforeach
                    </div>
                </div>
                <h4 class="font-bold text-gray-800 mb-1">{{ $question->q_title }}</h4>
                <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">{{ $question->q_content }}</p>
                <p class="text-[11px] text-gray-400 mt-3 flex items-center">
                    <img src="{{ $question->user->avatar ?? asset('images/baby-octopus.png') }}" class="w-4 h-4 rounded-full mr-1">
                    By {{ $question->user->name }}
                </p>

            </div>
            @else
            <div class="bg-blue-50 p-5 rounded-xl mb-6 border border-blue-100 flex items-start space-x-3">
                <i class="fa-solid fa-circle-info text-blue-500 mt-1"></i>
                <div>
                    <p class="text-sm text-blue-800 font-bold">New General Discussion</p>
                    <p class="text-xs text-blue-600 mt-0.5">You are starting a discussion without quoting a specific question.</p>
                </div>
            </div>

            {{-- 2. Language Selection (Only when NOT quoting a question) --}}
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                <label class="block font-bold text-gray-700 mb-3">
                    Target Languages <span class="text-red-500 text-xs">*Required</span>
                </label>
                <div class="flex flex-wrap gap-3">
                    @foreach($languages as $lang)
                    <label class="inline-flex items-center group cursor-pointer">
                        <input type="checkbox" name="language_ids[]" value="{{ $lang->id }}"
                            class="hidden peer" {{ (is_array(old('language_ids')) && in_array($lang->id, old('language_ids'))) ? 'checked' : '' }}>
                        <div class="px-4 py-2 rounded-full border border-gray-200 text-sm font-bold text-gray-500 transition-all 
                                            peer-checked:bg-purple-600 peer-checked:text-white peer-checked:border-purple-600 
                                            group-hover:border-purple-300">
                            {{ $lang->name }}
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('language_ids')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            @endif

            <!-- input  -->
            <div class="space-y-4">
                <div>
                    <label class="block font-bold text-gray-700 mb-1 ml-1">Discussion Title</label>
                    <input type="text" name="d_title"
                        value="{{ $question ? 'Re: ' . $question->q_title : old('d_title') }}"
                        class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-purple-500 focus:border-purple-500 p-3"
                        required placeholder="e.g. Better explanation for this grammar point">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1 ml-1">Your Opinion / Discussion Point</label>
                    <textarea name="d_content" rows="10"
                        class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-purple-500 focus:border-purple-500 p-4"
                        required placeholder="What would you like to discuss with other teachers?">{{ old('d_content') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-purple-600 text-white px-10 py-3 rounded-full font-bold shadow-lg hover:bg-purple-700 transition transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Post Discussion
                </button>
            </div>
        </form>

    </div>
</x-app-layout>