@extends('layouts.app')

@section('title', 'Profile')

@section('content')
  <!-- Profile Card -->
  <div class="bg-white rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row items-center md:items-start gap-6">
    <div class="w-28 h-28 rounded-full {{ $user->getAvatarBgClasses() }} flex items-center justify-center text-white font-bold text-4xl">
      {{ $user->getAvatarInitial() }}
    </div>
    <div class="flex-1 text-center md:text-left">
      <h5 class="text-green-600 font-bold text-xl mb-2">{{ $user->name }}</h5>
      <p class="text-gray-600 mb-1">
        <i class="fas fa-envelope mr-2 text-green-500"></i>{{ $user->email }}
      </p>
      @if($user->phone)
        <p class="text-gray-600 mb-1">
          <i class="fas fa-phone mr-2 text-green-500"></i>{{ $user->phone }}
        </p>
      @endif
      <p class="text-gray-600">
        <i class="fas fa-map-marker-alt mr-2 text-green-500"></i>{{ $user->address ?? $user->service_area ?? 'No address set' }}
      </p>
    </div>
    <button onclick="openModal('editProfileModal')" class="px-6 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-colors duration-300">
      <i class="fas fa-edit mr-2"></i>Edit Profile
    </button>
  </div>

  <!-- My Posts Section -->
  <h5 class="mb-4 text-green-600 font-semibold text-lg">
    <i class="fas fa-images mr-2"></i>My Posts ({{ $userReports->count() }})
  </h5>

  @forelse($userReports as $report)
    @php
      $userLiked = $report->likes->contains('user_id', $user->id);
    @endphp
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 relative" id="report-{{ $report->id }}">
      <!-- Post Options Dropdown -->
      <div class="absolute top-4 right-4">
        <button onclick="toggleDropdown('postDropdown{{ $report->id }}')" class="text-gray-500 hover:text-green-600 transition-colors duration-300">
          <i class="fas fa-ellipsis-v"></i>
        </button>
        <div id="postDropdown{{ $report->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
          <a href="#" onclick="openEditPostModal({{ $report->id }})" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <i class="fas fa-edit mr-2"></i>Edit
          </a>
          <a href="#" onclick="openDeletePostModal({{ $report->id }})" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
            <i class="fas fa-trash mr-2"></i>Delete
          </a>
        </div>
      </div>

      <!-- Post Header -->
      <div class="flex items-center mb-4">
        <div class="w-12 h-12 rounded-full {{ $user->getAvatarBgClasses() }} flex items-center justify-center text-white font-bold mr-4">
          {{ $user->getAvatarInitial() }}
        </div>
        <div class="flex-1">
          <h6 class="font-semibold text-green-600 mb-0">{{ $user->name }}</h6>
          <small class="text-gray-500">{{ $report->created_at?->diffForHumans() ?? 'Recently' }}</small>
        </div>
        <div>
          <span class="text-sm font-medium px-3 py-1 rounded-full {{ $report->getStatusBadgeBgClass() }}">
            {{ ucfirst($report->status) }}
          </span>
        </div>
      </div>

      <!-- Post Content -->
      <p class="text-gray-700 mb-4" id="report-description-{{ $report->id }}">{{ $report->description }}</p>
      <p class="text-sm text-gray-500 mb-4">
        <i class="fas fa-map-marker-alt mr-2"></i>{{ $report->location }}
      </p>
      @if($report->image_path)
        <img src="{{ asset('storage/' . $report->image_path) }}" alt="Post Image" class="w-full rounded-lg mb-4" id="report-image-{{ $report->id }}" onerror="this.style.display='none'">
      @endif

      <!-- Post Actions -->
      <div class="flex items-center mt-4">
        <button type="button" class="flex items-center text-gray-600 hover:text-red-500 transition-colors duration-300 mr-6 like-button {{ $userLiked ? 'text-red-500' : '' }}" data-report-id="{{ $report->id }}">
          <i class="fas fa-heart mr-2"></i>
          <span class="like-label">{{ $userLiked ? 'Liked' : 'Like' }}</span>
          <span class="like-count text-gray-600 ml-1">({{ $report->likes_count }})</span>
        </button>
        <button onclick="openCommentModal({{ $report->id }})" class="flex items-center text-gray-600 hover:text-blue-500 transition-colors duration-300">
          <i class="fas fa-comment mr-2"></i>
          <span class="text-sm">{{ $report->comments_count }} comments</span>
        </button>
      </div>
    </div>
  @empty
    <div class="bg-white rounded-xl shadow-sm p-12 text-center">
      <i class="fas fa-images text-gray-300 text-6xl mb-4"></i>
      <p class="text-gray-500 text-lg mb-2">No posts yet</p>
      <p class="text-gray-400 text-sm">Start sharing updates from your community!</p>
      <a href="{{ route('dashboard') }}" class="inline-block mt-4 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
        <i class="fas fa-plus mr-2"></i>Create Your First Post
      </a>
    </div>
  @endforelse
