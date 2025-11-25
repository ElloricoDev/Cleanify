@extends('layouts.app')

@section('title', 'Garbage Schedule')

@php use Illuminate\Support\Str; @endphp

@section('content')
  <div class="space-y-6">
    <!-- Personalized Reminder + Upcoming timeline -->
    <div class="grid lg:grid-cols-2 gap-6">
      <div class="bg-white rounded-2xl shadow p-6 border border-green-100">
        <div class="flex items-start justify-between gap-4">
          <div>
            <p class="text-sm uppercase tracking-wide text-gray-500 mb-1">Your zone this week</p>
            <h3 class="text-2xl font-semibold text-gray-800">
              {{ $userArea ?? 'Select your area' }}
            </h3>
            @if($nextPickup)
              <p class="text-gray-600 mt-2 flex items-center gap-2">
                <i class="fas fa-calendar-day text-green-600"></i>
                {{ $nextPickup['date_display'] }} · {{ $nextPickup['time_display'] }}
              </p>
              <p class="text-gray-600 mt-1 flex items-center gap-2">
                <i class="fas fa-truck text-green-600"></i>
                Truck {{ $nextPickup['truck'] }} · {{ $nextPickup['waste_type'] }}
              </p>
            @else
              <p class="text-gray-600 mt-2">Choose your area to see the next pickup reminder.</p>
            @endif
          </div>
          <div class="w-40">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Service area</label>
            <select id="serviceAreaSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
              <option value="">Select area</option>
              @foreach($availableAreas as $area)
                <option value="{{ $area }}" {{ $userArea === $area ? 'selected' : '' }}>{{ $area }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="flex flex-wrap items-center gap-3 mt-5">
          <button id="addToCalendarBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
            <i class="fas fa-calendar-plus mr-2"></i>Add to calendar
          </button>
          <div class="flex items-center gap-4">
            @foreach(['email' => 'Email', 'sms' => 'SMS', 'push' => 'Push'] as $key => $label)
              <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" class="reminder-toggle w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500" data-key="{{ $key }}" {{ $notificationSettings[$key] ? 'checked' : '' }}>
                {{ $label }}
              </label>
            @endforeach
          </div>
        </div>
      </div>

      <div class="bg-white rounded-2xl shadow p-6 border border-green-100">
        <div class="flex items-center justify-between mb-4">
          <div>
            <p class="text-sm uppercase tracking-wide text-gray-500">Upcoming pickups</p>
            <h4 class="text-xl font-semibold text-gray-800">Next 5 collections</h4>
          </div>
        </div>
        <div class="space-y-4 max-h-60 overflow-y-auto pr-1">
          @forelse($upcomingPickups as $pickup)
            <div class="flex items-center gap-4">
              <div class="text-center w-16">
                <p class="text-lg font-bold text-green-600">{{ $pickup['date_display'] }}</p>
                <p class="text-xs uppercase tracking-wide text-gray-500">{{ $pickup['day_label'] }}</p>
              </div>
              <div class="flex-1">
                <p class="text-sm font-semibold text-gray-800">{{ $pickup['area'] }}</p>
                <p class="text-sm text-gray-500">{{ $pickup['time_range'] }} · Truck {{ $pickup['truck'] }}</p>
              </div>
              <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $pickup['badge'] }}">{{ $pickup['waste_type'] }}</span>
            </div>
          @empty
            <p class="text-gray-600">No upcoming pickups scheduled.</p>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Filters + export bar -->
    <div class="bg-white rounded-xl shadow-sm p-4 flex flex-wrap items-center gap-4 sticky top-3 z-10 border border-green-100">
      <div class="flex items-center gap-2">
        <label for="areaFilter" class="text-sm font-medium text-gray-600">Filter by zone</label>
        <select id="areaFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500">
          <option value="all">All zones</option>
          @foreach($availableAreas as $area)
            <option value="{{ $area }}">{{ $area }}</option>
          @endforeach
        </select>
      </div>
      <div class="flex items-center gap-2 flex-1 min-w-[200px]">
        <i class="fas fa-search text-gray-400"></i>
        <input type="text" id="scheduleSearch" class="flex-1 border-0 focus:ring-0 text-sm" placeholder="Search zone, truck, or day...">
      </div>
      <div class="flex items-center gap-2 ml-auto">
        <button id="printScheduleBtn" class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
          <i class="fas fa-print mr-2"></i>Print
        </button>
        <button id="downloadIcsBtn" class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
          <i class="fas fa-file-download mr-2"></i>ICS
        </button>
        <button id="shareScheduleBtn" class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
          <i class="fas fa-share-alt mr-2"></i>Share
        </button>
      </div>
    </div>

    <!-- Main content grid -->
    <div class="grid lg:grid-cols-3 gap-6 items-start">
      <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-6 border border-green-100">
        <div class="flex justify-between items-center mb-6">
          <button id="prevMonth" class="w-10 h-10 border border-green-600 text-green-600 rounded-full hover:bg-green-600 hover:text-white transition-colors duration-300 flex items-center justify-center">
            <i class="fas fa-chevron-left"></i>
          </button>
          <h3 id="monthYear" class="text-2xl font-bold text-green-600"></h3>
          <button id="nextMonth" class="w-10 h-10 border border-green-600 text-green-600 rounded-full hover:bg-green-600 hover:text-white transition-colors duration-300 flex items-center justify-center">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
        <div class="grid grid-cols-7 gap-3" id="calendar"></div>
        <p class="text-xs text-gray-500 mt-4">Tip: hover/tap a date to see all pickups scheduled for that day.</p>
      </div>

      <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow p-6 border border-green-100">
          <h5 class="text-green-700 font-semibold text-lg mb-4 flex items-center gap-2">
            <i class="fas fa-map-marker-alt"></i>Zone schedule directory
          </h5>
          @if($schedules->count())
            <div id="scheduleList" class="divide-y divide-gray-100 max-h-[480px] overflow-y-auto pr-1">
              @foreach($schedules as $schedule)
                <div class="py-4 schedule-item" data-area="{{ Str::lower($schedule->area) }}" data-search="{{ Str::lower($schedule->area . ' ' . $schedule->days . ' ' . $schedule->truck) }}">
                  <div class="flex items-center justify-between">
                    <h6 class="font-semibold text-gray-800">{{ $schedule->area }}</h6>
                    <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-green-100 text-green-800">{{ ucfirst($schedule->status) }}</span>
                  </div>
                  <p class="text-sm text-gray-600 mt-1"><strong>Days:</strong> {{ $schedule->days }}</p>
                  <p class="text-sm text-gray-600"><strong>Time:</strong> {{ $schedule->time_range }}</p>
                  <p class="text-sm text-gray-600"><strong>Truck:</strong> {{ $schedule->truck }}</p>
                </div>
              @endforeach
            </div>
          @else
            <p class="text-gray-600">No active schedules available.</p>
          @endif
        </div>

        <div class="bg-white rounded-2xl shadow p-6 border border-green-100">
          <h5 class="text-green-700 font-semibold text-lg mb-4 flex items-center gap-2">
            <i class="fas fa-bell"></i>Reminder preferences
          </h5>
          <p class="text-sm text-gray-600 mb-3">Enable reminders to get notified before pickups in your zone.</p>
          <ul class="space-y-3 text-sm text-gray-600">
            <li class="flex items-center gap-2"><i class="fas fa-envelope text-green-600"></i>Email reminders arrive the night before.</li>
            <li class="flex items-center gap-2"><i class="fas fa-sms text-green-600"></i>SMS reminders (coming soon).</li>
            <li class="flex items-center gap-2"><i class="fas fa-bell text-green-600"></i>Push notifications (coming soon).</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  @php
    $scheduleData = $schedules->map(function ($schedule) {
        $days = collect(explode(',', $schedule->days))
            ->map(function ($day) {
                return strtolower(trim($day));
            })
            ->filter()
            ->values();

        $text = strtolower($schedule->days . ' ' . $schedule->area);
        $wasteType = str_contains($text, 'biodegradable') ? 'Biodegradable'
            : (str_contains($text, 'non') ? 'Non-biodegradable'
            : (str_contains($text, 'recycl') ? 'Recyclables' : 'General'));

        return [
            'area' => $schedule->area,
            'days_list' => $days,
            'days_label' => $schedule->days,
            'time_range' => $schedule->time_range,
            'truck' => $schedule->truck,
            'waste_type' => $wasteType,
        ];
    });
  @endphp
  <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const calendar = document.getElementById("calendar");
    const monthYear = document.getElementById("monthYear");
    const prevMonth = document.getElementById("prevMonth");
    const nextMonth = document.getElementById("nextMonth");
    const areaFilter = document.getElementById("areaFilter");
    const scheduleSearch = document.getElementById("scheduleSearch");
    const scheduleItems = document.querySelectorAll(".schedule-item");
    const serviceAreaSelect = document.getElementById('serviceAreaSelect');
    const nextPickupData = @json($nextPickup);
    const schedules = @json($scheduleData);

    let today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();
    let activeAreaFilter = 'all';

    const scheduleDayMap = { 0: [], 1: [], 2: [], 3: [], 4: [], 5: [], 6: [] };
    const dayMap = { sunday: 0, monday: 1, tuesday: 2, wednesday: 3, thursday: 4, friday: 5, saturday: 6 };

    schedules.forEach(schedule => {
      schedule.days_list.forEach(day => {
        if (dayMap[day] !== undefined) {
          scheduleDayMap[dayMap[day]].push(schedule);
        }
      });
    });

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

      for (let i = 0; i < firstDay; i++) {
        const empty = document.createElement("div");
        calendar.appendChild(empty);
      }

      for (let d = 1; d <= daysInMonth; d++) {
        const date = new Date(year, month, d);
        const div = document.createElement("div");
        const dayOfWeek = date.getDay();
        const daySchedules = scheduleDayMap[dayOfWeek] || [];
        const filteredSchedules = daySchedules.filter(s => activeAreaFilter === 'all' || s.area === activeAreaFilter);
        const summarySource = filteredSchedules.length ? filteredSchedules : daySchedules;

        div.className = "p-4 text-center rounded-lg cursor-pointer transition-all duration-300 font-medium";
        div.textContent = d;

        if (summarySource.length) {
          const summary = summarySource.map(item => `${item.area} (${item.time_range})`).join(" • ");
          div.title = summary;
        }

        if (filteredSchedules.length) {
          const wasteType = filteredSchedules[0].waste_type || 'General';
          if (wasteType === 'Biodegradable') {
            div.classList.add('bg-lime-200', 'text-lime-900', 'border', 'border-lime-300', 'font-semibold');
          } else if (wasteType === 'Non-biodegradable') {
            div.classList.add('bg-amber-200', 'text-amber-900', 'border', 'border-amber-300', 'font-semibold');
          } else if (wasteType === 'Recyclables') {
            div.classList.add('bg-cyan-200', 'text-cyan-900', 'border', 'border-cyan-300', 'font-semibold');
          } else {
            div.classList.add("bg-gradient-to-br", "from-blue-500", "to-green-600", "text-white", "font-semibold", "shadow-md");
          }
        } else if (daySchedules.length) {
          div.classList.add("bg-green-50", "text-gray-800", "border", "border-green-100");
        } else {
          div.classList.add("bg-gray-100", "hover:bg-gray-200", "hover:scale-105", "text-gray-800");
        }

        const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
        if (isToday) {
          div.classList.add("ring-2", "ring-green-500");
        }

        if (summarySource.length) {
          div.addEventListener('click', () => {
            const listItems = summarySource.map(item => `
              <div class="border border-gray-100 rounded-lg p-3 mb-2">
                <p class="font-semibold text-gray-800">${item.area}</p>
                <p class="text-sm text-gray-600">Days: ${item.days_label}</p>
                <p class="text-sm text-gray-600">Time: ${item.time_range}</p>
                <p class="text-sm text-gray-600">Truck: ${item.truck}</p>
              </div>
            `).join('');

            document.getElementById('dayDetailsBody').innerHTML = listItems;
            document.getElementById('dayDetailsTitle').textContent = `Pickups on ${date.toLocaleDateString(undefined, { weekday: 'long', month: 'long', day: 'numeric' })}`;
            openModal('dayDetailsModal');
          });
        }

        calendar.appendChild(div);
      }

      const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
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

    const applyScheduleFilters = () => {
      const areaValue = areaFilter.value.toLowerCase();
      const searchValue = scheduleSearch.value.trim().toLowerCase();

      scheduleItems.forEach(item => {
        const matchesArea = areaValue === 'all' || item.dataset.area === areaValue.toLowerCase();
        const matchesSearch = !searchValue || item.dataset.search.includes(searchValue);
        item.style.display = matchesArea && matchesSearch ? 'block' : 'none';
      });
    };

    areaFilter.addEventListener('change', () => {
      activeAreaFilter = areaFilter.value === 'all' ? 'all' : areaFilter.value;
      applyScheduleFilters();
      renderCalendar(currentMonth, currentYear);
    });

    scheduleSearch.addEventListener('input', applyScheduleFilters);

    serviceAreaSelect?.addEventListener('change', () => {
      fetch('{{ route('garbage-schedule.service-area') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json',
        },
        body: JSON.stringify({ service_area: serviceAreaSelect.value || null }),
      })
        .then(response => response.ok ? window.location.reload() : Promise.reject())
        .catch(() => showToast?.('error', 'Unable to update your zone. Please try again.'));
    });

    const reminderToggles = document.querySelectorAll('.reminder-toggle');
    const sendReminderUpdate = () => {
      const payload = {
        email_notifications: reminderToggles[0].checked ? 1 : 0,
        sms_notifications: reminderToggles[1].checked ? 1 : 0,
        push_notifications: reminderToggles[2].checked ? 1 : 0,
      };

      fetch('{{ route('garbage-schedule.notifications') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json',
        },
        body: JSON.stringify(payload),
      })
        .then(response => response.ok ? response.json() : Promise.reject())
        .then(() => showToast?.('success', 'Reminder preferences saved.'))
        .catch(() => showToast?.('error', 'Unable to save reminder preferences.'));
    };
    reminderToggles.forEach(toggle => toggle.addEventListener('change', sendReminderUpdate));

    const formatIcsDate = (date) => date.toISOString().replace(/[-:]/g, '').split('.')[0] + 'Z';

    const generateIcs = () => {
      if (!nextPickupData) {
        showToast?.('info', 'Select your area first to add a reminder.');
        return null;
      }
      const start = new Date(nextPickupData.datetime_iso);
      const end = new Date(start.getTime() + 60 * 60 * 1000);
      return [
        'BEGIN:VCALENDAR',
        'VERSION:2.0',
        'PRODID:-//Cleanify//Schedule//EN',
        'BEGIN:VEVENT',
        `UID:${Date.now()}@cleanify`,
        `DTSTAMP:${formatIcsDate(new Date())}`,
        `DTSTART:${formatIcsDate(start)}`,
        `DTEND:${formatIcsDate(end)}`,
        `SUMMARY:Garbage pickup - ${nextPickupData.area}`,
        `DESCRIPTION:Truck ${nextPickupData.truck} · ${nextPickupData.waste_type}`,
        'END:VEVENT',
        'END:VCALENDAR',
      ].join('\r\n');
    };

    document.getElementById('addToCalendarBtn')?.addEventListener('click', () => {
      const ics = generateIcs();
      if (!ics) return;
      const blob = new Blob([ics], { type: 'text/calendar' });
      const url = URL.createObjectURL(blob);
      const link = document.createElement('a');
      link.href = url;
      link.download = 'cleanify-pickup.ics';
      link.click();
      URL.revokeObjectURL(url);
    });

    document.getElementById('downloadIcsBtn')?.addEventListener('click', () => {
      const ics = generateIcs();
      if (!ics) return;
      const blob = new Blob([ics], { type: 'text/calendar' });
      const url = URL.createObjectURL(blob);
      const link = document.createElement('a');
      link.href = url;
      link.download = 'cleanify-schedule.ics';
      link.click();
      URL.revokeObjectURL(url);
    });

    document.getElementById('printScheduleBtn')?.addEventListener('click', () => window.print());

    document.getElementById('shareScheduleBtn')?.addEventListener('click', async () => {
      const shareData = {
        title: 'Cleanify Schedule',
        text: 'Here is the latest garbage collection schedule.',
        url: window.location.href,
      };
      if (navigator.share) {
        try {
          await navigator.share(shareData);
        } catch (_) {
          // user cancelled
        }
      } else {
        await navigator.clipboard.writeText(window.location.href);
        showToast?.('success', 'Link copied to clipboard.');
      }
    });

    applyScheduleFilters();
    renderCalendar(currentMonth, currentYear);
  </script>
@endpush

@push('modals')
  <x-modal id="dayDetailsModal" title="Day Schedule" icon="fas fa-calendar" color="green">
    <div id="dayDetailsBody" class="space-y-3 text-sm text-gray-700">
    </div>

    @slot('footer')
      <div class="flex justify-end">
        <button onclick="closeModal('dayDetailsModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">Close</button>
      </div>
    @endslot
  </x-modal>
@endpush
