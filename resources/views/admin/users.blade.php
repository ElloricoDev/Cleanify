@extends('layouts.admin')

@section('title', 'Users')

@section('content')
  <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
    <div>
      <h2 class="text-3xl font-bold text-gray-800">
        <i class="fas fa-users text-green-600 mr-3"></i>User Management
      </h2>
      <p class="text-gray-600 mt-1">Manage user accounts, roles, and permissions</p>
    </div>
    <div class="flex w-full lg:w-auto max-w-lg">
      <input id="userSearchInput" type="text" class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Search users...">
      <button onclick="filterUsers()" class="px-4 bg-green-600 text-white rounded-r-lg hover:bg-green-700 transition-colors duration-300">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <x-admin.stat-card icon="fas fa-users" title="Total Users" value="145" />
    <x-admin.stat-card icon="fas fa-user-shield" title="Admins" value="8" borderClass="border-l-4 border-blue-500" iconWrapperClass="bg-blue-100" iconColorClass="text-blue-600" />
    <x-admin.stat-card icon="fas fa-user-tie" title="Moderators" value="12" borderClass="border-l-4 border-yellow-500" iconWrapperClass="bg-yellow-100" iconColorClass="text-yellow-600" />
    <x-admin.stat-card icon="fas fa-user-slash" title="Banned Users" value="3" borderClass="border-l-4 border-red-500" iconWrapperClass="bg-red-100" iconColorClass="text-red-600" />
  </div>

  @php
    $users = [
      ['id'=>1,'name'=>'Maria Lopez','email'=>'maria.lopez@example.com','role'=>'User','status'=>'Active','joined'=>'Jan 5, 2025','avatar'=>'https://i.pravatar.cc/40?img=1'],
      ['id'=>2,'name'=>'John Doe','email'=>'john.doe@example.com','role'=>'Admin','status'=>'Active','joined'=>'Mar 12, 2025','avatar'=>'https://i.pravatar.cc/40?img=2'],
      ['id'=>3,'name'=>'Ella Mae','email'=>'ella.mae@example.com','role'=>'User','status'=>'Banned','joined'=>'Apr 22, 2025','avatar'=>'https://i.pravatar.cc/40?img=3'],
    ];
    $roleBadge = [
      'User' => 'bg-blue-100 text-blue-800',
      'Admin' => 'bg-green-100 text-green-800',
      'Moderator' => 'bg-yellow-100 text-yellow-800',
    ];
    $statusColor = [
      'Active' => 'text-green-600',
      'Banned' => 'text-red-600',
      'Suspended' => 'text-yellow-600',
    ];
  @endphp

  <div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full" id="userTable">
        <thead>
          <tr class="bg-green-600 text-white">
            @foreach (['#','Avatar','Name','Email','Role','Status','Date Joined','Actions'] as $heading)
              <th class="px-4 py-3 text-left text-sm font-semibold">{{ $heading }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody id="userTableBody" class="divide-y divide-gray-200">
          @foreach ($users as $user)
            <tr class="hover:bg-gray-50 transition-colors duration-200" data-user="{{ json_encode($user) }}">
              <td class="px-4 py-3">{{ $user['id'] }}</td>
              <td class="px-4 py-3">
                <img src="{{ $user['avatar'] }}" class="w-10 h-10 rounded-full" alt="Avatar">
              </td>
              <td class="px-4 py-3 font-medium text-gray-900">{{ $user['name'] }}</td>
              <td class="px-4 py-3 text-gray-600">{{ $user['email'] }}</td>
              <td class="px-4 py-3">
                <span class="{{ $roleBadge[$user['role']] ?? 'bg-gray-100 text-gray-800' }} text-xs font-medium px-2.5 py-0.5 rounded-full">
                  <i class="fas fa-user mr-1"></i>{{ $user['role'] }}
                </span>
              </td>
              <td class="px-4 py-3">
                <span class="{{ $statusColor[$user['status']] ?? 'text-gray-600' }} font-semibold">
                  <i class="fas fa-circle text-xs mr-1"></i>{{ $user['status'] }}
                </span>
              </td>
              <td class="px-4 py-3 text-gray-600">{{ $user['joined'] }}</td>
              <td class="px-4 py-3">
                <div class="flex space-x-2">
                  <button onclick="openUserView({{ $user['id'] }})" class="w-8 h-8 bg-purple-500 text-white rounded hover:bg-purple-600 transition-colors duration-300">
                    <i class="fas fa-eye text-xs"></i>
                  </button>
                  <button onclick="openUserEdit({{ $user['id'] }})" class="w-8 h-8 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors duration-300">
                    <i class="fas fa-edit text-xs"></i>
                  </button>
                  <button onclick="openUserDelete({{ $user['id'] }})" class="w-8 h-8 bg-red-500 text-white rounded hover:bg-red-600 transition-colors duration-300">
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
        <div class="text-sm text-gray-600">Showing 1 to 3 of 145 entries</div>
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
  <x-modal id="viewUserModal" title="User Details" icon="fas fa-eye" color="green">
    <div class="flex flex-col md:flex-row items-center md:items-start gap-6 mb-6">
      <div class="flex-shrink-0">
        <img id="viewUserAvatar" src="" class="w-32 h-32 rounded-full object-cover border-4 border-purple-100" alt="User Avatar">
      </div>
      <div class="flex-1 text-center md:text-left">
        <h3 id="viewUserName" class="text-2xl font-bold text-gray-800 mb-2"></h3>
        <div id="viewUserBadges" class="flex flex-wrap gap-2 justify-center md:justify-start mb-4"></div>
        <p class="text-gray-600"><i class="fas fa-envelope mr-2 text-purple-600"></i><span id="viewUserEmail"></span></p>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <div class="bg-gray-50 rounded-lg p-4" id="viewUserInfo"></div>
      <div class="bg-gray-50 rounded-lg p-4" id="viewUserStats"></div>
    </div>
    <div class="bg-gray-50 rounded-lg p-4" id="viewUserExtra"></div>
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('viewUserModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
          <i class="fas fa-times mr-2"></i>Close
        </button>
        <button onclick="openEditFromView()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
          <i class="fas fa-edit mr-2"></i>Edit User
        </button>
      </div>
    @endslot
  </x-modal>

  <x-modal id="editUserModal" title="Edit User" icon="fas fa-user-edit" color="green">
    <form id="editUserForm" class="space-y-4">
      <input type="hidden" name="id">
      <div>
        <label class="block text-gray-700 mb-2"><i class="fas fa-user mr-2 text-green-600"></i>Full Name</label>
        <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
      </div>
      <div>
        <label class="block text-gray-700 mb-2"><i class="fas fa-envelope mr-2 text-green-600"></i>Email</label>
        <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
      </div>
      <div>
        <label class="block text-gray-700 mb-2"><i class="fas fa-user-tag mr-2 text-green-600"></i>Role</label>
        <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
          @foreach (['User','Moderator','Admin'] as $role)
            <option value="{{ $role }}">{{ $role }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-gray-700 mb-2"><i class="fas fa-circle mr-2 text-green-600"></i>Status</label>
        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
          @foreach (['Active','Banned','Suspended'] as $status)
            <option value="{{ $status }}">{{ $status }}</option>
          @endforeach
        </select>
      </div>
    </form>
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('editUserModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button onclick="saveUserChanges()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
          <i class="fas fa-save mr-2"></i>Save Changes
        </button>
      </div>
    @endslot
  </x-modal>

  <x-modal id="deleteUserModal" title="Delete User" icon="fas fa-exclamation-triangle" color="red">
    <div class="text-center">
      <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-exclamation text-red-600 text-2xl"></i>
      </div>
      <h4 class="text-xl font-semibold text-gray-800 mb-2">Confirm Deletion</h4>
      <p class="text-gray-600 mb-4">Are you sure you want to delete this user? This action cannot be undone and all user data will be permanently removed.</p>
      <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 text-left flex">
        <i class="fas fa-exclamation-circle text-yellow-400 mr-3 mt-1"></i>
        <p class="text-sm text-yellow-700">
          This will delete the user account and all associated data including posts and reports.
        </p>
      </div>
    </div>
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('deleteUserModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button onclick="confirmUserDelete()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300">
          <i class="fas fa-trash mr-2"></i>Delete User
        </button>
      </div>
    @endslot
  </x-modal>
@endpush

@push('scripts')
  <script>
    const adminUsers = @json($users);
    let currentUserId = null;

    function getUser(id) {
      return adminUsers.find(u => u.id === Number(id));
    }

    function openUserView(id) {
      const user = getUser(id);
      if (!user) return;
      currentUserId = id;
      document.getElementById('viewUserAvatar').src = user.avatar.replace('40', '120');
      document.getElementById('viewUserName').textContent = user.name;
      document.getElementById('viewUserEmail').textContent = user.email;
      document.getElementById('viewUserBadges').innerHTML = `
        <span class="{{ $roleBadge['User'] }} text-sm font-medium px-3 py-1 rounded-full"><i class="fas fa-user mr-1"></i>${user.role}</span>
        <span class="${user.status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'} text-sm font-medium px-3 py-1 rounded-full">
          <i class="fas fa-circle text-xs mr-1"></i>${user.status}
        </span>`;
      document.getElementById('viewUserInfo').innerHTML = `
        <h4 class="font-semibold text-gray-800 mb-3"><i class="fas fa-info-circle mr-2 text-purple-600"></i>Basic Information</h4>
        <div class="space-y-2">
          <div class="flex justify-between"><span class="text-gray-600">Member Since:</span><span class="font-medium">${user.joined}</span></div>
          <div class="flex justify-between"><span class="text-gray-600">Email Verified:</span><span class="text-green-600 font-medium"><i class="fas fa-check-circle mr-1"></i>Yes</span></div>
        </div>`;
      document.getElementById('viewUserStats').innerHTML = `
        <h4 class="font-semibold text-gray-800 mb-3"><i class="fas fa-chart-bar mr-2 text-purple-600"></i>Activity Stats</h4>
        <div class="space-y-2">
          <div class="flex justify-between"><span class="text-gray-600">Reports Submitted:</span><span class="font-medium">12</span></div>
          <div class="flex justify-between"><span class="text-gray-600">Posts Created:</span><span class="font-medium">8</span></div>
          <div class="flex justify-between"><span class="text-gray-600">Community Score:</span><span class="font-medium text-green-600">95%</span></div>
        </div>`;
      document.getElementById('viewUserExtra').innerHTML = `
        <h4 class="font-semibold text-gray-800 mb-3"><i class="fas fa-sticky-note mr-2 text-purple-600"></i>Additional Information</h4>
        <div class="space-y-2">
          <div class="flex justify-between"><span class="text-gray-600">Location:</span><span class="font-medium">Barangay Lakandula</span></div>
          <div class="flex justify-between"><span class="text-gray-600">Phone:</span><span class="font-medium">+63 912 345 6789</span></div>
        </div>`;
      openModal('viewUserModal');
    }

    function openUserEdit(id) {
      const user = getUser(id);
      if (!user) return;
      currentUserId = id;
      const form = document.getElementById('editUserForm');
      form.id.value = user.id;
      form.name.value = user.name;
      form.email.value = user.email;
      form.role.value = user.role;
      form.status.value = user.status;
      openModal('editUserModal');
    }

    function openEditFromView() {
      closeModal('viewUserModal');
      setTimeout(() => openUserEdit(currentUserId), 300);
    }

    function openUserDelete(id) {
      currentUserId = id;
      openModal('deleteUserModal');
    }

    function saveUserChanges() {
      alert(`User #${currentUserId} changes saved successfully!`);
      closeModal('editUserModal');
    }

    function confirmUserDelete() {
      alert(`User #${currentUserId} deleted successfully!`);
      closeModal('deleteUserModal');
    }

    function filterUsers() {
      const query = document.getElementById('userSearchInput').value.toLowerCase();
      document.querySelectorAll('#userTableBody tr').forEach(row => {
        const user = JSON.parse(row.dataset.user);
        const match = user.name.toLowerCase().includes(query) || user.email.toLowerCase().includes(query);
        row.style.display = match ? '' : 'none';
      });
    }
  </script>
@endpush