@endsection

@push('modals')
  <!-- Edit Profile Modal -->
  <x-modal id="editProfileModal" title="Edit Profile" icon="fas fa-edit" color="green">
    <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}">
      @csrf
      @method('PATCH')
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">Full Name</label>
        <input type="text" name="name" value="{{ $user->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">Email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">Phone</label>
        <input type="text" name="phone" value="{{ $user->phone ?? '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="+63 912 345 6789">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">Address</label>
        <input type="text" name="address" value="{{ $user->address ?? '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Barangay, City">
      </div>
    </form>
    
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('editProfileModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">Cancel</button>
        <button type="button" onclick="submitProfileForm()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">Save Changes</button>
      </div>
    @endslot
  </x-modal>

  <!-- Edit Post Modal -->
  <x-modal id="editPostModal" title="Edit Post" icon="fas fa-edit" color="green">
    <form id="editPostForm" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PATCH')
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">Location</label>
        <input type="text" name="location" id="editPostLocation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">Description</label>
        <textarea name="description" id="editPostDescription" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none" required></textarea>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">Image (optional - leave empty to keep current)</label>
        <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
        <p class="text-sm text-gray-500 mt-1">Current image will be replaced if a new one is uploaded.</p>
      </div>
    </form>
    
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('editPostModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">Cancel</button>
        <button onclick="submitEditPost()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">Save Changes</button>
      </div>
    @endslot
  </x-modal>

  <!-- Delete Confirmation Modal -->
  <x-modal id="deletePostModal" title="Delete Post" icon="fas fa-trash" color="red">
    <p class="text-gray-700 text-center">Are you sure you want to delete this post? This action cannot be undone.</p>
    
    @slot('footer')
      <div class="flex justify-end space-x-3">
        <button onclick="closeModal('deletePostModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">Cancel</button>
        <button onclick="confirmDeletePost()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300">Delete</button>
      </div>
    @endslot
  </x-modal>

  <!-- Comment Modal -->
  <x-modal id="commentModal" title="Comments" icon="fas fa-comment-dots" color="green">
    <div id="commentsContainer" class="max-h-96 overflow-y-auto space-y-4 mb-4">
      <!-- Comments will be loaded here -->
    </div>
    
    @slot('footer')
      <div class="flex">
        <textarea id="commentInput" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none" placeholder="Add a comment..." rows="2"></textarea>
        <button onclick="submitComment()" class="ml-3 px-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300 self-end">
          <i class="fas fa-paper-plane"></i>
        </button>
      </div>
    @endslot
  </x-modal>
@endpush

@push('scripts')
<script>
  let currentReportId = null;
  let currentDeleteReportId = null;

  // Edit Post Modal
  function openEditPostModal(reportId) {
    currentReportId = reportId;
    const report = @json($userReports->keyBy('id'));
    
    if (report[reportId]) {
      document.getElementById('editPostLocation').value = report[reportId].location;
      document.getElementById('editPostDescription').value = report[reportId].description;
      document.getElementById('editPostForm').action = `/profile/reports/${reportId}`;
      openModal('editPostModal');
    }
  }

  function submitEditPost() {
    const form = document.getElementById('editPostForm');
    const formData = new FormData(form);

    fetch(form.action, {
      method: 'PATCH',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      },
      body: formData,
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showToast('success', 'Post updated successfully');
        location.reload();
      } else {
        showToast('error', data.message || 'Failed to update post');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showToast('error', 'An error occurred');
    });
  }

  // Delete Post Modal
  function openDeletePostModal(reportId) {
    currentDeleteReportId = reportId;
    openModal('deletePostModal');
  }

  function confirmDeletePost() {
    if (!currentDeleteReportId) return;

    fetch(`/profile/reports/${currentDeleteReportId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Content-Type': 'application/json',
      },
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showToast('success', 'Post deleted successfully');
        document.getElementById(`report-${currentDeleteReportId}`).remove();
        closeModal('deletePostModal');
        currentDeleteReportId = null;
        
        // Reload if no posts left
        if (document.querySelectorAll('[id^="report-"]').length === 0) {
          setTimeout(() => location.reload(), 1000);
        }
      } else {
        showToast('error', data.message || 'Failed to delete post');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showToast('error', 'An error occurred');
    });
  }

  // Comment Modal
  function openCommentModal(reportId) {
    currentReportId = reportId;
    const commentsContainer = document.getElementById('commentsContainer');
    commentsContainer.innerHTML = '<p class="text-center text-gray-500">Loading comments...</p>';

    fetch(`/reports/${reportId}/comments`)
      .then(response => response.json())
      .then(data => {
        commentsContainer.innerHTML = '';
        if (data.comments && data.comments.length > 0) {
          data.comments.forEach(comment => {
            const commentDiv = document.createElement('div');
            commentDiv.className = 'flex mb-4';
            commentDiv.innerHTML = `
              <div class="w-10 h-10 rounded-full ${comment.avatar || 'bg-gray-400'} flex items-center justify-center text-white font-bold mr-3">
                ${comment.initial || '?'}
              </div>
              <div class="flex-1">
                <div class="flex items-center mb-1">
                  <strong class="text-gray-800">${comment.author || 'User'}</strong>
                  <small class="text-gray-500 ml-2">• ${comment.timestamp || 'Just now'}</small>
                </div>
                <p class="text-gray-700">${comment.comment}</p>
              </div>
            `;
            commentsContainer.appendChild(commentDiv);
          });
        } else {
          commentsContainer.innerHTML = '<p class="text-center text-gray-500">No comments yet. Be the first to comment!</p>';
        }
      })
      .catch(error => {
        commentsContainer.innerHTML = '<p class="text-center text-red-500">Failed to load comments</p>';
      });

    openModal('commentModal');
  }

  function submitComment() {
    if (!currentReportId) return;

    const commentInput = document.getElementById('commentInput');
    const comment = commentInput.value.trim();

    if (!comment) {
      showToast('error', 'Please enter a comment');
      return;
    }

    fetch(`/reports/${currentReportId}/comment`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      },
      body: JSON.stringify({ comment }),
    })
    .then(response => response.json())
    .then(data => {
      if (data.comment) {
        commentInput.value = '';
        const commentsContainer = document.getElementById('commentsContainer');
        if (commentsContainer.innerHTML.includes('No comments')) {
          commentsContainer.innerHTML = '';
        }
        const commentDiv = document.createElement('div');
        commentDiv.className = 'flex mb-4';
        commentDiv.innerHTML = `
          <div class="w-10 h-10 rounded-full ${data.comment.avatar || 'bg-gray-400'} flex items-center justify-center text-white font-bold mr-3">
            ${data.comment.initial || '?'}
          </div>
          <div class="flex-1">
            <div class="flex items-center mb-1">
              <strong class="text-gray-800">${data.comment.author || 'You'}</strong>
              <small class="text-gray-500 ml-2">• ${data.comment.timestamp || 'Just now'}</small>
            </div>
            <p class="text-gray-700">${data.comment.comment}</p>
          </div>
        `;
        commentsContainer.appendChild(commentDiv);
        showToast('success', 'Comment added');
      } else {
        showToast('error', 'Failed to add comment');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showToast('error', 'An error occurred');
    });
  }

  // Like functionality
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.like-button').forEach(button => {
      button.addEventListener('click', function() {
        const reportId = this.getAttribute('data-report-id');
        const likeLabel = this.querySelector('.like-label');
        const likeCount = this.querySelector('.like-count');

        fetch(`/reports/${reportId}/like`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
        })
        .then(response => response.json())
        .then(data => {
          likeLabel.textContent = data.liked ? 'Liked' : 'Like';
          likeCount.textContent = `(${data.likes_count})`;
          this.classList.toggle('text-red-500', data.liked);
          this.classList.toggle('text-gray-600', !data.liked);
        })
        .catch(error => {
          console.error('Error:', error);
          showToast('error', 'Failed to like post');
        });
      });
    });
  });

  // Handle profile form submission
  function submitProfileForm() {
    const form = document.getElementById('editProfileForm');
    const formData = new FormData(form);

    fetch(form.action, {
      method: 'PATCH',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      },
      body: formData,
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showToast('success', 'Profile updated successfully');
        setTimeout(() => location.reload(), 1000);
      } else {
        showToast('error', data.message || 'Failed to update profile');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showToast('error', 'An error occurred');
    });
  }

  document.getElementById('editProfileForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    submitProfileForm();
  });
</script>
@endpush
