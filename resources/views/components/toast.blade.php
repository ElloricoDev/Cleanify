@props(['id' => 'toast', 'type' => 'info', 'message' => '', 'duration' => 5000])

@php
$typeClasses = [
    'success' => 'bg-green-600',
    'error' => 'bg-red-600',
    'warning' => 'bg-yellow-600',
    'info' => 'bg-blue-600',
];

$icons = [
    'success' => 'fa-check-circle',
    'error' => 'fa-exclamation-circle',
    'warning' => 'fa-exclamation-triangle',
    'info' => 'fa-info-circle',
];

$headerClass = $typeClasses[$type] ?? 'bg-blue-600';
$icon = $icons[$type] ?? 'fa-info-circle';
@endphp

<div id="{{ $id }}" class="fixed top-4 right-4 z-50 transform translate-x-full transition-transform duration-300 hidden">
  <div class="bg-white rounded-lg shadow-xl max-w-sm w-full overflow-hidden">
    <div class="{{ $headerClass }} text-white px-4 py-3 flex items-center justify-between">
      <div class="flex items-center">
        <i class="fas {{ $icon }} mr-2"></i>
        <span class="font-semibold capitalize">{{ $type }}</span>
      </div>
      <button onclick="closeToast('{{ $id }}')" class="text-white hover:text-gray-200 transition-colors duration-300">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="px-4 py-3 text-gray-800">
      {{ $message ?: $slot }}
    </div>
    @if($duration > 0)
      <div class="h-1 bg-gray-200">
        <div class="h-full {{ $headerClass }} toast-progress" style="animation: toastProgress {{ $duration }}ms linear forwards;"></div>
      </div>
    @endif
  </div>
</div>

<style>
@keyframes toastProgress {
  from {
    width: 100%;
  }
  to {
    width: 0%;
  }
}
</style>

