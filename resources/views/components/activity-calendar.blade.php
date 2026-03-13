@props([
    'activityData'
])
<div class="mt-0 w-[160px] h-[80px]">

    <h3 class="text-xs text-center font-semibold text-gray-500">
        Activity Log
    </h3>

    <div class="grid grid-cols-[20px_1fr_20px] items-center text-xs w-full">

        <button id="prev-month"
            class="text-gray-500 hover:text-black text-center">
            ←
        </button>

        <p id="calendar-month" class="text-gray-400 text-center"></p>

        <button id="next-month"
            class="text-gray-500 hover:text-black text-center">
            →
        </button>

    </div>

    <div id="activity-calendar" class="grid grid-cols-7 gap-[2px] justify-start"></div>

</div>


<script>
    const activityData = @json($activityData);
</script>

<script src="{{ asset('js/activity-calendar.js') }}"></script>