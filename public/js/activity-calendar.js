

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

    // Main loop (date)
    for (let day = 1; day <= daysInMonth; day++) {

        const cell = document.createElement("div");

        const date = `${year}-${String(month+1).padStart(2,"0")}-${String(day).padStart(2,"0")}`;

        const raw = activityData[date];
        const count = raw ? Number(raw) : 0;

        cell.className = "w-4 h-2 rounded-sm";

        if (date === today) {

            cell.classList.add("ring-1","ring-blue-400");

        }

        if (count === 0) {

            cell.classList.add("bg-gray-200");

        } else if (count < 3) {

            cell.classList.add("bg-green-200");

        } else if (count < 6) {

            cell.classList.add("bg-green-400");

        } else {

            cell.classList.add("bg-green-600");

        }

// --- tooltip (hover design) ---
        cell.classList.add("relative");

        const tooltip = document.createElement("div");

       const formattedDate = new Date(date).toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });

        tooltip.innerText = `${formattedDate}\n${count} ${count === 1 ? 'activity' : 'activities'}`;


        tooltip.className = `
          absolute
          top-full
          left-1/2
          -translate-x-1/2
          mb-1
          mt-4
          px-1 py-1
          text-xs
          text-white
          text-semibold
          bg-[#B178CC]/80
          rounded
          opacity-0
          pointer-events-none
          transition-opacity
          duration-200
          z-50  
          min-w-[120px]
          text-center
        `;
        

        cell.addEventListener("mouseenter", () => {
            tooltip.classList.remove("opacity-0");
        });

        cell.addEventListener("mouseleave", () => {
            tooltip.classList.add("opacity-0");
        });

        cell.appendChild(tooltip);

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
