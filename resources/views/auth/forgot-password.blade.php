<x-guest-layout>
    <h1 class="font-display text-4xl font-normal font-black text-center m-4 mb-12"> Forget your password?</h1>

    <form action="#" class="space-y-12">
        
        <!-- Email -->
        <div class="space-y-1">
            <label for="email" class="text-lg">Email</label>
            <input type="email" id="email" name="email" required value="" class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full mt-6 py-4 bg-[#CC789C] text-white text-xl rounded-2xl border-2 border-gray-600 hover:bg-white hover:border-[#CC789C] hover:text-[#CC789C] transition-all duration-300 ease-in-out active:translate-y-1">
        Reset password
        </button>
    </form>

    <!-- Footer Link -->
    <div class="mt-8 flex justify-center px-2">
        <a href="{{ route('login') }}" class="text-gray-500 underline underline-offset-4 hover:text-gray-700 transition-colors">Return to login</a>
    </div>
</x-guest-layout>
