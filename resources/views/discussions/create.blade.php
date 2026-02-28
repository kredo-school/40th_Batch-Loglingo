<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="w-full md:w-2/3 mx-auto">
                {{-- card header --}}
                <div class="max-w-full mx-auto mt-5 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="bg-white px-5 py-3 border-b border-gray-200 flex items-center justify-center gap-2">
                        <img src="{{ asset('/images/baby-octopus.png') }}" alt="LogLingo octopus" class="w-20 h-20 object-contain">
                        <h1 class="text-4xl text-gray-800 tracking-wide">
                            Let's start a discussion!
                        </h1>
                        <i class="text-5xl fa-solid fa-comments text-purple-500"></i>
                    </div>

                    {{-- card body --}}
                    <form action="{{ route('discussions.store') }}" method="post" class="space-y-6 px-4 py-6">
                        @csrf

                        {{-- if it has quotated question --}}
                        @if($question)
                            <input type="hidden" name="question_id" value="{{ $question->id }}">
                            <div class="bg-purple-50 border border-purple-100 rounded-2xl p-5 mx-4">
                                <div class="flex justify-between items-start mb-2">
                                    <p class="text-[10px] font-extrabold text-purple-600 uppercase tracking-widest leading-none">Quoting Question</p>
                                    <div class="flex gap-1">
                                        @foreach($question->tags as $lang)
                                            <span class="bg-purple-200 text-purple-700 text-[10px] px-2 py-0.5 rounded font-bold">#{{ $lang->code }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <h4 class="font-bold text-gray-800">{{ $question->q_title }}</h4>
                                <p class="text-sm text-gray-500 line-clamp-1 mt-1">{{ $question->q_content }}</p>
                            </div>
                        @endif
                            

                        {{-- title --}}
                        <div class="px-4">
                            <label for="d_title" class="block text-xl mb-2">Discussion Title</label>
                            <input type="text" name="d_title" id="d_title" 
                                value="{{ $question ? 'Re: ' . $question->q_title : old('d_title') }}" 
                                required placeholder="What do you want to debate?" 
                                class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-purple-100 focus:border-purple-400 transition outline-none">
                            @error('d_title')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- content --}}
                        <div class="px-4">
                            <label for="d_content" class="block text-xl mb-2">Your Opinion / Discussion Point</label>
                            <textarea name="d_content" id="d_content" rows="12" 
                                placeholder="Share your perspective..."
                                class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-purple-100 focus:border-purple-400 transition outline-none resize-none">{{ old('d_content') }}</textarea>
                            @error('d_content')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- if without quotation / choose a tag --}}
                        @if(!$question)
                            <div class="px-4">
                                <label for="language_ids" class="block text-xl mb-2">Choose a tag</label>
                                <div class="relative">
                                    <i class="fa-solid fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                                    {{-- select --}}
                                    <select name="language_ids[]" id="language_ids" 
                                        class="w-full pl-11 pr-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-purple-100 focus:border-purple-400 transition outline-none">
                                        <option value="" hidden>Which language is this discussion ABOUT?</option>
                                        @foreach($languages as $language)
                                            <option value="{{ $language->id }}" {{ (is_array(old('language_ids')) && in_array($language->id, old('language_ids'))) ? 'selected' : '' }}>
                                                {{ $language->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('language_ids')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        {{-- save --}}
                        <div class="px-4 pt-6 pb-4 flex justify-end">
                            <button type="submit" 
                                class="px-12 py-2 bg-purple-600 border border-purple-600 text-white font-bold rounded-xl hover:bg-white hover:text-purple-600 transition-all duration-300 ease-in-out active:translate-y-1">
                                Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>