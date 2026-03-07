<x-guest-layout>
    <h1 class="font-display text-4xl font-normal font-black text-center m-4"> Log in!</h1>

    <form action="{{ route('login') }}" method="POST" class="space-y-5">
        @csrf
        <!-- Email -->
        <div class="space-y-1">
            <label for="email" class="text-lg">Email</label>
            <input type="email" id="email" name="email" required class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition">

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <label for="password" class="text-lg">Password</label>
            <input type="password" id="password" name="password" required class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition">
        </div>

        <!-- forget password? -->
        <div class="mt-8 text-center flex justify-between items-center px-2">
            <span class="text-gray-500">Forget password?</span>
            <a href="{{ route('password.request') }}" class="text-gray-500 text-end underline underline-offset-4 hover:text-gray-700 transition-colors">Reset here</a>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full py-4 bg-[#B178CC] text-white text-xl rounded-2xl border-2 border-gray-600 hover:bg-white hover:border-[#B178CC] hover:text-[#B178CC] transition-all duration-300 ease-in-out active:translate-y-1">
            Log in
        </button>
    </form>

    <!-- Footer Link -->
    <div class="mt-8 text-center flex justify-between items-center px-2">
        <span class="text-gray-500">Don't have an account?</span>
        <a href="{{ route('register') }}" class="text-gray-500 underline underline-offset-4 hover:text-gray-700 transition-colors">Sign up here</a>
    </div>
</x-guest-layout>
