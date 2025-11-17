@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
  <style>
    .dashboard-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.5rem;
    }
  </style>
@endpush

@section('content')
  <h2 class="text-3xl font-bold text-gray-800 mb-6">Welcome, Admin 👋</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <x-admin.stat-card icon="fas fa-users" title="Total Users" value="145" />
    <x-admin.stat-card icon="fas fa-bullhorn" title="Reports" value="32" borderClass="border-l-4 border-blue-500" iconWrapperClass="bg-blue-100" iconColorClass="text-blue-600" />
    <x-admin.stat-card icon="fas fa-images" title="Posts" value="87" borderClass="border-l-4 border-purple-500" iconWrapperClass="bg-purple-100" iconColorClass="text-purple-600" />
    <x-admin.stat-card icon="fas fa-truck" title="Garbage Trucks" value="5 Active" borderClass="border-l-4 border-orange-500" iconWrapperClass="bg-orange-100" iconColorClass="text-orange-600" />
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
      <h5 class="text-lg font-semibold text-gray-800 mb-4">
        <i class="fas fa-chart-bar mr-2 text-green-600"></i>Reports Overview
      </h5>
      <div class="h-80">
        <canvas id="reportsChart"></canvas>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
      <h5 class="text-lg font-semibold text-gray-800 mb-4">
        <i class="fas fa-chart-pie mr-2 text-green-600"></i>User Roles
      </h5>
      <div class="h-80">
        <canvas id="usersChart"></canvas>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
      <h4 class="text-xl font-semibold text-gray-800">Recent Reports</h4>
      <button onclick="openModal('newReportModal')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300 text-sm">
        <i class="fas fa-plus-circle mr-2"></i>New Report
      </button>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full table-auto">
        <thead>
          <tr class="bg-green-600 text-white">
            <th class="px-4 py-3 text-left">#</th>
            <th class="px-4 py-3 text-left">User</th>
            <th class="px-4 py-3 text-left">Type</th>
            <th class="px-4 py-3 text-left">Status</th>
            <th class="px-4 py-3 text-left">Date</th>
            <th class="px-4 py-3 text-left">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @foreach ([
            ['@MariaLopez','Missed Pickup','Pending','Oct 14, 2025'],
            ['@JohnDoe','Overflowing Bin','Resolved','Oct 12, 2025'],
            ['@EllaMae','Illegal Dumping','Urgent','Oct 10, 2025'],
            ['@CarlosSantos','Broken Bin','Pending','Oct 08, 2025'],
          ] as $index => [$user,$type,$status,$date])
            @php
              $statusStyles = [
                'Pending' => 'bg-yellow-100 text-yellow-800',
                'Resolved' => 'bg-green-100 text-green-800',
                'Urgent' => 'bg-red-100 text-red-800',
              ];
            @endphp
            <tr class="hover:bg-gray-50 transition-colors duration-200">
              <td class="px-4 py-3">{{ $index + 1 }}</td>
              <td class="px-4 py-3 font-medium">{{ $user }}</td>
              <td class="px-4 py-3">{{ $type }}</td>
              <td class="px-4 py-3">
                <span class="{{ $statusStyles[$status] ?? 'bg-gray-100 text-gray-800' }} text-xs font-medium px-2.5 py-0.5 rounded-full">
                  {{ $status }}
                </span>
              </td>
              <td class="px-4 py-3">{{ $date }}</td>
              <td class="px-4 py-3">
                <button class="w-8 h-8 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors duration-300 mr-2">
                  <i class="fas fa-eye text-xs"></i>
                </button>
                <button class="w-8 h-8 bg-red-500 text-white rounded hover:bg-red-600 transition-colors duration-300">
                  <i class="fas fa-trash text-xs"></i>
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

