<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-6">
        <h2 class="text-2xl font-bold mb-6">Start a New Discussion</h2>

        <form action="{{ route('discussions.store') }}" method="POST" class="space-y-6">
            @csrf

            @if($question)
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                <div class="bg-purple-50 border border-purple-100 rounded-xl p-4 mb-6">
                    <p class="text-xs font-bold text-purple-600 uppercase mb-2">Quoting Question:</p>
                    <h4 class="font-bold text-gray-800">{{ $question->q_title }}</h4>
                    <p class="text-sm text-gray-500 line-clamp-2">{{ $question->q_content }}</p>
                    <p class="text-[11px] text-gray-400 mt-2">By {{ $question->user->name }}</p>
                </div>
            @endif

            <div>
                <label class="block font-bold text-gray-700">Discussion Title</label>
                <input type="text" name="d_title" 
                       value="{{ $question ? 'Re: ' . $question->q_title : old('d_title') }}" 
                       class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500" required>
            </div>

            <div>
                <label class="block font-bold text-gray-700">Your Opinion / Discussion Point</label>
                <textarea name="d_content" rows="10" 
                          class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500" required placeholder="Let's discuss the best answer for this question...">{{ old('d_content') }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-purple-600 text-white px-8 py-2 rounded-full font-bold hover:bg-purple-700 transition">
                    Post Discussion
                </button>
            </div>
        </form>
    </div>
</x-app-layout>