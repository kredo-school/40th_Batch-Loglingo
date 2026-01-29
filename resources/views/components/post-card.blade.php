<div class="space-y-4">

  <!-- post example1 -->
  <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-5 flex space-x-4 transition-all hover:border-gray-200">

    {{-- user icon --}}
    <div class="flex-shrink-0">
      <div class="w-16 h-16 rounded-full bg-orange-400 overflow-hidden border-2 border-white shadow-sm">
        <img src="#" alt="user" class="w-full h-full object-cover">
      </div>
    </div>

    {{-- content --}}
    <div class="flex-1 flex flex-col">
      <div class="flex justify-between items-start mb-2">
        <a href="#" class="group">
          <h3 class="font-bold text-gray-700 group-hover:text-[#B178CC] transition-colors">user name</h3> {{--★$post->user->name --}}
        </a>
        <span class="text-gray-400 text-[13px] underline">01/17/2026</span> {{-- ★$post->date->format('m/d/Y') --}}
      </div>

      {{-- tytle&body  --}}
      <a href="#" class="group block mt-1">
        {{-- title --}}
        <h4 class="text-xl font-extrabold text-gray-900 leading-tight mb-1 group-hover:underline decoration-gray-400">
          New release from Starbucks! {{-- ★$post->title --}}
        </h4>
        {{-- body --}}
        <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
          I went to Starbucks today to try their new drink! The new flavor is aaaaa bbbbb ccccc ddddd eeeee fffff gggggg hhhhh iiiii jjjjj kkkkk lllll mmmmm nnnnn ooooo ppppp qqqqq rrrrr sssss ttttt uuuuu {{-- ★$post->body --}}
        </p>
      </a>

      {{-- tag&report --}}
      <div class="flex justify-between items-center mt-4 pt-3 border-t border-gray-50">
        <p class="text-[12px] text-gray-400">2 days ago</p> {{-- ★$post->created_at->diffForHumans() --}}

        <div class="flex items-center space-x-3">
          <span class="text-[12px] px-2 py-1 bg-gray-50 rounded-md text-gray-600 font-bold border border-gray-100">
            <i class="fa-solid fa-tag mr-1 text-gray-400"></i> EN {{-- ★$post->language_tag --}}
          </span>
          <i class="fa-regular fa-flag text-gray-400 hover:text-red-500 cursor-pointer"></i> {{-- ★add a report system --}}
        </div>
      </div>
    </div>
  </div>

  <!-- post example2 -->
  <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-5 flex space-x-4 transition-all hover:border-gray-200">

    {{-- user icon --}}
    <div class="flex-shrink-0">
      <div class="w-16 h-16 rounded-full bg-orange-400 overflow-hidden border-2 border-white shadow-sm">
        <img src="#" alt="user" class="w-full h-full object-cover">
      </div>
    </div>

    {{-- content --}}
    <div class="flex-1 flex flex-col">
      <div class="flex justify-between items-start mb-2">
        <a href="#" class="group">
          <h3 class="font-bold text-gray-700 group-hover:text-[#B178CC] transition-colors">user name</h3> {{--★$post->user->name --}}
        </a>
        <span class="text-gray-400 text-[13px] underline">01/17/2026</span> {{-- ★$post->created_at->format('m/d/Y') --}}
      </div>

      {{-- tytle&body  --}}
      <a href="#" class="group block mt-1">
        {{-- title --}}
        <h4 class="text-xl font-extrabold text-gray-900 leading-tight mb-1 group-hover:underline decoration-gray-400">
          New release from Starbucks! {{-- ★$post->title --}}
        </h4>
        {{-- body --}}
        <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
          I went to Starbucks today to try their new drink! The new flavor is aaaaa bbbbb ccccc ddddd eeeee fffff gggggg hhhhh iiiii jjjjj kkkkk lllll mmmmm nnnnn ooooo ppppp qqqqq rrrrr sssss ttttt uuuuu {{-- ★$post->body --}}
        </p>
      </a>

      {{-- tag&report --}}
      <div class="flex justify-between items-center mt-4 pt-3 border-t border-gray-50">
        <p class="text-[12px] text-gray-400">2 days ago</p> {{-- ★$post->created_at->diffForHumans() --}}

        <div class="flex items-center space-x-3">
          <span class="text-[12px] px-2 py-1 bg-gray-50 rounded-md text-gray-600 font-bold border border-gray-100">
            <i class="fa-solid fa-tag mr-1 text-gray-400"></i> EN {{-- ★$post->language_tag --}}
          </span>
          <i class="fa-regular fa-flag text-gray-400 hover:text-red-500 cursor-pointer"></i> {{-- ★add a report system --}}
        </div>
      </div>
    </div>
  </div>


</div>