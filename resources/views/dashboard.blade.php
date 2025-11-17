@extends('layouts.app')

@section('title', 'Home')

@section('content')
  <!-- Topbar -->
  <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex justify-between items-center">
    <h4 class="font-semibold text-gray-800">Welcome back, <strong>Cleanify User!</strong></h4>
    <div class="flex items-center gap-2">
      <input type="text" class="w-80 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Search posts...">
      <button class="px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-colors duration-300">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </div>

  <!-- Create Post Box -->
  <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex items-start mb-4">
      <img src="https://i.pravatar.cc/150?img=55" alt="User" class="w-12 h-12 rounded-full mr-4">
      <textarea class="flex-1 border-0 focus:outline-none focus:ring-0 resize-none" placeholder="What's on your mind, Cleanify User?" rows="3"></textarea>
    </div>
    <div class="flex justify-between items-center">
      <label class="px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-colors duration-300 cursor-pointer text-sm">
        <i class="fas fa-image mr-2"></i>Add Photo
        <input type="file" class="hidden" accept="image/*">
      </label>
      <button class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
        Post
      </button>
    </div>
  </div>

  <!-- Feeds -->
  <div class="space-y-6">
    <!-- Example Feed -->
    <div class="bg-white rounded-xl shadow-sm p-6">
      <div class="flex items-center mb-4">
        <img src="https://i.pravatar.cc/150?img=12" alt="Admin" class="w-12 h-12 rounded-full mr-4">
        <div>
          <h6 class="font-semibold text-gray-800 mb-0">Cleanify Admin</h6>
          <small class="text-gray-500">2 hours ago</small>
        </div>
      </div>
      <p class="text-gray-700 mb-4"><strong>Welcome to Cleanify!</strong> 🌿 Together we can build cleaner, greener communities.</p>
      <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=800" alt="Community cleanup" class="w-full rounded-lg mb-4">
      <div class="flex items-center mt-4">
        <button class="flex items-center text-gray-600 hover:text-red-500 transition-colors duration-300 mr-6">
          <i class="fas fa-heart mr-2"></i>
          <span class="text-sm">12 likes</span>
        </button>
        <button class="flex items-center text-gray-600 hover:text-blue-500 transition-colors duration-300" onclick="openModal('commentsModal')">
          <i class="fas fa-comment mr-2"></i>
          <span class="text-sm">5 comments</span>
        </button>
      </div>
    </div>

    <!-- Additional feed example -->
    <div class="bg-white rounded-xl shadow-sm p-6">
      <div class="flex items-center mb-4">
        <img src="https://i.pravatar.cc/150?img=32" alt="User" class="w-12 h-12 rounded-full mr-4">
        <div>
          <h6 class="font-semibold text-gray-800 mb-0">Eco Warrior</h6>
          <small class="text-gray-500">5 hours ago</small>
        </div>
      </div>
      <p class="text-gray-700 mb-4">Just participated in our local beach cleanup! 🏖️ So proud of our community coming together to keep our shores clean. #CleanifyCommunity</p>
      <div class="flex items-center mt-4">
        <button class="flex items-center text-gray-600 hover:text-red-500 transition-colors duration-300 mr-6">
          <i class="fas fa-heart mr-2"></i>
          <span class="text-sm">28 likes</span>
        </button>
        <button class="flex items-center text-gray-600 hover:text-blue-500 transition-colors duration-300" onclick="openModal('commentsModal')">
          <i class="fas fa-comment mr-2"></i>
          <span class="text-sm">7 comments</span>
        </button>
      </div>
    </div>
  </div>
@endsection

@push('modals')
  <!-- Comments Modal -->
  <x-modal id="commentsModal" title="Comments" icon="fas fa-comment-dots" color="green">
    <!-- Dummy Comments -->
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
    <div class="flex mb-4">
      <img src="https://i.pravatar.cc/150?img=27" alt="User" class="w-10 h-10 rounded-full mr-3">
      <div class="flex-1">
        <div class="flex items-center mb-1">
          <strong class="text-gray-800">Anna Reyes</strong>
          <small class="text-gray-500 ml-2">• 1h ago</small>
        </div>
        <p class="text-gray-700">We should do a cleanup event this weekend!</p>
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