@push('modals')
  <x-modal id="newReportModal" title="Create New Report" icon="fas fa-plus-circle" color="green">
    <form id="newReportForm" class="space-y-6">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          <i class="fas fa-tag mr-2 text-green-600"></i>Report Type
        </label>
        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
          <option value="">Select report type</option>
          <option value="missed_pickup">Missed Pickup</option>
          <option value="overflowing_bin">Overflowing Bin</option>
          <option value="illegal_dumping">Illegal Dumping</option>
          <option value="broken_bin">Broken Bin</option>
          <option value="other">Other</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>Location
        </label>
        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Enter location address or landmark">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          <i class="fas fa-file-alt mr-2 text-green-600"></i>Description
        </label>
        <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none" rows="4" placeholder="Provide detailed description of the issue..."></textarea>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          <i class="fas fa-exclamation-circle mr-2 text-green-600"></i>Priority Level
        </label>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          @foreach ([
            ['low','Low','Routine issue', false],
            ['medium','Medium','Needs attention', true],
            ['high','High','Urgent issue', false],
          ] as [$value,$label,$description,$checked])
            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
              <input type="radio" name="priority" value="{{ $value }}" class="text-green-600 focus:ring-green-500" {{ $checked ? 'checked' : '' }}>
              <span class="ml-3">
                <span class="block text-sm font-medium text-gray-700">{{ $label }}</span>
                <span class="block text-xs text-gray-500">{{ $description }}</span>
              </span>
            </label>
          @endforeach
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          <i class="fas fa-image mr-2 text-green-600"></i>Upload Images
        </label>
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition-colors duration-200">
          <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
          <p class="text-sm text-gray-600 mb-2">Drag and drop images here or click to browse</p>
          <input type="file" class="hidden" id="adminReportImages" accept="image/*" multiple>
          <button type="button" onclick="document.getElementById('adminReportImages').click()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-sm">
            <i class="fas fa-folder-open mr-2"></i>Browse Files
          </button>
        </div>
        <div id="adminReportPreview" class="mt-3 grid grid-cols-3 gap-2 hidden"></div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          <i class="fas fa-sticky-note mr-2 text-green-600"></i>Additional Notes (Optional)
        </label>
        <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none" rows="3" placeholder="Any additional information or instructions..."></textarea>
      </div>
    </form>

    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('newReportModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button onclick="submitNewAdminReport()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
          <i class="fas fa-paper-plane mr-2"></i>Submit Report
        </button>
      </div>
    @endslot
  </x-modal>
@endpush

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const reportsCtx = document.getElementById('reportsChart');
      if (reportsCtx) {
        new Chart(reportsCtx, {
          type: 'bar',
          data: {
            labels: ['Missed Pickup', 'Overflowing Bin', 'Illegal Dumping', 'Others'],
            datasets: [{
              label: 'Reports',
              data: [12, 9, 7, 4],
              backgroundColor: ['#16a34a', '#2563eb', '#eab308', '#dc2626']
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } }
          }
        });
      }

      const usersCtx = document.getElementById('usersChart');
      if (usersCtx) {
        new Chart(usersCtx, {
          type: 'pie',
          data: {
            labels: ['Users', 'Admins', 'Moderators'],
            datasets: [{
              data: [120, 15, 10],
              backgroundColor: ['#16a34a', '#2563eb', '#eab308']
            }]
          },
          options: { responsive: true, maintainAspectRatio: false }
        });
      }

      const uploadInput = document.getElementById('adminReportImages');
      if (uploadInput) {
        uploadInput.addEventListener('change', (e) => {
          const preview = document.getElementById('adminReportPreview');
          preview.innerHTML = '';
          if (!e.target.files.length) {
            preview.classList.add('hidden');
            return;
          }

          preview.classList.remove('hidden');
          Array.from(e.target.files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = (event) => {
              const img = document.createElement('img');
              img.src = event.target.result;
              img.className = 'w-full h-24 object-cover rounded-lg';
              preview.appendChild(img);
            };
            reader.readAsDataURL(file);
          });
        });
      }
    });

    function submitNewAdminReport() {
      alert('New report submitted successfully!');
      document.getElementById('newReportForm').reset();
      document.getElementById('adminReportPreview').classList.add('hidden');
      document.getElementById('adminReportPreview').innerHTML = '';
      closeModal('newReportModal');
    }
  </script>
@endpush

