import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Modal functions
window.openModal = function(modalId) {
  document.getElementById(modalId)?.classList.remove('hidden');
};

window.closeModal = function(modalId) {
  document.getElementById(modalId)?.classList.add('hidden');
};

// Toggle dropdown
window.toggleDropdown = function(dropdownId) {
  const dropdown = document.getElementById(dropdownId);
  if (dropdown) {
    dropdown.classList.toggle('hidden');
  }
};

// Close modals when clicking outside
document.addEventListener('click', function(e) {
  const modals = document.querySelectorAll('[id$="Modal"]');
  modals.forEach(modal => {
    if (e.target === modal) {
      closeModal(modal.id);
    }
  });
});

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
  if (!e.target.closest('.absolute')) {
    const dropdowns = document.querySelectorAll('[id$="Dropdown"]');
    dropdowns.forEach(dropdown => {
      dropdown.classList.add('hidden');
    });
  }
});

// Mobile Menu Functions
window.openMobileMenu = function() {
  const menu = document.getElementById('mobileMenu');
  const overlay = document.getElementById('mobileMenuOverlay');
  if (menu && overlay) {
    menu.classList.remove('-translate-x-full');
    overlay.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }
};

window.closeMobileMenu = function() {
  const menu = document.getElementById('mobileMenu');
  const overlay = document.getElementById('mobileMenuOverlay');
  if (menu && overlay) {
    menu.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
    document.body.style.overflow = '';
  }
};

// Admin Mobile Menu Functions
window.openAdminMobileMenu = function() {
  const menu = document.getElementById('adminMobileMenu');
  const overlay = document.getElementById('adminMobileMenuOverlay');
  if (menu && overlay) {
    menu.classList.remove('-translate-x-full');
    overlay.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }
};

window.closeAdminMobileMenu = function() {
  const menu = document.getElementById('adminMobileMenu');
  const overlay = document.getElementById('adminMobileMenuOverlay');
  if (menu && overlay) {
    menu.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
    document.body.style.overflow = '';
  }
};

// Initialize mobile menu event listeners
document.addEventListener('DOMContentLoaded', function() {
  // User mobile menu
  const mobileMenuButton = document.getElementById('mobileMenuButton');
  const closeMobileMenuBtn = document.getElementById('closeMobileMenu');
  const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
  
  if (mobileMenuButton) {
    mobileMenuButton.addEventListener('click', openMobileMenu);
  }
  if (closeMobileMenuBtn) {
    closeMobileMenuBtn.addEventListener('click', closeMobileMenu);
  }
  if (mobileMenuOverlay) {
    mobileMenuOverlay.addEventListener('click', closeMobileMenu);
  }
  
  // Admin mobile menu
  const adminMobileMenuButton = document.getElementById('adminMobileMenuButton');
  const closeAdminMobileMenuBtn = document.getElementById('closeAdminMobileMenu');
  const adminMobileMenuOverlay = document.getElementById('adminMobileMenuOverlay');
  
  if (adminMobileMenuButton) {
    adminMobileMenuButton.addEventListener('click', openAdminMobileMenu);
  }
  if (closeAdminMobileMenuBtn) {
    closeAdminMobileMenuBtn.addEventListener('click', closeAdminMobileMenu);
  }
  if (adminMobileMenuOverlay) {
    adminMobileMenuOverlay.addEventListener('click', closeAdminMobileMenu);
  }
});

// Toast Functions
window.showToast = function(type, message, duration = 5000) {
  const toastId = 'toast-' + Date.now();
  const toastContainer = document.getElementById('toastContainer') || createToastContainer();
  
  const toast = document.createElement('div');
  toast.id = toastId;
  toast.className = 'fixed top-4 right-4 z-50 transform translate-x-full transition-transform duration-300';
  
  const typeClasses = {
    success: { bg: 'bg-green-600', icon: 'fa-check-circle' },
    error: { bg: 'bg-red-600', icon: 'fa-exclamation-circle' },
    warning: { bg: 'bg-yellow-600', icon: 'fa-exclamation-triangle' },
    info: { bg: 'bg-blue-600', icon: 'fa-info-circle' },
  };
  
  const typeConfig = typeClasses[type] || typeClasses.info;
  
  toast.innerHTML = `
    <div class="bg-white rounded-lg shadow-xl max-w-sm w-full overflow-hidden">
      <div class="${typeConfig.bg} text-white px-4 py-3 flex items-center justify-between">
        <div class="flex items-center">
          <i class="fas ${typeConfig.icon} mr-2"></i>
          <span class="font-semibold capitalize">${type}</span>
        </div>
        <button onclick="closeToast('${toastId}')" class="text-white hover:text-gray-200 transition-colors duration-300">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="px-4 py-3 text-gray-800">${message}</div>
      ${duration > 0 ? `<div class="h-1 bg-gray-200">
        <div class="h-full ${typeConfig.bg} toast-progress" style="animation: toastProgress ${duration}ms linear forwards;"></div>
      </div>` : ''}
    </div>
  `;
  
  toastContainer.appendChild(toast);
  
  // Trigger animation
  setTimeout(() => {
    toast.classList.remove('translate-x-full');
  }, 10);
  
  // Auto remove
  if (duration > 0) {
    setTimeout(() => {
      closeToast(toastId);
    }, duration);
  }
  
  return toastId;
};

window.closeToast = function(toastId) {
  const toast = document.getElementById(toastId);
  if (toast) {
    toast.classList.add('translate-x-full');
    setTimeout(() => {
      toast.remove();
    }, 300);
  }
};

function createToastContainer() {
  const container = document.createElement('div');
  container.id = 'toastContainer';
  document.body.appendChild(container);
  return container;
}

// Add toast progress animation if not already in CSS
if (!document.getElementById('toastStyles')) {
  const style = document.createElement('style');
  style.id = 'toastStyles';
  style.textContent = `
    @keyframes toastProgress {
      from { width: 100%; }
      to { width: 0%; }
    }
  `;
  document.head.appendChild(style);
}
