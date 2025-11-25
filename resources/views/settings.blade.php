@extends('layouts.app')

@section('title', 'Settings')

@section('content')
  <h3 class="mb-6 text-gray-800 font-semibold">
    <i class="fas fa-cog text-green-600 mr-3"></i>Account Settings
  </h3>

  <!-- Account Settings Section -->
  <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <h5 class="text-green-600 font-semibold text-lg mb-4 border-b-2 border-green-600 pb-2">
      <i class="fas fa-user-lines mr-2"></i>Account Information
    </h5>
    <form>
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">Email Address</label>
        <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="you@example.com">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">Change Password</label>
        <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Enter new password">
      </div>
      <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
        <i class="fas fa-check-circle mr-2"></i>Save Changes
      </button>
    </form>
  </div>

  <!-- Privacy Settings Section -->
  <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <h5 class="text-green-600 font-semibold text-lg mb-4 border-b-2 border-green-600 pb-2">
      <i class="fas fa-shield-alt mr-2"></i>Privacy Settings
    </h5>
    
    <!-- Toggle Switches -->
    <div class="space-y-4 mb-6">
      <div class="flex items-center justify-between">
        <label for="showEmail" class="text-gray-700 cursor-pointer">Show my email to community members</label>
        <div class="relative inline-block w-12 h-6">
          <input type="checkbox" id="showEmail" class="sr-only peer" checked>
          <div class="w-12 h-6 bg-gray-300 peer-checked:bg-green-600 rounded-full transition-colors duration-300"></div>
          <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-300 peer-checked:translate-x-6"></div>
        </div>
      </div>

      <div class="flex items-center justify-between">
        <label for="notifyPosts" class="text-gray-700 cursor-pointer">Receive notifications for new posts</label>
        <div class="relative inline-block w-12 h-6">
          <input type="checkbox" id="notifyPosts" class="sr-only peer" checked>
          <div class="w-12 h-6 bg-gray-300 peer-checked:bg-green-600 rounded-full transition-colors duration-300"></div>
          <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-300 peer-checked:translate-x-6"></div>
        </div>
      </div>

      <div class="flex items-center justify-between">
        <label for="locationShare" class="text-gray-700 cursor-pointer">Share my location for truck tracking</label>
        <div class="relative inline-block w-12 h-6">
          <input type="checkbox" id="locationShare" class="sr-only peer">
          <div class="w-12 h-6 bg-gray-300 peer-checked:bg-green-600 rounded-full transition-colors duration-300"></div>
          <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-300 peer-checked:translate-x-6"></div>
        </div>
      </div>
    </div>

    <button class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
      <i class="fas fa-save mr-2"></i>Save Preferences
    </button>
  </div>

  <!-- Danger Zone Section -->
  <div class="bg-white rounded-xl shadow-sm p-6 border border-red-200">
    <h5 class="text-red-600 font-semibold text-lg mb-4 border-b-2 border-red-600 pb-2">
      <i class="fas fa-exclamation-triangle mr-2"></i>Danger Zone
    </h5>
    <p class="text-gray-600 mb-4">Deleting your account is permanent and cannot be undone. All your posts and data will be lost.</p>
    <button onclick="openModal('deleteModal')" class="px-6 py-2 border border-red-600 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-colors duration-300">
      <i class="fas fa-trash mr-2"></i>Delete My Account
    </button>
  </div>
@endsection
@push('modals')
  <!-- Delete Confirmation Modal -->
  <x-modal id="deleteModal" title="Confirm Deletion" icon="fas fa-exclamation-circle" color="red">
    <p class="text-gray-700">Are you sure you want to delete your Cleanify account? This action cannot be undone.</p>
    
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('deleteModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">Cancel</button>
        <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300">
          <i class="fas fa-trash mr-2"></i>Delete Account
        </button>
      </div>
    @endslot
  </x-modal>
@endpush

@push('scripts')
  <script>
    // Enhanced toggle switch functionality
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        console.log(`${this.id} is now ${this.checked ? 'enabled' : 'disabled'}`);
      });
    });
  </script>
@endpush

