<x-app-layout>
  <div class="py-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">

      {{--left side--}}
      <div class="w-full md:w-2/3 space-y-6">
        <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-8">

          {{-- post header --}}
          <div class="mb-6">
            <div class="flex items-start space-x-4 w-full">
              <img src="#" alt="user" class="w-16 h-16 rounded-full object-cover bg-orange-400">

              <div class="flex-1">
                <div class="flex justify-between items-center mb-1">
                  <h3 class="font-bold text-lg text-gray-800">user name</h3> {{-- ★$post->user->name --}}

                  {{-- delete ★need to set a route --}}
                  <form action="#" method="POST" onsubmit="return confirm('Really delete this post?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white text-sm px-3 py-1 rounded-full font-bold shadow-sm hover:bg-red-600 transition-colors">delete</button>
                  </form>
                </div>

                {{-- event date --}}
                <p class="text-[15px] text-gray-600 block mb-1">01/17/2026</p> {{-- ★$post->date->format('m/d/Y') --}}

                {{-- post title --}}
                <h2 class="text-[20px] font-extrabold text-gray-900 mb-2">
                  New release from Starbucks! {{-- ★$post->title --}}
                </h2>

                {{-- footer(post date/tag/report) --}}
                <div class="flex justify-between items-center w-full">
                  <p class="text-[13px] text-gray-400">2 days ago</p> {{-- ★$post->created_at->diffForHumans() --}}

                  <div class="flex items-center space-x-3">
                    <span class="text-[12px] px-2 py-1 bg-gray-50 rounded-md text-gray-600 font-bold border border-gray-100">
                      <i class="fa-solid fa-tag mr-1 text-gray-400"></i> EN {{-- ★$post->language_tag --}}
                    </span>
                    {{-- ★create a report function--}}
                    <i class="fa-regular fa-flag text-gray-400 hover:text-red-500 cursor-pointer"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- post body --}}
          <p class="text-gray-700 leading-relaxed pb-2 mb-5 border-b">
            I went to Starbucks today to try their new drink! The new flavor is a delightful blend of roasted
            hojicha and creamy caramel. From the very first sip, the nutty aroma of the tea spread through
            my mouth, perfectly balanced by the rich sweetness of the sauce. It wasn't too heavy,
            making it an ideal treat for a relaxing afternoon. The crunchy topping added a fun texture,
            and I found myself finishing the whole cup in no time! It's a limited-time offer, so if you're a fan of
            tea-based lattes, you should definitely grab one before it's gone.
            I'm already thinking about going back tomorrow to hit a 2-day streak!{{-- ★$post->body --}} {{-- ★$post->body --}}
          </p>

          {{-- comment form ★need to set a route--}}
          <div class="pb-4 border-b">
            <form action="#" method="POST">
              @csrf
              <div class="flex items-start space-x-4">
                <img src="#" alt="user" class="w-14 h-14 rounded-full object-cover bg-yellow-400">
                <div class="flex-1">
                  <h4 class="font-bold text-s text-gray-700 mb-1">{{ Auth::user()->name }}</h4>
                  <textarea name="comment" placeholder="write a comment here.." class="w-full border-gray-200 rounded-lg focus:ring-[#B178CC] focus:border-[#B178CC] text-s" rows="2" required></textarea>
                  <div class="flex justify-end mt-2">
                    <button type="submit" class="bg-[#56A5E1] text-white px-6 py-1 rounded-full text-sm font-bold shadow-sm hover:bg-blue-500 transition-colors">Post</button>
                  </div>
                </div>
              </div>
            </form>
          </div>

          {{-- display comments --}}
          {{-- comment example1 --}}
          <div class="space-y-6">
            <div class="flex items-start space-x-4 border-b py-4">
              <img src="#" class="w-12 h-12 rounded-full object-cover bg-orange-400">

              <div class="flex-1">
                <div class="flex justify-between items-center mb-1">
                  <div class="flex items-center space-x-4">
                    <h4 class="font-bold text-[16px]">user name</h4>
                    <span class="text-[13px] text-gray-400">2 days ago</span>
                  </div>

                  <div class="flex items-center space-x-4">
                    {{-- delete ★need to set a route --}}
                    <form action="#" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="bg-red-500 text-white text-[14px] px-3 py-0.5 rounded-full font-bold hover:bg-red-600 transition-colors">delete</button>
                    </form>

                    {{-- ★need to create a report function --}}
                    <i class="fa-regular fa-flag text-[18px] text-gray-400 hover:text-red-500 cursor-pointer"></i>
                  </div>
                </div>

                <div>
                  <span class="text-s text-gray-700 leading-relaxed">I love hojicha lattes! Definitely go back tomorrow
                    and get that second cup while you still can!</span>
                </div>
              </div>
            </div>
          </div>

          {{-- comment example2 --}}
          <div class="space-y-6">
            <div class="flex items-start space-x-4 border-b py-4">
              <img src="#" class="w-12 h-12 rounded-full object-cover bg-orange-400">

              <div class="flex-1">
                <div class="flex justify-between items-center mb-1">
                  <div class="flex items-center space-x-4">
                    <h4 class="font-bold text-[16px]">user name</h4>
                    <span class="text-[13px] text-gray-400">2 days ago</span>
                  </div>

                  <div class="flex items-center space-x-4">
                    {{-- delete ★need to set a route --}}
                    <form action="#" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="bg-red-500 text-white text-[14px] px-3 py-0.5 rounded-full font-bold hover:bg-red-600 transition-colors">delete</button>
                    </form>

                    {{-- ★need to create a report function --}}
                    <i class="fa-regular fa-flag text-[18px] text-gray-400 hover:text-red-500 cursor-pointer"></i>

                  </div>
                </div>

                <div>
                  <span class="text-s text-gray-700 leading-relaxed">thank you for your comment! yes, I'll do that!</span>
                </div>
              </div>
            </div>
          </div>





        </div>
      </div>

      {{-- right side:component --}}
      <div class="w-full md:w-1/3 space-y-6">
        <x-sidebar-profile />
        <x-suggested-users />
      </div>
    </div>
  </div>
</x-app-layout>