<x-guest-layout>
    <h1 class="font-display text-4xl font-normal font-black text-center m-4"> Sign up!</h1>
    <form action="{{ route('register') }}" method="POST" class="space-y-5">
    @csrf
        <!-- User Name -->
        <div class="space-y-1">
            <label for="name" class="text-lg">Username</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="space-y-1">
            <label for="email" class="text-lg">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror                                
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <label for="password" class="text-lg">Password</label>
            <input type="password" id="password" name="password" required class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1">
            <label  for="password_confirmation" class="text-lg">Confirm password</label>
            <input   type="password" id="password_confirmation" name="password_confirmation" required  class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition">
        </div>

        <!-- First Language -->
        <div class="space-y-1">
            <label for="f_lang" class="text-lg">First language</label>
            <div class="relative">
                <i class="fa-solid fa-message absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                <select id="f_lang" name="f_lang" required class="w-full pl-11 pr-10 py-3 appearance-none rounded-2xl border border-gray-300 bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition outline-none">

                <option value="" hidden>
                        Select your language
                    </option>

                    @foreach($languages as $language)
                        <option value="{{ $language->id }}" {{ old('f_lang') == $language->id ? 'selected' : '' }} >
                            {{ $language->name }}
                        </option>
                    @endforeach
                </select>
                
            </div>
        </div>

        <!-- Language to Study -->
        <div class="space-y-1">
            <label for="s_lang" class="text-lg">Language to study</label>
            <div class="relative">
                <i class="fa-solid fa-pen-clip absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                <select id="s_lang" name="s_lang" required class="w-full pl-11 pr-10 py-3 appearance-none rounded-2xl border border-gray-300 bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition outline-none">

                <option value="" hidden>
                        Select your language
                    </option>

                    @foreach($languages as $language)
                        <option value="{{ $language->id }}" {{ old('s_lang') == $language->id ? 'selected' : '' }} >
                            {{ $language->name }}
                        </option>
                    @endforeach

                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full space-y-8 py-4 bg-[#298CE9] text-white text-xl rounded-2xl border-2 border-gray-600 hover:bg-white hover:border-[#298CE9] hover:text-[#298CE9] transition-all duration-300 ease-in-out active:translate-y-1">
            Sign up
        </button>
    </form>

    <!-- Footer Link -->
    <div class="mt-8 text-center flex justify-between items-center px-2">
        <span class="text-gray-500">Already have an account?</span>
        <a href="{{ route('login') }}" class="text-gray-500 underline underline-offset-4 hover:text-gray-700 transition-colors">Log in here</a>
    </div>
</x-guest-layout>
    
   