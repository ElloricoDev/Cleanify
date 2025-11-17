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
