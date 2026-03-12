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

const calendar = document.getElementById("activity-calendar");

const monthLabel = document.getElementById("calendar-month");

const monthNames = [
"January","February","March","April","May","June",
"July","August","September","October","November","December"
];

const now = new Date();

let currentYear = now.getFullYear();
let currentMonth = now.getMonth();

const today = new Date().toISOString().split("T")[0];

function renderCalendar(year, month) {

    calendar.innerHTML = "";

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    monthLabel.innerText = `${monthNames[month]} ${year}`;

    for (let i = 0; i < firstDay; i++) {

        const empty = document.createElement("div");
        calendar.appendChild(empty);

    }

    for (let day = 1; day <= daysInMonth; day++) {

        const cell = document.createElement("div");

        const date = `${year}-${String(month+1).padStart(2,"0")}-${String(day).padStart(2,"0")}`;

        const count = activityData[date] ?? 0;

        cell.className = "w-4 h-2 rounded-sm";

        if (date === today) {

            cell.classList.add("ring-1","ring-blue-400");

        }

        cell.title = `${date} : ${count} activities`;

        if (count === 0) {

            cell.classList.add("bg-gray-200");

        } else if (count < 3) {

            cell.classList.add("bg-green-200");

        } else if (count < 6) {

            cell.classList.add("bg-green-400");

        } else {

            cell.classList.add("bg-green-600");

        }

        calendar.appendChild(cell);

    }

    const totalCells = firstDay + daysInMonth;

    for (let i = totalCells; i < 42; i++) {

        const empty = document.createElement("div");
        calendar.appendChild(empty);

    }

}

renderCalendar(currentYear, currentMonth);

document.getElementById("prev-month").onclick = () => {

    currentMonth--;

    if (currentMonth < 0) {

        currentMonth = 11;
        currentYear--;

    }

    renderCalendar(currentYear, currentMonth);

};

document.getElementById("next-month").onclick = () => {

    currentMonth++;

    if (currentMonth > 11) {

        currentMonth = 0;
        currentYear++;

    }

    renderCalendar(currentYear, currentMonth);

};

</script>