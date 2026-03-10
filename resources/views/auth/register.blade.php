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
            <input type="password" id="password" name="password" required minlength="8" placeholder="At least 8 characters" class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition">
            @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1">
            <label for="password_confirmation" class="text-lg">Confirm password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition">
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
                    <option value="{{ $language->id }}" {{ old('f_lang') == $language->id ? 'selected' : '' }}>
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
                    <option value="{{ $language->id }}" {{ old('s_lang') == $language->id ? 'selected' : '' }}>
                        {{ $language->name }}
                    </option>
                    @endforeach

                </select>
            </div>
        </div>

        <div x-data="termsManager()">
            <div class="flex items-center mt-4">
                <input type="checkbox" name="terms" id="terms" required
                    :disabled="!readAll"
                    :class="!readAll ? 'opacity-50 cursor-not-allowed' : ''"
                    class="rounded border-gray-300 text-[#B178CC] shadow-sm">
                <label for="terms" class="ml-2 text-sm text-gray-600">
                    I agree to the <a href="#" @click.prevent="openTerms = true" class="text-[#B178CC] hover:underline font-bold">Terms of Service</a>
                </label>
            </div>

            <div x-show="openTerms" x-cloak class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-black bg-opacity-50" style="display: none;">
                <div @click.away="openTerms = false" class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[80vh] flex flex-col">

                    <div @scroll="checkScroll" class="p-6 overflow-y-auto text-sm text-gray-600 leading-relaxed h-96">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 text-center">LogLingo Terms of Service</h3>

                        {{-- use terms-content component--}}
                        <x-terms-content />

                        <div class="py-8 text-center">
                            <div class="inline-block p-4 bg-purple-50 rounded-2xl border-2 border-dashed border-[#B178CC]">
                                <p class="font-bold text-[#B178CC]">Thank you for reading!<br>Happy Language Learning!</p>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t flex justify-end">
                        <button @click="openTerms = false"
                            :disabled="!readAll"
                            :class="!readAll ? 'bg-gray-300' : 'bg-[#B178CC]'"
                            class="text-white px-6 py-2 rounded-full font-bold">
                            Close
                        </button>
                    </div>
                </div>
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