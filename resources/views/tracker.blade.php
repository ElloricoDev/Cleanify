@extends('layouts.app')

@section('title', 'Garbage Truck Tracker')

@push('styles')
  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <style>
    #map {
      height: 65vh;
      z-index: 10;
    }
  </style>
@endpush

@section('content')
  <!-- Header -->
  <div class="flex justify-between items-center mb-6">
    <h4 class="text-green-600 font-semibold text-xl">
      <i class="fas fa-truck mr-3"></i>Garbage Truck Tracker
    </h4>
    <div class="relative w-80">
      <input type="text" placeholder="Search area..." class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
      <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
    </div>
  </div>

  <!-- Map -->
  <div id="map" class="rounded-xl shadow-lg mb-6"></div>

  <!-- Info Card -->
  <div class="bg-white rounded-xl shadow-sm p-6">
    <h5 class="text-green-600 font-semibold text-lg mb-4">
      <i class="fas fa-truck mr-2"></i>Truck Status
    </h5>
    
    <div class="space-y-3 mb-4">
      <p><strong class="text-gray-700">Truck Name:</strong> Cleanify Truck 01</p>
      <p><strong class="text-gray-700">Current Location:</strong> <span id="location-name" class="text-green-600">Barangay Lakandula</span></p>
      <p><strong class="text-gray-700">Status:</strong> 
        <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded-full">On Route</span>
      </p>
    </div>

    <hr class="my-4">

    <div class="mb-4">
      <h6 class="font-semibold text-gray-700 mb-2">
        <i class="fas fa-clock mr-2"></i>Estimated Arrival
      </h6>
      <p id="eta" class="text-gray-600">Around 25 minutes to your area</p>
    </div>

    <hr class="my-4">

    <button id="updateLocation" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 rounded-lg transition-colors duration-300">
      <i class="fas fa-map-marker-alt mr-2"></i>Update Truck Location
    </button>
  </div>

  <!-- Footer -->
  <footer class="text-center py-4 text-green-600 text-sm mt-4">
    © 2025 Cleanify. Keeping communities clean and green 🌿
  </footer>
@endsection

@push('scripts')
  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script>
    // Initialize map
    const map = L.map('map').setView([15.1375, 120.5894], 13);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors',
    }).addTo(map);

    // Create custom truck icon
    const truckIcon = L.icon({
      iconUrl: 'https://cdn-icons-png.flaticon.com/512/743/743131.png',
      iconSize: [40, 40],
      iconAnchor: [20, 40],
      popupAnchor: [0, -35],
    });

    // Add truck marker
    let truckMarker = L.marker([15.1375, 120.5894], { icon: truckIcon })
      .addTo(map)
      .bindPopup('<b>Cleanify Truck 01</b><br>Currently at Barangay Lakandula')
      .openPopup();

    // Define route points for truck movement simulation
    const routePoints = [
      [15.1375, 120.5894],
      [15.1400, 120.5920],
      [15.1420, 120.5950],
      [15.1445, 120.5990],
      [15.1460, 120.6025],
    ];
    
    let currentPointIndex = 0;

    // Function to move truck to next point
    function moveTruck() {
      if (currentPointIndex < routePoints.length) {
        const [lat, lng] = routePoints[currentPointIndex];
        truckMarker.setLatLng([lat, lng]);
        map.panTo([lat, lng]);
        
        // Update location display
        const locationNames = [
          "Barangay Lakandula",
          "Poblacion Area",
          "Market District",
          "Residential Zone A",
          "Commercial District"
        ];
        document.getElementById('location-name').textContent = locationNames[currentPointIndex];
        
        // Update ETA
        const etaTimes = [
          "Around 25 minutes to your area",
          "Around 20 minutes to your area", 
          "Around 15 minutes to your area",
          "Around 10 minutes to your area",
          "Around 5 minutes to your area"
        ];
        document.getElementById('eta').textContent = etaTimes[currentPointIndex];
        
        currentPointIndex++;
      } else {
        // Reset to start
        currentPointIndex = 0;
      }
    }

    // Add event listener to update location button
    document.getElementById('updateLocation').addEventListener('click', moveTruck);
  </script>
@endpush
