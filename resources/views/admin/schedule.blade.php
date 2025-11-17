@extends('layouts.admin')

@section('title', 'Schedule')

@section('content')
  <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
    <div>
      <h2 class="text-3xl font-bold text-gray-800">
        <i class="fas fa-calendar-alt text-green-600 mr-3"></i>Garbage Collection Schedule
      </h2>
      <p class="text-gray-600 mt-1">Manage garbage collection schedules for different areas</p>
    </div>
    <div class="flex w-full lg:w-auto max-w-lg">
      <input id="scheduleSearchInput" type="text" class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Search schedule...">
      <button onclick="filterSchedules()" class="px-4 bg-green-600 text-white rounded-r-lg hover:bg-green-700 transition-colors duration-300">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <x-admin.stat-card icon="fas fa-calendar-check" title="Active Schedules" value="3" />
    <x-admin.stat-card icon="fas fa-truck" title="Trucks Assigned" value="5" borderClass="border-l-4 border-blue-500" iconWrapperClass="bg-blue-100" iconColorClass="text-blue-600" />
    <x-admin.stat-card icon="fas fa-clock" title="Pending Schedules" value="1" borderClass="border-l-4 border-yellow-500" iconWrapperClass="bg-yellow-100" iconColorClass="text-yellow-600" />
    <x-admin.stat-card icon="fas fa-calendar-times" title="Inactive Schedules" value="1" borderClass="border-l-4 border-red-500" iconWrapperClass="bg-red-100" iconColorClass="text-red-600" />
  </div>

  @php
    $schedules = [
      ['id'=>1,'area'=>'Barangay Lakandula','days'=>'Monday & Thursday','time'=>'6:00 AM - 9:00 AM','truck'=>'Truck 01','status'=>'Active'],
      ['id'=>2,'area'=>'Purok 3','days'=>'Tuesday & Friday','time'=>'7:00 AM - 10:00 AM','truck'=>'Truck 02','status'=>'Active'],
      ['id'=>3,'area'=>'Zone 5','days'=>'Wednesday','time'=>'8:00 AM - 11:00 AM','truck'=>'Truck 03','status'=>'Pending'],
      ['id'=>4,'area'=>'Purok 1','days'=>'Saturday','time'=>'6:30 AM - 9:30 AM','truck'=>'Truck 04','status'=>'Active'],
      ['id'=>5,'area'=>'Purok 6','days'=>'Sunday','time'=>'7:00 AM - 10:00 AM','truck'=>'Truck 05','status'=>'Inactive'],
    ];
    $statusBadge = [
      'Active' => 'bg-green-100 text-green-800',
      'Pending' => 'bg-yellow-100 text-yellow-800',
      'Inactive' => 'bg-red-100 text-red-800',
    ];
  @endphp

  <div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 flex justify-between items-center">
      <h5 class="font-semibold text-lg text-gray-800">Community Garbage Schedules</h5>
      <button onclick="openAddScheduleModal()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
        <i class="fas fa-plus-circle mr-2"></i>Add Schedule
      </button>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full" id="scheduleTable">
        <thead>
          <tr class="bg-green-600 text-white">
            @foreach (['#','Barangay / Zone','Collection Day','Time','Truck Assigned','Status','Actions'] as $heading)
              <th class="px-4 py-3 text-left text-sm font-semibold">{{ $heading }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody id="scheduleTableBody" class="divide-y divide-gray-200">
          @foreach ($schedules as $schedule)
            <tr class="hover:bg-gray-50 transition-colors duration-200" data-schedule="{{ json_encode($schedule) }}">
              <td class="px-4 py-3">{{ $schedule['id'] }}</td>
              <td class="px-4 py-3 font-medium text-gray-900">{{ $schedule['area'] }}</td>
              <td class="px-4 py-3 text-gray-600">{{ $schedule['days'] }}</td>
              <td class="px-4 py-3 text-gray-600">{{ $schedule['time'] }}</td>
              <td class="px-4 py-3 text-gray-600">{{ $schedule['truck'] }}</td>
              <td class="px-4 py-3">
                <span class="{{ $statusBadge[$schedule['status']] ?? 'bg-gray-100 text-gray-800' }} text-xs font-medium px-2.5 py-0.5 rounded-full">
                  <i class="fas fa-circle text-xs mr-1"></i>{{ $schedule['status'] }}
                </span>
              </td>
              <td class="px-4 py-3">
                <div class="flex space-x-2">
                  <button onclick="openEditScheduleModal({{ $schedule['id'] }})" class="w-8 h-8 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors duration-300">
                    <i class="fas fa-edit text-xs"></i>
                  </button>
                  <button onclick="openDeleteScheduleModal({{ $schedule['id'] }})" class="w-8 h-8 bg-red-500 text-white rounded hover:bg-red-600 transition-colors duration-300">
                    <i class="fas fa-trash text-xs"></i>
                  </button>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-200">
      <nav class="flex justify-between items-center">
        <div class="text-sm text-gray-600">Showing 1 to 5 of 5 entries</div>
        <ul class="flex space-x-2">
          <li><button class="px-3 py-1 text-gray-500 bg-gray-100 rounded cursor-not-allowed"><i class="fas fa-chevron-left mr-1"></i>Previous</button></li>
          <li><button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition-colors duration-300">1</button></li>
          <li><button class="px-3 py-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors duration-300">2</button></li>
          <li><button class="px-3 py-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors duration-300">3</button></li>
          <li><button class="px-3 py-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors duration-300">Next<i class="fas fa-chevron-right ml-1"></i></button></li>
        </ul>
      </nav>
    </div>
  </div>
@endsection

@push('modals')
  <x-modal id="addScheduleModal" title="Add Schedule" icon="fas fa-plus-circle" color="green">
    <form id="addScheduleForm" class="space-y-4">
      @foreach ([
        ['label' => 'Barangay / Zone', 'icon' => 'fas fa-map-marker-alt', 'name' => 'area', 'type' => 'text', 'placeholder' => 'Enter location'],
      ] as $field)
        <div>
          <label class="block text-gray-700 mb-2">
            <i class="{{ $field['icon'] }} mr-2 text-green-600"></i>{{ $field['label'] }}
          </label>
          <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="{{ $field['placeholder'] }}">
        </div>
      @endforeach
      <div>
        <label class="block text-gray-700 mb-2">
          <i class="fas fa-calendar-day mr-2 text-green-600"></i>Collection Days
        </label>
        <select name="days" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
          @foreach (['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday','Monday & Thursday','Tuesday & Friday'] as $option)
            <option value="{{ $option }}">{{ $option }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-gray-700 mb-2">
          <i class="fas fa-clock mr-2 text-green-600"></i>Collection Time
        </label>
        <div class="flex space-x-2">
          <input type="time" name="time_start" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="06:00">
          <span class="self-center">to</span>
          <input type="time" name="time_end" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="09:00">
        </div>
      </div>
      <div>
        <label class="block text-gray-700 mb-2">
          <i class="fas fa-truck mr-2 text-green-600"></i>Truck Assigned
        </label>
        <select name="truck" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
          @foreach (['Truck 01','Truck 02','Truck 03','Truck 04','Truck 05'] as $truck)
            <option value="{{ $truck }}">{{ $truck }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-gray-700 mb-2">
          <i class="fas fa-circle mr-2 text-green-600"></i>Status
        </label>
        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
          @foreach (['Active','Pending','Inactive'] as $status)
            <option value="{{ $status }}">{{ $status }}</option>
          @endforeach
        </select>
      </div>
    </form>
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('addScheduleModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button onclick="saveNewSchedule()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
          <i class="fas fa-save mr-2"></i>Save Schedule
        </button>
      </div>
    @endslot
  </x-modal>

  <x-modal id="editScheduleModal" title="Edit Schedule" icon="fas fa-edit" color="green">
    <form id="editScheduleForm" class="space-y-4">
      <input type="hidden" name="id">
      <div>
        <label class="block text-gray-700 mb-2">
          <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>Barangay / Zone
        </label>
        <input type="text" name="area" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
      </div>
      <div>
        <label class="block text-gray-700 mb-2">
          <i class="fas fa-calendar-day mr-2 text-blue-600"></i>Collection Days
        </label>
        <input type="text" name="days" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
      </div>
      <div>
        <label class="block text-gray-700 mb-2">
          <i class="fas fa-clock mr-2 text-blue-600"></i>Collection Time
        </label>
        <input type="text" name="time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
      </div>
      <div>
        <label class="block text-gray-700 mb-2">
          <i class="fas fa-truck mr-2 text-blue-600"></i>Truck Assigned
        </label>
        <input type="text" name="truck" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
      </div>
      <div>
        <label class="block text-gray-700 mb-2">
          <i class="fas fa-circle mr-2 text-blue-600"></i>Status
        </label>
        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          @foreach (['Active','Pending','Inactive'] as $status)
            <option value="{{ $status }}">{{ $status }}</option>
          @endforeach
        </select>
      </div>
    </form>
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('editScheduleModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button onclick="saveScheduleChanges()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
          <i class="fas fa-save mr-2"></i>Save Changes
        </button>
      </div>
    @endslot
  </x-modal>

  <x-modal id="deleteScheduleModal" title="Delete Schedule" icon="fas fa-exclamation-triangle" color="red">
    <div class="text-center">
      <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-exclamation text-red-600 text-2xl"></i>
      </div>
      <h4 class="text-xl font-semibold text-gray-800 mb-2">Confirm Deletion</h4>
      <p class="text-gray-600 mb-4">Are you sure you want to delete this schedule? This action cannot be undone.</p>
      <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 text-left flex">
        <i class="fas fa-exclamation-circle text-yellow-400 mr-3 mt-1"></i>
        <p class="text-sm text-yellow-700">This will permanently remove the schedule and may affect garbage collection in the area.</p>
      </div>
    </div>
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('deleteScheduleModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button onclick="confirmDeleteSchedule()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300">
          <i class="fas fa-trash mr-2"></i>Delete Schedule
        </button>
      </div>
    @endslot
  </x-modal>
@endpush

@push('scripts')
  <script>
    let currentScheduleId = null;

    function openAddScheduleModal() {
      openModal('addScheduleModal');
    }

    function saveNewSchedule() {
      alert('New schedule added successfully!');
      document.getElementById('addScheduleForm').reset();
      closeModal('addScheduleModal');
    }

    function openEditScheduleModal(id) {
      currentScheduleId = id;
      const schedule = getScheduleData(id);
      if (!schedule) return;
      const form = document.getElementById('editScheduleForm');
      form.id.value = schedule.id;
      form.area.value = schedule.area;
      form.days.value = schedule.days;
      form.time.value = schedule.time;
      form.truck.value = schedule.truck;
      form.status.value = schedule.status;
      openModal('editScheduleModal');
    }

    function saveScheduleChanges() {
      alert(`Schedule #${currentScheduleId} updated successfully!`);
      closeModal('editScheduleModal');
    }

    function openDeleteScheduleModal(id) {
      currentScheduleId = id;
      openModal('deleteScheduleModal');
    }

    function confirmDeleteSchedule() {
      alert(`Schedule #${currentScheduleId} deleted successfully!`);
      closeModal('deleteScheduleModal');
    }

    function getScheduleData(id) {
      const row = document.querySelector(`#scheduleTableBody tr[data-schedule*="\"id\":${id}"]`);
      return row ? JSON.parse(row.dataset.schedule) : null;
    }

    function filterSchedules() {
      const query = document.getElementById('scheduleSearchInput').value.toLowerCase();
      document.querySelectorAll('#scheduleTableBody tr').forEach(row => {
        const data = JSON.parse(row.dataset.schedule);
        const match = data.area.toLowerCase().includes(query)
          || data.days.toLowerCase().includes(query)
          || data.truck.toLowerCase().includes(query);
        row.style.display = match ? '' : 'none';
      });
    }
  </script>
@endpush

