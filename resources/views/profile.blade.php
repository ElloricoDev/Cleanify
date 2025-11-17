@extends('layouts.app')

@section('title', 'Profile')

@section('content')
  <!-- Profile Card -->
  <div class="bg-white rounded-xl shadow-sm p-6 mb-6 flex items-center">
    <img src="https://i.pravatar.cc/150?img=64" alt="Profile" class="w-28 h-28 rounded-full mr-6">
    <div class="flex-1">
      <h5 class="text-green-600 font-bold text-xl mb-2">Kim Rynel Ellorico</h5>
      <p class="text-gray-600 mb-1">
        <i class="fas fa-envelope mr-2 text-green-500"></i>kimrynellorico@example.com
      </p>
      <p class="text-gray-600 mb-1">
        <i class="fas fa-phone mr-2 text-green-500"></i>+63 912 345 6789
      </p>
      <p class="text-gray-600">
        <i class="fas fa-map-marker-alt mr-2 text-green-500"></i>Barangay Lakandula
      </p>
    </div>
    <button onclick="openModal('editProfileModal')" class="px-6 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-colors duration-300">
      <i class="fas fa-edit mr-2"></i>Edit Profile
    </button>
  </div>

  <!-- My Posts Section -->
  <h5 class="mb-4 text-green-600 font-semibold text-lg">
    <i class="fas fa-images mr-2"></i>My Posts
  </h5>

  <!-- Example Post -->
  <div class="bg-white rounded-xl shadow-sm p-6 mb-6 relative">
    <!-- Post Options Dropdown -->
    <div class="absolute top-4 right-4">
      <button onclick="toggleDropdown('postDropdown')" class="text-gray-500 hover:text-green-600 transition-colors duration-300">
        <i class="fas fa-ellipsis-v"></i>
      </button>
      <div id="postDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
        <a href="#" onclick="openModal('editPostModal')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
        <a href="#" onclick="openModal('deletePostModal')" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete</a>
      </div>
    </div>

    <!-- Post Header -->
    <div class="flex items-center mb-4">
      <img src="https://i.pravatar.cc/150?img=64" alt="User" class="w-12 h-12 rounded-full mr-4">
      <div>
        <h6 class="font-semibold text-green-600 mb-0">Kim Rynel Ellorico</h6>
        <small class="text-gray-500">2 hours ago</small>
      </div>
    </div>

    <!-- Post Content -->
    <p class="text-gray-700 mb-4">Shared this earlier! Our barangay started a mini clean-up along the riverside 🌿💧 #CleanifyTogether</p>
    <img src="https://images.unsplash.com/photo-1603575448431-4bdf63d46b8b?w=800" alt="Post Image" class="w-full rounded-lg mb-4">

    <!-- Post Actions -->
    <div class="flex items-center mt-4">
      <button class="flex items-center text-gray-600 hover:text-red-500 transition-colors duration-300 mr-6">
        <i class="fas fa-heart mr-2"></i>
        <span class="text-sm">14 likes</span>
      </button>
      <button onclick="openModal('commentModal')" class="flex items-center text-gray-600 hover:text-blue-500 transition-colors duration-300">
        <i class="fas fa-comment mr-2"></i>
        <span class="text-sm">3 comments</span>
      </button>
    </div>
  </div>

  <!-- Additional Post Example -->
  <div class="bg-white rounded-xl shadow-sm p-6 mb-6 relative">
    <div class="absolute top-4 right-4">
      <button onclick="toggleDropdown('postDropdown2')" class="text-gray-500 hover:text-green-600 transition-colors duration-300">
        <i class="fas fa-ellipsis-v"></i>
      </button>
      <div id="postDropdown2" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
        <a href="#" onclick="openModal('editPostModal')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
        <a href="#" onclick="openModal('deletePostModal')" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete</a>
      </div>
    </div>

    <div class="flex items-center mb-4">
      <img src="https://i.pravatar.cc/150?img=64" alt="User" class="w-12 h-12 rounded-full mr-4">
      <div>
        <h6 class="font-semibold text-green-600 mb-0">Kim Rynel Ellorico</h6>
        <small class="text-gray-500">1 day ago</small>
      </div>
    </div>

    <p class="text-gray-700 mb-4">Just installed our new recycling bins in the community park! ♻️ Let's work together to keep our environment clean! #EcoFriendly #Cleanify</p>
    <img src="https://images.unsplash.com/photo-1598373182133-61a6b7d456a6?w=800" alt="Post Image" class="w-full rounded-lg mb-4">

    <div class="flex items-center mt-4">
      <button class="flex items-center text-gray-600 hover:text-red-500 transition-colors duration-300 mr-6">
        <i class="fas fa-heart mr-2"></i>
        <span class="text-sm">28 likes</span>
      </button>
      <button onclick="openModal('commentModal')" class="flex items-center text-gray-600 hover:text-blue-500 transition-colors duration-300">
        <i class="fas fa-comment mr-2"></i>
        <span class="text-sm">7 comments</span>
      </button>
    </div>
  </div>
