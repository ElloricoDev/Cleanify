@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
  <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
    <div>
      <h2 class="text-3xl font-bold text-gray-800">
        <i class="fas fa-flag text-green-600 mr-3"></i>Reports Management
      </h2>
      <p class="text-gray-600 mt-1">Manage and resolve community reports</p>
    </div>
    <div class="flex w-full lg:w-auto max-w-lg">
      <input id="reportSearchInput" type="text" class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Search reports...">
      <button onclick="filterReports()" class="px-4 bg-green-600 text-white rounded-r-lg hover:bg-green-700 transition-colors duration-300">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <x-admin.stat-card icon="fas fa-clock" title="Pending Reports" value="12" borderClass="border-l-4 border-yellow-500" iconWrapperClass="bg-yellow-100" iconColorClass="text-yellow-600" />
    <x-admin.stat-card icon="fas fa-check-circle" title="Resolved" value="8" borderClass="border-l-4 border-green-500" iconWrapperClass="bg-green-100" iconColorClass="text-green-600" />
    <x-admin.stat-card icon="fas fa-times-circle" title="Rejected" value="3" borderClass="border-l-4 border-red-500" iconWrapperClass="bg-red-100" iconColorClass="text-red-600" />
    <x-admin.stat-card icon="fas fa-chart-line" title="This Month" value="23" borderClass="border-l-4 border-blue-500" iconWrapperClass="bg-blue-100" iconColorClass="text-blue-600" />
  </div>

  @php
    $reports = [
      [
        'id' => 1,
        'reporter' => 'Maria Lopez',
        'handle' => '@MariaLopez',
        'location' => 'Barangay Lakandula',
        'description' => 'Uncollected garbage near basketball court.',
        'image' => 'https://picsum.photos/60?1',
        'status' => 'Pending',
        'status_badge' => 'text-yellow-600',
        'date' => 'Oct 10, 2025',
      ],
      [
        'id' => 2,
        'reporter' => 'John Doe',
        'handle' => '@JohnDoe',
        'location' => 'Purok 3',
        'description' => 'Overflowing trash bins beside market area.',
        'image' => 'https://picsum.photos/60?2',
        'status' => 'Resolved',
        'status_badge' => 'text-green-600',
        'date' => 'Oct 7, 2025',
      ],
      [
        'id' => 3,
        'reporter' => 'Ella Mae',
        'handle' => '@EllaMae',
        'location' => 'Zone 5',
        'description' => 'Dump site blocking the road.',
        'image' => 'https://picsum.photos/60?3',
        'status' => 'Rejected',
        'status_badge' => 'text-red-600',
        'date' => 'Oct 5, 2025',
      ],
    ];
  @endphp

  <div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full" id="reportsTable">
        <thead>
          <tr class="bg-green-600 text-white">
            @foreach (['#','Reporter','Location','Description','Image','Status','Date Reported','Actions'] as $heading)
              <th class="px-4 py-3 text-left text-sm font-semibold">{{ $heading }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200" id="reportsTableBody">
          @foreach ($reports as $report)
            <tr class="hover:bg-gray-50 transition-colors duration-200" data-report="{{ json_encode($report) }}">
              <td class="px-4 py-3">{{ $report['id'] }}</td>
              <td class="px-4 py-3 font-medium text-gray-900">{{ $report['reporter'] }}</td>
              <td class="px-4 py-3 text-gray-600">{{ $report['location'] }}</td>
              <td class="px-4 py-3 text-gray-600 max-w-xs">{{ $report['description'] }}</td>
              <td class="px-4 py-3">
                <img src="{{ $report['image'] }}" class="w-12 h-12 rounded object-cover" alt="Report image">
              </td>
              <td class="px-4 py-3">
                <span class="{{ $report['status_badge'] }} font-semibold">
                  <i class="fas fa-circle text-xs mr-1"></i>{{ $report['status'] }}
                </span>
              </td>
              <td class="px-4 py-3 text-gray-600">{{ $report['date'] }}</td>
              <td class="px-4 py-3">
                <div class="flex space-x-2">
                  <button onclick="openResolveModal({{ $report['id'] }})" class="w-8 h-8 bg-green-500 text-white rounded hover:bg-green-600 transition-colors duration-300">
                    <i class="fas fa-check text-xs"></i>
                  </button>
                  <button onclick="openRejectModal({{ $report['id'] }})" class="w-8 h-8 bg-red-500 text-white rounded hover:bg-red-600 transition-colors duration-300">
                    <i class="fas fa-times text-xs"></i>
                  </button>
                  <button onclick="openReportView({{ $report['id'] }})" class="w-8 h-8 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors duration-300">
                    <i class="fas fa-eye text-xs"></i>
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
        <div class="text-sm text-gray-600">Showing 1 to 3 of 23 entries</div>
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
  <x-modal id="viewReportModal" title="Report Details" icon="fas fa-eye" color="green">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div><img id="viewReportImage" src="" class="w-full h-64 object-cover rounded-lg" alt="Report preview"></div>
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Reporter</label>
          <p id="viewReportReporter" class="mt-1 text-lg font-semibold"></p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Location</label>
          <p id="viewReportLocation" class="mt-1 text-gray-900"></p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Status</label>
          <span id="viewReportStatus" class="mt-1 font-semibold"></span>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Date Reported</label>
          <p id="viewReportDate" class="mt-1 text-gray-900"></p>
        </div>
      </div>
    </div>
    <div class="mt-6">
      <label class="block text-sm font-medium text-gray-700">Description</label>
      <p id="viewReportDescription" class="mt-2 text-gray-900 bg-gray-50 p-4 rounded-lg"></p>
    </div>
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('viewReportModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
          <i class="fas fa-times mr-2"></i>Close
        </button>
        <button onclick="openResolveModalFromView()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
          <i class="fas fa-check mr-2"></i>Mark as Resolved
        </button>
      </div>
    @endslot
  </x-modal>

  <x-modal id="resolveReportModal" title="Resolve Report" icon="fas fa-check-circle" color="green">
    <div class="text-center mb-4">
      <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-check text-green-600 text-2xl"></i>
      </div>
      <h4 class="text-xl font-semibold text-gray-800 mb-2">Confirm Resolution</h4>
      <p class="text-gray-600">Are you sure you want to mark this report as resolved?</p>
    </div>
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-2">
        <i class="fas fa-comment mr-2 text-green-600"></i>Resolution Notes (Optional)
      </label>
      <textarea id="resolveNotes" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none" rows="3" placeholder="Add any notes about how this report was resolved..."></textarea>
    </div>
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4 flex">
      <i class="fas fa-info-circle text-blue-400 mr-3 mt-1"></i>
      <p class="text-sm text-blue-700">This will notify the reporter that their issue has been resolved.</p>
    </div>
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('resolveReportModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button onclick="confirmResolveReport()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
          <i class="fas fa-check mr-2"></i>Mark as Resolved
        </button>
      </div>
    @endslot
  </x-modal>

  <x-modal id="rejectReportModal" title="Reject Report" icon="fas fa-times-circle" color="red">
    <div class="text-center mb-4">
      <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-exclamation text-red-600 text-2xl"></i>
      </div>
      <h4 class="text-xl font-semibold text-gray-800 mb-2">Reject Report</h4>
      <p class="text-gray-600">Are you sure you want to reject this report?</p>
    </div>
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-2">
        <i class="fas fa-comment mr-2 text-red-600"></i>Rejection Reason (Required)
      </label>
      <textarea id="rejectReason" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none" rows="3" placeholder="Please provide a reason for rejecting this report..." required></textarea>
    </div>
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 flex">
      <i class="fas fa-exclamation-triangle text-yellow-400 mr-3 mt-1"></i>
      <p class="text-sm text-yellow-700">
        This action cannot be undone. The reporter will be notified about the rejection.
      </p>
    </div>
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('rejectReportModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button onclick="confirmRejectReport()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300">
          <i class="fas fa-times mr-2"></i>Reject Report
        </button>
      </div>
    @endslot
  </x-modal>
@endpush

@push('scripts')
  <script>
    const adminReports = @json($reports);
    let currentReportId = null;

    function getReport(id) {
      return adminReports.find(r => r.id === Number(id));
    }

    function openReportView(id) {
      const report = getReport(id);
      if (!report) return;
      currentReportId = id;
      document.getElementById('viewReportImage').src = report.image.replace('60', '400');
      document.getElementById('viewReportReporter').textContent = `${report.reporter} (${report.handle})`;
      document.getElementById('viewReportLocation').textContent = report.location;
      document.getElementById('viewReportStatus').textContent = report.status;
      document.getElementById('viewReportDate').textContent = report.date;
      document.getElementById('viewReportDescription').textContent = report.description;
      openModal('viewReportModal');
    }

    function openResolveModal(id) {
      currentReportId = id;
      document.getElementById('resolveNotes').value = '';
      openModal('resolveReportModal');
    }

    function openRejectModal(id) {
      currentReportId = id;
      document.getElementById('rejectReason').value = '';
      openModal('rejectReportModal');
    }

    function openResolveModalFromView() {
      closeModal('viewReportModal');
      setTimeout(() => openResolveModal(currentReportId), 300);
    }

    function confirmResolveReport() {
      alert(`Report #${currentReportId} marked as resolved!`);
      closeModal('resolveReportModal');
    }

    function confirmRejectReport() {
      const reason = document.getElementById('rejectReason').value.trim();
      if (!reason) {
        alert('Please provide a rejection reason.');
        return;
      }
      alert(`Report #${currentReportId} has been rejected.\nReason: ${reason}`);
      closeModal('rejectReportModal');
    }

    function filterReports() {
      const query = document.getElementById('reportSearchInput').value.toLowerCase();
      document.querySelectorAll('#reportsTableBody tr').forEach(row => {
        const data = JSON.parse(row.dataset.report);
        const match = data.reporter.toLowerCase().includes(query)
          || data.location.toLowerCase().includes(query)
          || data.description.toLowerCase().includes(query);
        row.style.display = match ? '' : 'none';
      });
    }
  </script>
@endpush

