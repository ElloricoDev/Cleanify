@extends('layouts.admin')

@section('title', 'Tracker')

@push('styles')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
  <style>
    #adminTruckMap {
      height: 400px;
      border-radius: 10px;
      z-index: 1;
    }
  </style>
@endpush

@section('content')
  <div class="mb-6">
    <h2 class="text-3xl font-bold text-gray-800">
      <i class="fas fa-truck text-green-600 mr-3"></i>Garbage Truck Tracker 🚛
    </h2>
    <p class="text-gray-600 mt-1">Monitor garbage truck locations and routes in real-time</p>
  </div>

  <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex items-center mb-4">
      <i class="fas fa-map-marked-alt text-green-600 text-xl mr-3"></i>
      <h3 class="text-xl font-semibold text-gray-800">Live Tracker (Demo Map)</h3>
    </div>
    <div id="adminTruckMap"></div>
    <p class="text-gray-500 mt-4">
      This is a <span class="font-semibold">dummy map preview</span> for admin to visualize garbage truck routes and active areas.
      Integrate with Google Maps or Mapbox API for live tracking later.
    </p>
    <button id="adminUpdateLocation" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
      <i class="fas fa-location-arrow mr-2"></i>Update Truck Location
    </button>
  </div>

  @php
    $trucks = [
      ['id'=>1,'code'=>'TRK-001','driver'=>'Juan Dela Cruz','route'=>'Zone 1 - Lakandula','status'=>'Active','status_badge'=>'bg-green-100 text-green-800','updated'=>'5 mins ago'],
      ['id'=>2,'code'=>'TRK-002','driver'=>'Maria Santos','route'=>'Zone 2 - San Jose','status'=>'On Break','status_badge'=>'bg-yellow-100 text-yellow-800','updated'=>'20 mins ago'],
      ['id'=>3,'code'=>'TRK-003','driver'=>'Pedro Ramos','route'=>'Zone 3 - San Rafael','status'=>'Offline','status_badge'=>'bg-red-100 text-red-800','updated'=>'1 hour ago'],
    ];
  @endphp

  <div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 flex justify-between items-center">
      <div class="flex items-center">
        <i class="fas fa-truck text-green-600 text-xl mr-3"></i>
        <h3 class="text-xl font-semibold text-gray-800">Active Garbage Trucks</h3>
      </div>
      <button onclick="openModal('addTruckModal')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
        <i class="fas fa-plus-circle mr-2"></i>Add Truck
      </button>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="bg-green-600 text-white">
            @foreach (['#','Truck ID','Driver','Route','Status','Last Updated','Actions'] as $heading)
              <th class="px-4 py-3 text-left text-sm font-semibold">{{ $heading }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200" id="truckTableBody">
          @foreach ($trucks as $truck)
            <tr class="hover:bg-gray-50 transition-colors duration-200" data-truck="{{ json_encode($truck) }}">
              <td class="px-4 py-3">{{ $truck['id'] }}</td>
              <td class="px-4 py-3 font-medium text-gray-900">{{ $truck['code'] }}</td>
              <td class="px-4 py-3 text-gray-600">{{ $truck['driver'] }}</td>
              <td class="px-4 py-3 text-gray-600">{{ $truck['route'] }}</td>
              <td class="px-4 py-3">
                <span class="{{ $truck['status_badge'] }} text-xs font-medium px-2.5 py-0.5 rounded-full">
                  <i class="fas fa-circle text-xs mr-1"></i>{{ $truck['status'] }}
                </span>
              </td>
              <td class="px-4 py-3 text-gray-600">{{ $truck['updated'] }}</td>
              <td class="px-4 py-3">
                <div class="flex space-x-2">
                  <button onclick="openTruckView({{ $truck['id'] }})" class="w-8 h-8 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors duration-300">
                    <i class="fas fa-eye text-xs"></i>
                  </button>
                  <button onclick="editTruck({{ $truck['id'] }})" class="w-8 h-8 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition-colors duration-300">
                    <i class="fas fa-edit text-xs"></i>
                  </button>
                  <button onclick="openTruckDelete({{ $truck['id'] }})" class="w-8 h-8 bg-red-500 text-white rounded hover:bg-red-600 transition-colors duration-300">
                    <i class="fas fa-trash text-xs"></i>
                  </button>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

@push('modals')
  <x-modal id="viewTruckModal" title="Truck Details" icon="fas fa-truck" color="green">
    <div class="flex flex-col md:flex-row items-center md:items-start gap-6 mb-6">
      <div class="flex-shrink-0">
        <div class="w-32 h-32 bg-blue-100 rounded-full flex items-center justify-center">
          <i class="fas fa-truck text-blue-600 text-4xl"></i>
        </div>
      </div>
      <div class="flex-1 text-center md:text-left">
        <h3 id="viewTruckCode" class="text-2xl font-bold text-gray-800 mb-2"></h3>
        <div class="flex flex-wrap gap-2 justify-center md:justify-start mb-4" id="viewTruckBadges"></div>
        <p class="text-gray-600">
          <i class="fas fa-user mr-2 text-blue-600"></i><span id="viewTruckDriver"></span>
        </p>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <div class="bg-gray-50 rounded-lg p-4" id="viewTruckInfo"></div>
      <div class="bg-gray-50 rounded-lg p-4" id="viewTruckRoute"></div>
    </div>
    <div class="bg-gray-50 rounded-lg p-4" id="viewTruckStats"></div>
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('viewTruckModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
          <i class="fas fa-times mr-2"></i>Close
        </button>
        <button onclick="editTruckFromView()" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-300">
          <i class="fas fa-edit mr-2"></i>Edit Truck
        </button>
      </div>
    @endslot
  </x-modal>

  <x-modal id="addTruckModal" title="Add New Truck" icon="fas fa-plus-circle" color="green">
    <form id="addTruckForm" class="space-y-4">
      <div>
        <label class="block text-gray-700 mb-2"><i class="fas fa-id-card mr-2 text-green-600"></i>Truck ID</label>
        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="TRK-001">
      </div>
      <div>
        <label class="block text-gray-700 mb-2"><i class="fas fa-user mr-2 text-green-600"></i>Driver Name</label>
        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Juan Dela Cruz">
      </div>
      <div>
        <label class="block text-gray-700 mb-2"><i class="fas fa-route mr-2 text-green-600"></i>Route</label>
        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
          @foreach (['Zone 1 - Lakandula','Zone 2 - San Jose','Zone 3 - San Rafael','Zone 4 - San Roque'] as $route)
            <option value="{{ $route }}">{{ $route }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-gray-700 mb-2"><i class="fas fa-circle mr-2 text-green-600"></i>Status</label>
        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
          @foreach (['Active','On Break','Offline','Maintenance'] as $status)
            <option value="{{ $status }}">{{ $status }}</option>
          @endforeach
        </select>
      </div>
    </form>
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('addTruckModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button onclick="saveNewTruck()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
          <i class="fas fa-save mr-2"></i>Save Truck
        </button>
      </div>
    @endslot
  </x-modal>

  <x-modal id="deleteTruckModal" title="Delete Truck" icon="fas fa-exclamation-triangle" color="red">
    <div class="text-center">
      <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-exclamation text-red-600 text-2xl"></i>
      </div>
      <h4 class="text-xl font-semibold text-gray-800 mb-2">Confirm Deletion</h4>
      <p class="text-gray-600 mb-4">Are you sure you want to delete this truck? This action cannot be undone.</p>
      <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 text-left flex">
        <i class="fas fa-exclamation-circle text-yellow-400 mr-3 mt-1"></i>
        <p class="text-sm text-yellow-700">
          This will permanently remove the truck from the system and all associated data.
        </p>
      </div>
    </div>
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('deleteTruckModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button onclick="confirmDeleteTruck()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300">
          <i class="fas fa-trash mr-2"></i>Delete Truck
        </button>
      </div>
    @endslot
  </x-modal>
@endpush

@push('scripts')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script>
    const truckData = @json($trucks);
    let currentTruckId = null;

    const map = L.map('adminTruckMap').setView([15.1375, 120.5894], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
    const truckIcon = L.icon({
      iconUrl: 'https://cdn-icons-png.flaticon.com/512/743/743131.png',
      iconSize: [40, 40],
      iconAnchor: [20, 40],
      popupAnchor: [0, -35],
    });
    const routePoints = [
      [15.1375, 120.5894],
      [15.14, 120.592],
      [15.142, 120.595],
      [15.1445, 120.599],
      [15.146, 120.6025],
    ];
    let routeIndex = 0;
    const truckMarker = L.marker(routePoints[0], { icon: truckIcon })
      .addTo(map)
      .bindPopup('<b>Cleanify Truck 01</b><br>Currently at Barangay Lakandula')
      .openPopup();

    function moveTruckMarker() {
      routeIndex = (routeIndex + 1) % routePoints.length;
      const [lat, lng] = routePoints[routeIndex];
      truckMarker.setLatLng([lat, lng]);
      truckMarker.setPopupContent(`<b>Cleanify Truck 01</b><br>Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}`);
      map.panTo([lat, lng]);
    }

    document.getElementById('adminUpdateLocation').addEventListener('click', moveTruckMarker);

    function openTruckView(id) {
      currentTruckId = id;
      const truck = truckData.find(t => t.id === id);
      if (!truck) return;
      document.getElementById('viewTruckCode').textContent = truck.code;
      document.getElementById('viewTruckDriver').textContent = truck.driver;
      document.getElementById('viewTruckBadges').innerHTML = `
        <span class="${truck.status_badge} text-sm font-medium px-3 py-1 rounded-full">
          <i class="fas fa-circle text-xs mr-1"></i>${truck.status}
        </span>
        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
          <i class="fas fa-route mr-1"></i>${truck.route}
        </span>`;
      document.getElementById('viewTruckInfo').innerHTML = `
        <h4 class="font-semibold text-gray-800 mb-3"><i class="fas fa-info-circle mr-2 text-blue-600"></i>Truck Information</h4>
        <div class="space-y-2">
          <div class="flex justify-between"><span class="text-gray-600">Truck ID:</span><span class="font-medium">${truck.code}</span></div>
          <div class="flex justify-between"><span class="text-gray-600">Driver:</span><span class="font-medium">${truck.driver}</span></div>
          <div class="flex justify-between"><span class="text-gray-600">Status:</span><span class="font-medium">${truck.status}</span></div>
        </div>`;
      document.getElementById('viewTruckRoute').innerHTML = `
        <h4 class="font-semibold text-gray-800 mb-3"><i class="fas fa-route mr-2 text-blue-600"></i>Route Information</h4>
        <div class="space-y-2">
          <div class="flex justify-between"><span class="text-gray-600">Current Route:</span><span class="font-medium">${truck.route}</span></div>
          <div class="flex justify-between"><span class="text-gray-600">Last Updated:</span><span class="font-medium">${truck.updated}</span></div>
        </div>`;
      document.getElementById('viewTruckStats').innerHTML = `
        <h4 class="font-semibold text-gray-800 mb-3"><i class="fas fa-chart-line mr-2 text-blue-600"></i>Performance Stats</h4>
        <div class="space-y-2">
          <div class="flex justify-between"><span class="text-gray-600">Collections Today:</span><span class="font-medium">42 stops</span></div>
          <div class="flex justify-between"><span class="text-gray-600">Avg. Collection Time:</span><span class="font-medium">8.2 mins/stop</span></div>
          <div class="flex justify-between"><span class="text-gray-600">Fuel Efficiency:</span><span class="font-medium text-green-600">4.8 km/L</span></div>
        </div>`;
      openModal('viewTruckModal');
    }

    function editTruck(id) {
      alert(`Edit truck functionality would open for truck ID: ${id}`);
    }

    function editTruckFromView() {
      closeModal('viewTruckModal');
      setTimeout(() => editTruck(currentTruckId), 300);
    }

    function saveNewTruck() {
      alert('New truck added successfully!');
      document.getElementById('addTruckForm').reset();
      closeModal('addTruckModal');
    }

    function openTruckDelete(id) {
      currentTruckId = id;
      openModal('deleteTruckModal');
    }

    function confirmDeleteTruck() {
      alert(`Truck #${currentTruckId} deleted successfully!`);
      closeModal('deleteTruckModal');
    }
  </script>
@endpush

