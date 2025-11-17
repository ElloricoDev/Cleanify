@extends('layouts.app')

@section('title', 'Community Reports')

@section('content')
  <!-- Topbar -->
  <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex justify-between items-center">
    <h4 class="font-semibold text-gray-800">
      <i class="fas fa-comment-dots text-green-600 mr-3"></i>Community Reports
    </h4>
    <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300 text-sm">
      <i class="fas fa-plus-circle mr-2"></i>New Report
    </button>
  </div>

  <!-- Create Report Section -->
  <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex items-start mb-4">
      <img src="https://i.pravatar.cc/150?img=48" alt="User" class="w-12 h-12 rounded-full mr-4">
      <textarea class="flex-1 border-0 focus:outline-none focus:ring-0 resize-none" placeholder="Report an issue in your community..." rows="3"></textarea>
    </div>
    <div class="flex justify-between items-center">
      <label class="px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-colors duration-300 cursor-pointer text-sm">
        <i class="fas fa-image mr-2"></i>Upload Photo
        <input type="file" class="hidden" accept="image/*">
      </label>
      <button class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
        Submit
      </button>
    </div>
  </div>

  <!-- Reports List -->
  <div class="space-y-6">
    <!-- Report 1 -->
    <div class="bg-white rounded-xl shadow-sm p-6">
      <div class="flex items-center mb-4">
        <img src="https://i.pravatar.cc/150?img=33" alt="User" class="w-12 h-12 rounded-full mr-4">
        <div class="flex-1">
          <h6 class="font-semibold text-gray-800 mb-1">Maria Santos</h6>
          <span class="text-gray-500 text-sm">
            <i class="fas fa-map-marker-alt mr-1"></i>Near Barangay Hall
          </span>
        </div>
        <span class="bg-yellow-400 text-gray-800 text-sm font-medium px-3 py-1 rounded-full">Pending</span>
      </div>
      <p class="text-gray-700 mb-4">Overflowing trash near the school entrance. It's starting to smell and attract insects.</p>
      <img src="https://images.unsplash.com/photo-1581578017423-82e5fd36e3c2?w=800" alt="Report Image" class="w-full rounded-lg">
    </div>

    <!-- Report 2 -->
    <div class="bg-white rounded-xl shadow-sm p-6">
      <div class="flex items-center mb-4">
        <img src="https://i.pravatar.cc/150?img=45" alt="User" class="w-12 h-12 rounded-full mr-4">
        <div class="flex-1">
          <h6 class="font-semibold text-gray-800 mb-1">Juan Dela Cruz</h6>
          <span class="text-gray-500 text-sm">
            <i class="fas fa-map-marker-alt mr-1"></i>Zone 3, Riverside
          </span>
        </div>
        <span class="bg-green-600 text-white text-sm font-medium px-3 py-1 rounded-full">Resolved</span>
      </div>
      <p class="text-gray-700 mb-4">Illegal dumping near the riverside. The Cleanify team responded quickly! 💚</p>
      <img src="https://images.unsplash.com/photo-1603575448431-4bdf63d46b8b?w=800" alt="Report Image" class="w-full rounded-lg">
    </div>

    <!-- Report 3 -->
    <div class="bg-white rounded-xl shadow-sm p-6">
      <div class="flex items-center mb-4">
        <img src="https://i.pravatar.cc/150?img=56" alt="User" class="w-12 h-12 rounded-full mr-4">
        <div class="flex-1">
          <h6 class="font-semibold text-gray-800 mb-1">Anna Reyes</h6>
          <span class="text-gray-500 text-sm">
            <i class="fas fa-map-marker-alt mr-1"></i>School Zone
          </span>
        </div>
        <span class="bg-yellow-400 text-gray-800 text-sm font-medium px-3 py-1 rounded-full">Pending</span>
      </div>
      <p class="text-gray-700 mb-4">Overflowing trash near the school's back gate. Needs urgent attention.</p>
      <img src="https://images.unsplash.com/photo-1618477388954-5c217aaabf39?w=800" alt="Report Image" class="w-full rounded-lg">
    </div>

    <!-- Report 4 -->
    <div class="bg-white rounded-xl shadow-sm p-6">
      <div class="flex items-center mb-4">
        <img src="https://i.pravatar.cc/150?img=51" alt="User" class="w-12 h-12 rounded-full mr-4">
        <div class="flex-1">
          <h6 class="font-semibold text-gray-800 mb-1">Carlo Mendoza</h6>
          <span class="text-gray-500 text-sm">
            <i class="fas fa-map-marker-alt mr-1"></i>Market Street
          </span>
        </div>
        <span class="bg-green-600 text-white text-sm font-medium px-3 py-1 rounded-full">Resolved</span>
      </div>
      <p class="text-gray-700 mb-4">Trash bins were missing last week, but new ones were installed! 👏</p>
      <img src="https://images.unsplash.com/photo-1598373182133-61a6b7d456a6?w=800" alt="Report Image" class="w-full rounded-lg">
    </div>

    <!-- Report 5 -->
    <div class="bg-white rounded-xl shadow-sm p-6">
      <div class="flex items-center mb-4">
        <img src="https://i.pravatar.cc/150?img=28" alt="User" class="w-12 h-12 rounded-full mr-4">
        <div class="flex-1">
          <h6 class="font-semibold text-gray-800 mb-1">Luis Garcia</h6>
          <span class="text-gray-500 text-sm">
            <i class="fas fa-map-marker-alt mr-1"></i>Park Area
          </span>
        </div>
        <span class="bg-green-600 text-white text-sm font-medium px-3 py-1 rounded-full">Resolved</span>
      </div>
      <p class="text-gray-700 mb-4">Reported broken recycling bins in the park. Cleanify team fixed them within 2 days! 🎉</p>
      <img src="https://images.unsplash.com/photo-1571624436279-b272aff752b5?w=800" alt="Report Image" class="w-full rounded-lg">
    </div>
  </div>
@endsection
