<x-app-layout>
  <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="w-full md:w-2/3 mx-auto">
             {{-- left --}}
             {{-- card header --}}
                <div class="max-w-full mx-auto mt-5 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-white px-5 py-3 border-b border-gray-200 flex items-center justify-center gap-2">
                    <img src="{{ asset('/images/octopus.png') }}" alt="LogLingo octopus" class="w-20 h-20  object-contain">  
                    <h1 class="text-4xl text-gray-800 tracking-wide">Let's log your day!</h1>
                    <i class="text-5xl fa-solid fa-pen-to-square mr-2"></i>
                </div>

             {{-- card body--}}
             <form action="{{ route('posts.store') }}" method="post" class="space-y-6" enctype="multipart/form-data">   
                 @csrf

                  {{-- event date --}}
                    <div class="px-4"> 
                        <label for="event_date" class="block text-xl mb-2">When was this?</label> 
                        <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" required class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition outline-none">
                        
                        @error('event_date')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                   {{-- title --}}
                    <div class="px-4"> 
                        <label for="p_title" class="block text-xl mb-2">Title</label> 
                        <input type="text" name="p_title" id="p_title" value="{{ old('p_title') }}" required placeholder="Name your day!" class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition outline-none">
                        
                        @error('p_title')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- content --}}
                    <div class="px-4"> 
                        <label for="p_content" class="block text-xl mb-2">Content</label> 
                        <textarea name="p_content" id="p_content" rows="15" 
                            placeholder="What happened?"
                            class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition outline-none resize-none">{{ old('p_content')}}</textarea>
                        
                        @error('p_content')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                  {{-- tag --}}
                    <div class="px-4">
                        <label for="tag" class="block text-xl mb-2">Choose a tag</label>
                        <div class="relative">
                            <i class="fa-solid fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                            <select name="tag" id="tag" 
                                class="w-full pl-11 pr-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition outline-none">
                                    
                                <option value="" hidden>In which language did you write? </option>
                                @foreach($languages as $language)
                                    <option value="{{ $language->id }}">
                                        {{ $language->name }}
                                    </option>
                                @endforeach

                            </select> 
                        </div> 

                        @error('tag')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- save --}}
                    <div class="px-4 pt-6 pb-4 flex justify-end">
                        <button type="submit" 
                            class="px-12 py-1 bg-[#298CE9] border border-[#298CE9] text-white font-bold rounded-xl hover:bg-white  hover:border-[#298CE9] hover:text-[#298CE9] transition-all duration-300 ease-in-out active:translate-y-1">
                            Post
                        </button>
                    </div>

                    
                </form>


               
            </div>
        </div>
    </div>
    


</x-app-layout> 