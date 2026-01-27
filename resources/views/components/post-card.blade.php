{{-- @props(['post']) --}}

<div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-4 flex space-x-4 mb-4">

  <div class="flex-shrink-0">
    <div class="w-20 h-20 rounded-full bg-orange-400 overflow-hidden border-2 border-white shadow-sm">
      <img src="https://via.placeholder.com/150" alt="user" class="w-full h-full object-cover">
    </div>
  </div>

  <div class="flex-1 flex flex-col">
    <div class="flex justify-between items-start">
      <a href="#">
        <h3 class="font-bold text-gray-700 hover:underline">user name</h3> {{--★$post->user->name --}}
      </a>
      <span class=" text-gray-500 underline text-[14px]">01/17/2026</span> {{-- ★$post->created_at->format('m/d/Y') --}}
    </div>

    <a href="#" class="hover:underline mt-1">
      <h4 class=" text-lg underline mb-1">New release from Starbucks!</h4> {{-- ★$post->title --}}
      <p class="text-sm text-gray-600 line-clamp-1">I went to Starbucks today to try their new drink! The new flavor is aaaaa bbbbb ccccc ddddd eeeee fffff gggggg hhhhh iiiii jjjjj kkkkk lllll mmmmm nnnnn ooooo ppppp qqqqq rrrrr sssss ttttt uuuuu</p> {{-- ★$post->body --}}
    </a>

    <div class="flex justify-between items-center mt-4">


      <p class="text-[12px] text-gray-400">2 days ago</p> {{-- ★$post->created_at->diffForHumans() --}}

      <div class="flex items-center space-x-3">
        <span class="text-[14px] px-2 rounded text-gray-600 font-bold">
          <i class="fa-solid fa-tag"></i> EN {{-- ★$post->language_tag --}}
        </span>
        <i class="fa-regular fa-flag text-gray-600 hover:text-red-500 cursor-pointer"></i> {{-- ★add a report system --}}
      </div>

    </div>
  </div>
</div>