@endsection

@push('modals')
  <!-- Edit Profile Modal -->
  <x-modal id="editProfileModal" title="Edit Profile" icon="fas fa-edit" color="green">
    <form>
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">Full Name</label>
        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="Kim Rynel Ellorico">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">Email</label>
        <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="kimrynellorico@example.com">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">Phone</label>
        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="+63 912 345 6789">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">Address</label>
        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="Barangay Lakandula">
      </div>
    </form>
    
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('editProfileModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">Cancel</button>
        <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">Save Changes</button>
      </div>
    @endslot
  </x-modal>

  <!-- Edit Post Modal -->
  <x-modal id="editPostModal" title="Edit Post" icon="fas fa-edit" color="green">
    <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none mb-4" rows="4">Shared this earlier! Our barangay started a mini clean-up along the riverside 🌿💧 #CleanifyTogether</textarea>
    <input type="file" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
    
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('editPostModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">Cancel</button>
        <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">Save Changes</button>
      </div>
    @endslot
  </x-modal>

  <!-- Delete Confirmation Modal -->
  <x-modal id="deletePostModal" title="Delete Post" icon="fas fa-trash" color="red">
    <p class="text-gray-700 text-center">Are you sure you want to delete this post? This action cannot be undone.</p>
    
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('deletePostModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">Cancel</button>
        <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300">Delete</button>
      </div>
    @endslot
  </x-modal>

  <!-- Comment Modal -->
  <x-modal id="commentModal" title="Comments" icon="fas fa-comment-dots" color="green">
    <div class="flex mb-4">
      <img src="https://i.pravatar.cc/150?img=33" alt="User" class="w-10 h-10 rounded-full mr-3">
      <div class="flex-1">
        <div class="flex items-center mb-1">
          <strong class="text-gray-800">Maria Santos</strong>
          <small class="text-gray-500 ml-2">• 10m ago</small>
        </div>
        <p class="text-gray-700">Great post! Cleanify is really making a difference 💚</p>
      </div>
    </div>
    <div class="flex mb-4">
      <img src="https://i.pravatar.cc/150?img=44" alt="User" class="w-10 h-10 rounded-full mr-3">
      <div class="flex-1">
        <div class="flex items-center mb-1">
          <strong class="text-gray-800">Juan Dela Cruz</strong>
          <small class="text-gray-500 ml-2">• 30m ago</small>
        </div>
        <p class="text-gray-700">Love the new initiative from the admin 👏</p>
      </div>
    </div>
    
    @slot('footer')
      <div class="flex">
        <textarea class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none" placeholder="Add a comment..." rows="2"></textarea>
        <button class="ml-3 px-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300 self-end">
          <i class="fas fa-paper-plane"></i>
        </button>
      </div>
    @endslot
  </x-modal>
@endpush
