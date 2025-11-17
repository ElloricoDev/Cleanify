@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
  <div class="mb-6">
    <h2 class="text-3xl font-bold text-gray-800">
      <i class="fas fa-cog text-green-600 mr-3"></i>Admin Settings ⚙️
    </h2>
    <p class="text-gray-600 mt-1">Manage your account preferences and system settings</p>
  </div>

  <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex items-center mb-4">
      <i class="fas fa-user-circle text-green-600 text-xl mr-3"></i>
      <h3 class="text-xl font-semibold text-gray-800">Profile Settings</h3>
    </div>
    <form id="adminProfileForm" class="space-y-4">
      <div>
        <label class="block text-gray-700 mb-2 font-medium">
          <i class="fas fa-user mr-2 text-green-600"></i>Admin Name
        </label>
        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="John Admin">
      </div>
      <div>
        <label class="block text-gray-700 mb-2 font-medium">
          <i class="fas fa-envelope mr-2 text-green-600"></i>Email Address
        </label>
        <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="admin@cleanify.com">
      </div>
      <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
        <i class="fas fa-save mr-2"></i>Save Changes
      </button>
    </form>
  </div>

  <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex items-center mb-4">
      <i class="fas fa-lock text-green-600 text-xl mr-3"></i>
      <h3 class="text-xl font-semibold text-gray-800">Update Password</h3>
    </div>
    <form id="adminPasswordForm" class="space-y-4">
      <div>
        <label class="block text-gray-700 mb-2 font-medium">
          <i class="fas fa-key mr-2 text-green-600"></i>Current Password
        </label>
        <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Enter current password">
      </div>
      <div>
        <label class="block text-gray-700 mb-2 font-medium">
          <i class="fas fa-key mr-2 text-green-600"></i>New Password
        </label>
        <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Enter new password">
      </div>
      <div>
        <label class="block text-gray-700 mb-2 font-medium">
          <i class="fas fa-key mr-2 text-green-600"></i>Confirm New Password
        </label>
        <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Confirm new password">
      </div>
      <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
        <i class="fas fa-key mr-2"></i>Update Password
      </button>
    </form>
  </div>

  <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex items-center mb-4">
      <i class="fas fa-bell text-green-600 text-xl mr-3"></i>
      <h3 class="text-xl font-semibold text-gray-800">Notification Preferences</h3>
    </div>
    <form id="adminNotificationForm" class="space-y-3">
      @foreach ([
        ['id' => 'emailNotif', 'label' => 'Email Notifications', 'icon' => 'fas fa-envelope', 'checked' => true],
        ['id' => 'smsNotif', 'label' => 'SMS Notifications', 'icon' => 'fas fa-comment-alt', 'checked' => false],
        ['id' => 'pushNotif', 'label' => 'Push Notifications', 'icon' => 'fas fa-bell', 'checked' => true],
      ] as $pref)
        <div class="flex items-center">
          <input type="checkbox" id="{{ $pref['id'] }}" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2" {{ $pref['checked'] ? 'checked' : '' }}>
          <label for="{{ $pref['id'] }}" class="ml-2 text-gray-700">
            <i class="{{ $pref['icon'] }} mr-2 text-green-600"></i>{{ $pref['label'] }}
          </label>
        </div>
      @endforeach
      <button type="submit" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
        <i class="fas fa-bell mr-2"></i>Update Preferences
      </button>
    </form>
  </div>

  <div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6">
      <div class="flex items-center mb-4">
        <i class="fas fa-link text-green-600 text-xl mr-3"></i>
        <h3 class="text-xl font-semibold text-gray-800">Connected Accounts</h3>
      </div>
      @php
        $accounts = [
          ['service' => 'Google', 'icon' => 'fab fa-google text-red-500', 'status' => 'Connected', 'connected' => true, 'date' => 'Jan 12, 2025'],
          ['service' => 'Facebook', 'icon' => 'fab fa-facebook text-blue-600', 'status' => 'Disconnected', 'connected' => false, 'date' => 'Feb 20, 2025'],
          ['service' => 'Twitter', 'icon' => 'fab fa-twitter text-blue-400', 'status' => 'Connected', 'connected' => true, 'date' => 'Mar 05, 2025'],
        ];
      @endphp
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="bg-green-600 text-white">
              @foreach (['#','Service','Status','Connected Since','Action'] as $heading)
                <th class="px-4 py-3 text-left text-sm font-semibold">{{ $heading }}</th>
              @endforeach
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200" id="connectedAccountsBody">
            @foreach ($accounts as $index => $account)
              <tr class="hover:bg-gray-50 transition-colors duration-200" data-account="{{ json_encode($account) }}">
                <td class="px-4 py-3">{{ $index + 1 }}</td>
                <td class="px-4 py-3 font-medium text-gray-900">
                  <div class="flex items-center">
                    <i class="{{ $account['icon'] }} mr-2"></i>
                    <span>{{ $account['service'] }}</span>
                  </div>
                </td>
                <td class="px-4 py-3">
                  <span class="text-xs font-medium px-2.5 py-0.5 rounded-full {{ $account['connected'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    <i class="fas fa-circle text-xs mr-1"></i>{{ $account['status'] }}
                  </span>
                </td>
                <td class="px-4 py-3 text-gray-600">{{ $account['date'] }}</td>
                <td class="px-4 py-3">
                  <button class="px-3 py-1 text-white text-sm rounded-lg transition-colors duration-300 {{ $account['connected'] ? 'bg-red-500 hover:bg-red-600' : 'bg-green-600 hover:bg-green-700' }}" onclick="toggleAccountConnection(this)">
                    <i class="fas {{ $account['connected'] ? 'fa-times-circle' : 'fa-check-circle' }} mr-1"></i>
                    {{ $account['connected'] ? 'Disconnect' : 'Connect' }}
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    document.getElementById('adminProfileForm').addEventListener('submit', (e) => {
      e.preventDefault();
      alert('Profile settings updated successfully!');
    });

    document.getElementById('adminPasswordForm').addEventListener('submit', (e) => {
      e.preventDefault();
      const inputs = e.target.querySelectorAll('input');
      const [current, next, confirm] = inputs;
      if (!current.value || !next.value || !confirm.value) {
        alert('Please fill in all password fields.');
        return;
      }
      if (next.value !== confirm.value) {
        alert('New passwords do not match.');
        return;
      }
      alert('Password updated successfully!');
      e.target.reset();
    });

    document.getElementById('adminNotificationForm').addEventListener('submit', (e) => {
      e.preventDefault();
      alert('Notification preferences updated successfully!');
    });

    function toggleAccountConnection(button) {
      const row = button.closest('tr');
      const isConnected = button.textContent.trim().includes('Disconnect');
      const statusCell = row.querySelector('td:nth-child(3) span');
      if (isConnected) {
        button.classList.remove('bg-red-500', 'hover:bg-red-600');
        button.classList.add('bg-green-600', 'hover:bg-green-700');
        button.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Connect';
        statusCell.className = 'text-xs font-medium px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-800';
        statusCell.innerHTML = '<i class="fas fa-circle text-xs mr-1"></i>Disconnected';
        alert('Successfully disconnected account.');
      } else {
        button.classList.remove('bg-green-600', 'hover:bg-green-700');
        button.classList.add('bg-red-500', 'hover:bg-red-600');
        button.innerHTML = '<i class="fas fa-times-circle mr-1"></i>Disconnect';
        statusCell.className = 'text-xs font-medium px-2.5 py-0.5 rounded-full bg-green-100 text-green-800';
        statusCell.innerHTML = '<i class="fas fa-circle text-xs mr-1"></i>Connected';
        alert('Successfully connected account.');
      }
    }
  </script>
@endpush

