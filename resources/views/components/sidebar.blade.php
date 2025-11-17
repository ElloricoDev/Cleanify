@props(['active' => 'home'])

<div class="w-64 bg-green-600 text-white flex flex-col justify-between fixed h-full">
  <div>
    <!-- Logo Section -->
    <div class="text-center py-6 border-b border-green-500">
      <img src="/assets/icons/cleanifyicon.png" alt="Cleanify Logo" class="w-16 mx-auto mb-2">
      <h5 class="font-bold text-lg">Cleanify</h5>
    </div>

    <!-- Navigation -->
    <nav class="p-4 space-y-2">
      <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-white transition-colors duration-300 {{ $active === 'home' ? 'bg-green-700' : 'hover:bg-green-700' }}">
        <i class="fas fa-home mr-3 text-lg"></i>
        <span>Home</span>
      </a>
      
      <a href="{{ route('garbage-schedule') }}" class="flex items-center px-4 py-3 rounded-lg text-white transition-colors duration-300 {{ $active === 'schedule' ? 'bg-green-700' : 'hover:bg-green-700' }}">
        <i class="fas fa-calendar-alt mr-3 text-lg"></i>
        <span>Garbage Schedule</span>
      </a>
      
      <a href="{{ route('tracker') }}" class="flex items-center px-4 py-3 rounded-lg text-white transition-colors duration-300 {{ $active === 'tracker' ? 'bg-green-700' : 'hover:bg-green-700' }}">
        <i class="fas fa-truck mr-3 text-lg"></i>
        <span>Truck Tracker</span>
      </a>
      
      <a href="{{ route('notifications') }}" class="flex items-center px-4 py-3 rounded-lg text-white transition-colors duration-300 {{ $active === 'notifications' ? 'bg-green-700' : 'hover:bg-green-700' }}">
        <i class="fas fa-bell mr-3 text-lg"></i>
        <span>Notifications</span>
      </a>
      
      <a href="{{ route('community-reports') }}" class="flex items-center px-4 py-3 rounded-lg text-white transition-colors duration-300 {{ $active === 'reports' ? 'bg-green-700' : 'hover:bg-green-700' }}">
        <i class="fas fa-comment-dots mr-3 text-lg"></i>
        <span>Community Reports</span>
      </a>
      
      <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 rounded-lg text-white transition-colors duration-300 {{ $active === 'profile' ? 'bg-green-700' : 'hover:bg-green-700' }}">
        <i class="fas fa-user-circle mr-3 text-lg"></i>
        <span>Profile</span>
      </a>
      
      <a href="{{ route('settings') }}" class="flex items-center px-4 py-3 rounded-lg text-white transition-colors duration-300 {{ $active === 'settings' ? 'bg-green-700' : 'hover:bg-green-700' }}">
        <i class="fas fa-cog mr-3 text-lg"></i>
        <span>Settings</span>
      </a>
    </nav>
  </div>

  <!-- Footer -->
  <div class="p-4 text-center border-t border-green-500">
    <small>&copy; 2025 Cleanify</small>
  </div>
</div>
