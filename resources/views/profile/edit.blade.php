<x-app-layout>
    {{-- delete when layout completed ?? --}}
    <div class="py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8 justify-center">
            <div class="w-full md:w-2/3">
             {{-- left --}}
             {{-- card header --}}
                <div class="max-w-full mx-auto mt-5 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-white px-5 py-3 border-b border-gray-200 flex items-center justify-center gap-2">
                    <img src="{{ asset('/images/octopus.png') }}" alt="LogLingo octopus" class="w-20 h-20  object-contain">  
                    <h1 class="text-4xl text-gray-800 tracking-wide">
                    Edit Profile
                    </h1>
                </div>

             {{-- card body--}}
             <form action="{{ route('profile.update') }}" method="post" class="space-y-6" enctype="multipart/form-data">   
                 @csrf
                 @method('PATCH')
                    {{-- avatar --}}
                    <div class="flex mb-6 gap-4">
                        <div class="w-1/3 flex justify-center">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="avatar"
                                    class="w-32 h-32 rounded-full object-cover">
                            @else
                                <i class="fa-solid fa-circle-user text-gray-400 text-[128px]"></i>
                            @endif
                        </div>

                        <div class="flex-auto self-end">
                            <input type="file" name="avatar" id="avatar" class="block text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 p-1 focus:outline-none">

                            <p class="mt-1 text-xs text-gray-500 leading-relaxed">
                                Available formats: jpeg, jpg, png, gif only.<br>
                                Max file size is 1048 KB
                            </p>

                            @error('avatar')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- name --}}
                    <div class="px-4"> 
                        <label for="name" class="block text-xl mb-2">Username</label> 
                        <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" required class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition outline-none">
                        
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- First language --}}
                    <div class="px-4">
                        <label for="f_lang" class="block text-xl mb-2">First language</label>
                        <select name="f_lang" id="f_lang" 
                            class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition outline-none">
                                <option value="" hidden>Select your first language</option> 

                                {{-- show language using loop etc --}} 
                                {{-- <option value="1">Japanese</option> 
                                <option value="2">English</option> 
                                <option value="3">Spanish</option> 
                                <option value="4">Chinese</option>  --}}
                        
                        {{-- WILL replace "option" above to below --}}
                            <option value="" hidden>Select your first language</option>
                            @foreach($languages as $language)
                                <option value="{{ $language->id }}" {{ old('f_lang', Auth::user()->f_lang) == $language->id ? 'selected' : '' }}>
                                    {{ $language->name }}
                                </option>
                            @endforeach

                        </select>  

                        @error('f-lang')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                 
                    {{-- Language to study --}}
                    <div class="px-4">
                        <label for="s_lang" class="block text-xl mb-2">Language to study</label>
                        <select name="s_lang" id="s_lang" 
                            class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition outline-none">
                            <option value="" hidden>Select your language to study</option>
                            {{-- show language using loop etc --}}
                            {{-- <option value="1">Japanese</option>
                            <option value="2">English</option>
                            <option value="3">Spanish</option>
                            <option value="4">Chinese</option> --}}
                            
                            {{-- WILL replace "option" above to below --}}
                            <option value="" hidden>Select your first language</option>
                            @foreach($languages as $language)
                                <option value="{{ $language->id }}" {{ old('s_lang', Auth::user()->s_lang) == $language->id ? 'selected' : '' }}>
                                    {{ $language->name }}
                                </option>
                            @endforeach
                        </select>  

                        @error('s-lang')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>



                    {{-- email --}}
                    <div class="px-4"> 
                        <label for="email" class="block text-xl mb-2">Email</label> 
                        <input type="text" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition outline-none">
                        
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- introduction --}}
                    <div class="px-4"> 
                        <label for="intro" class="block text-xl mb-2">Introduction</label> 
                        <textarea name="introduction" id="intro" rows="5" 
                            placeholder="Hello! I'd love to get to know you!"
                            class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition outline-none resize-none">{{ old('introduction', Auth::user()->introduction) }}</textarea>
                        
                        @error('introduction')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- save --}}
                    <div class="px-4 pt-6 pb-4 flex justify-end">
                        <button type="submit" 
                            class="px-12 py-1 bg-[#298CE9] border border-[#298CE9] text-white font-bold rounded-xl hover:bg-white  hover:border-[#298CE9] hover:text-[#298CE9] transition-all duration-300 ease-in-out active:translate-y-1">
                            Save
                        </button>
                    </div>

                    
                </form>


               
            </div>
        </div>
    </div>
    



</x-app-layout> 


{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
