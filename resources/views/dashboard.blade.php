<x-app-layout>
    <div class="py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">

            <!-- Left side -->
            <div class="w-full md:w-2/3">

                <div class="flex justify-between items-end mb-4">
                    <h2 class="text-2xl text-gray-800 font-bold">Latest posts from following</h2>
                    <a href="#" class="text-sm text-black hover:underline">see more</a> {{--★need to create a link to show more posts --}}
                </div>

                <!-- Post example-->
                <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-4 flex space-x-4 mb-4">

                    <div class="flex-shrink-0">
                        <div class="w-20 h-20 rounded-full bg-orange-400 overflow-hidden border-2 border-white shadow-sm">
                            <img src="https://via.placeholder.com/150" alt="user" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="flex-1 flex flex-col">
                        <div class="flex justify-between items-start">
                            <a href="#">
                                <h3 class="font-bold text-gray-700 hover:underline">user name</h3>
                            </a>
                            <span class=" text-gray-500 underline text-[14px]">01/17/2026</span>
                        </div>

                        <a href="#" class="hover:underline mt-1">
                            <h4 class=" text-lg underline mb-1">New release from Starbucks!</h4>
                            <p class="text-sm text-gray-600 line-clamp-1">I went to Starbucks today to try their new drink! The new flavor is aaaaa bbbbb ccccc ddddd eeeee fffff gggggg hhhhh iiiii jjjjj kkkkk lllll mmmmm nnnnn ooooo ppppp qqqqq rrrrr sssss ttttt uuuuu</p>
                        </a>

                        <div class="flex justify-between items-center mt-4">

                            
                            <p class="text-[12px] text-gray-400">2 days ago</p>

                            <div class="flex items-center space-x-3">
                                <span class="text-[14px] px-2 rounded text-gray-600 font-bold">
                                    <i class="fa-solid fa-tag"></i> EN
                                </span>
                                <i class="fa-regular fa-flag text-gray-600 hover:text-red-500 cursor-pointer"></i>
                            </div>

                        </div>
                    </div>
                </div>



            </div>

            <!-- right side -->
            <div class="w-full md:w-1/3 space-y-6">

                <!-- user profile on the right side -->
                <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 rounded-full bg-yellow-400 border-4 border-white shadow-sm overflow-hidden">
                            <img src="https://via.placeholder.com/150" alt="user" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="text-xl">{{ Auth::user()->name }}</h3>
                            <p class="text-sm"><span class="font-bold">3</span> posts</p> {{-- ★show its post count --}}
                            <p class="text-sm"><span class="font-bold">3</span> questions</p> {{-- ★show its question count --}}
                        </div>
                    </div>

                    <a href="#" class="block w-full border border-gray-400 hover:bg-[#B178CC] hover:text-white text-center font-bold py-4 mt-4 rounded-[1rem] shadow-md transition-transform hover:scale-[1.02]">
                        <i class="fa-solid fa-pen-to-square mr-2"></i><span class="text-xl">Post a new log</span>
                    </a>{{--★create a link to Post a new log page--}}
                </div>


                <!-- suggested users -->
                <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-6 mt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-800">Suggested users</h3>
                        <a href="#" class="text-xs text-gray-500 hover:underline">see more</a>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-pink-400 border-2 border-white shadow-sm overflow-hidden">
                                    <img src="https://via.placeholder.com/150" alt="user" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-700">User A</p>
                                    <p class="text-[10px] text-gray-400">Student</p>
                                </div>
                            </div>
                            <button class="bg-[#B178CC] text-white text-[10px] font-bold px-3 py-1 rounded-full hover:bg-[#a068ba] transition-colors">
                                Follow
                            </button>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-cyan-400 border-2 border-white shadow-sm overflow-hidden">
                                    <img src="https://via.placeholder.com/150" alt="user" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-700">User B</p>
                                    <p class="text-[10px] text-gray-400">English Learner</p>
                                </div>
                            </div>
                            <button class="bg-[#B178CC] text-white text-[10px] font-bold px-3 py-1 rounded-full hover:bg-[#a068ba] transition-colors">
                                Follow
                            </button>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</x-app-layout>