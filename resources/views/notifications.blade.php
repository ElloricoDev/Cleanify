@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
  <!-- Topbar -->
  <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex justify-between items-center">
    <h4 class="font-semibold text-gray-800">
      <i class="fas fa-bell text-green-600 mr-3"></i>Notifications
    </h4>
    <button class="px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-colors duration-300 text-sm">
      <i class="fas fa-check-double mr-2"></i>Mark all as read
    </button>
  </div>

  <!-- Notifications List -->
  <div class="bg-white rounded-xl shadow-sm p-6">
    <div class="space-y-4">
      <!-- Announcement Notification -->
      <div class="flex items-start p-4 border-b border-gray-100 hover:bg-green-50 transition-colors duration-300 rounded-lg">
        <div class="w-12 h-12 bg-green-600 text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0">
          <i class="fas fa-bullhorn text-lg"></i>
        </div>
        <div class="flex-1">
          <p class="text-gray-800 mb-1">
            <strong>Admin Announcement:</strong> Join our Barangay Clean-up Drive this Saturday!
          </p>
          <div class="text-gray-500 text-sm">2 hours ago</div>
        </div>
      </div>

      <!-- Like Notification -->
      <div class="flex items-start p-4 border-b border-gray-100 hover:bg-green-50 transition-colors duration-300 rounded-lg">
        <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0">
          <i class="fas fa-heart text-lg"></i>
        </div>
        <div class="flex-1">
          <p class="text-gray-800 mb-1">
            <strong>Maria Santos</strong> liked your recent post about recycling ♻️
          </p>
          <div class="text-gray-500 text-sm">4 hours ago</div>
        </div>
      </div>

      <!-- Comment Notification -->
      <div class="flex items-start p-4 border-b border-gray-100 hover:bg-green-50 transition-colors duration-300 rounded-lg">
        <div class="w-12 h-12 bg-yellow-400 text-gray-800 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
          <i class="fas fa-comment text-lg"></i>
        </div>
        <div class="flex-1">
          <p class="text-gray-800 mb-1">
            <strong>Juan Dela Cruz</strong> commented: "This is a great initiative!"
          </p>
          <div class="text-gray-500 text-sm">6 hours ago</div>
        </div>
      </div>

      <!-- Schedule Update Notification -->
      <div class="flex items-start p-4 border-b border-gray-100 hover:bg-green-50 transition-colors duration-300 rounded-lg">
        <div class="w-12 h-12 bg-blue-400 text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0">
          <i class="fas fa-calendar-day text-lg"></i>
        </div>
        <div class="flex-1">
          <p class="text-gray-800 mb-1">
            <strong>Garbage Schedule Update:</strong> Monday pickup is moved to Tuesday due to holiday.
          </p>
          <div class="text-gray-500 text-sm">1 day ago</div>
        </div>
      </div>

      <!-- Reminder Notification -->
      <div class="flex items-start p-4 border-b border-gray-100 hover:bg-green-50 transition-colors duration-300 rounded-lg">
        <div class="w-12 h-12 bg-red-500 text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0">
          <i class="fas fa-exclamation-triangle text-lg"></i>
        </div>
        <div class="flex-1">
          <p class="text-gray-800 mb-1">
            <strong>Reminder:</strong> Please verify your email to receive updates and event alerts.
          </p>
          <div class="text-gray-500 text-sm">2 days ago</div>
        </div>
      </div>

      <!-- Additional Notification Example -->
      <div class="flex items-start p-4 hover:bg-green-50 transition-colors duration-300 rounded-lg">
        <div class="w-12 h-12 bg-purple-500 text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0">
          <i class="fas fa-truck text-lg"></i>
        </div>
        <div class="flex-1">
          <p class="text-gray-800 mb-1">
            <strong>Truck Status Update:</strong> Cleanify Truck 02 is running 15 minutes ahead of schedule.
          </p>
          <div class="text-gray-500 text-sm">3 days ago</div>
        </div>
      </div>
    </div>
  </div>
@endsection
