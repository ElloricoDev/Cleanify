@extends('layouts.app')

@section('title', 'Garbage Schedule')

@section('content')
  <!-- Calendar Wrapper -->
  <div class="bg-white rounded-2xl shadow-xl p-8 max-w-4xl mx-auto fade-in">
    <!-- Calendar Header -->
    <div class="flex justify-between items-center mb-8">
      <button id="prevMonth" class="w-10 h-10 border border-green-600 text-green-600 rounded-full hover:bg-green-600 hover:text-white transition-colors duration-300 flex items-center justify-center">
        <i class="fas fa-chevron-left"></i>
      </button>
      <h3 id="monthYear" class="text-2xl font-bold text-green-600"></h3>
      <button id="nextMonth" class="w-10 h-10 border border-green-600 text-green-600 rounded-full hover:bg-green-600 hover:text-white transition-colors duration-300 flex items-center justify-center">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>

    <!-- Calendar Grid -->
    <div class="grid grid-cols-7 gap-3" id="calendar"></div>

    <!-- Info Box -->
    <div class="bg-green-50 border-l-4 border-green-600 rounded-xl p-5 mt-8 shadow-sm">
      <h6 class="text-green-700 font-bold text-lg mb-3">
        <i class="fas fa-info-circle mr-2"></i>Collection Schedule
      </h6>
      <ul class="space-y-2">
        <li class="text-gray-700"><strong class="text-green-700">Monday & Thursday:</strong> Biodegradable Waste</li>
        <li class="text-gray-700"><strong class="text-green-700">Wednesday:</strong> Non-biodegradable Waste</li>
        <li class="text-gray-700"><strong class="text-green-700">Saturday:</strong> Recyclables Collection</li>
      </ul>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    const calendar = document.getElementById("calendar");
    const monthYear = document.getElementById("monthYear");
    const prevMonth = document.getElementById("prevMonth");
    const nextMonth = document.getElementById("nextMonth");

    let today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();

    // Dynamic schedule data (could later come from API)
    const scheduleTypes = {
      1: "Biodegradable Waste",   // Monday
      3: "Non-biodegradable Waste", // Wednesday
      4: "Biodegradable Waste",   // Thursday
      6: "Recyclables Collection" // Saturday
    };

    const renderCalendar = (month, year) => {
      calendar.innerHTML = "";
      const firstDay = new Date(year, month).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();

      const weekdays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
      weekdays.forEach(day => {
        const div = document.createElement("div");
        div.classList.add("p-3", "text-center", "font-bold", "bg-green-600", "text-white", "rounded-lg");
        div.textContent = day;
        calendar.appendChild(div);
      });

      // Empty cells before start
      for (let i = 0; i < firstDay; i++) {
        const empty = document.createElement("div");
        calendar.appendChild(empty);
      }

      for (let d = 1; d <= daysInMonth; d++) {
        const date = new Date(year, month, d);
        const div = document.createElement("div");
        div.classList.add("p-4", "text-center", "rounded-lg", "cursor-pointer", "transition-all", "duration-300", "font-medium", "text-gray-800");
        div.textContent = d;

        const dayOfWeek = date.getDay();

        // Apply schedule highlights
        if (scheduleTypes[dayOfWeek]) {
          div.classList.add("bg-gradient-to-br", "from-blue-500", "to-green-600", "text-white", "font-semibold", "shadow-md");
          div.title = scheduleTypes[dayOfWeek];
        } else {
          div.classList.add("bg-gray-100", "hover:bg-gray-200", "hover:scale-105");
        }

        // Highlight today's date
        const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
        if (isToday) {
          div.classList.add("bg-green-100", "border-2", "border-green-600", "font-bold");
          if (!scheduleTypes[dayOfWeek]) {
            div.classList.remove("bg-gray-100");
          }
        }

        calendar.appendChild(div);
      }

      const monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
      ];
      monthYear.textContent = `${monthNames[month]} ${year}`;
    };

    prevMonth.addEventListener("click", () => {
      currentMonth--;
      if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
      }
      renderCalendar(currentMonth, currentYear);
    });

    nextMonth.addEventListener("click", () => {
      currentMonth++;
      if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
      }
      renderCalendar(currentMonth, currentYear);
    });

    renderCalendar(currentMonth, currentYear);
  </script>
@endpush
