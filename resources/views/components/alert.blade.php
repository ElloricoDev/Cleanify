@props(['type' => 'info', 'dismissible' => false, 'icon' => null])

@php
$typeClasses = [
    'success' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'text' => 'text-green-800', 'icon' => 'text-green-400'],
    'error' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'text' => 'text-red-800', 'icon' => 'text-red-400'],
    'warning' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'text' => 'text-yellow-800', 'icon' => 'text-yellow-400'],
    'info' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-800', 'icon' => 'text-blue-400'],
];

$icons = [
    'success' => 'fa-check-circle',
    'error' => 'fa-exclamation-circle',
    'warning' => 'fa-exclamation-triangle',
    'info' => 'fa-info-circle',
];

$classes = $typeClasses[$type] ?? $typeClasses['info'];
$iconClass = $icon ?: ($icons[$type] ?? 'fa-info-circle');
@endphp

<div {{ $attributes->merge(['class' => $classes['bg'] . ' border-l-4 ' . $classes['border'] . ' p-4 rounded-lg']) }}>
  <div class="flex items-start">
    <div class="flex-shrink-0">
      <i class="fas {{ $iconClass }} {{ $classes['icon'] }} text-lg"></i>
    </div>
    <div class="ml-3 flex-1">
      <p class="{{ $classes['text'] }} text-sm font-medium">
        {{ $slot }}
      </p>
    </div>
    @if($dismissible)
      <div class="ml-auto pl-3">
        <button onclick="this.parentElement.parentElement.parentElement.remove()" class="{{ $classes['text'] }} hover:opacity-75 transition-opacity duration-300">
          <i class="fas fa-times"></i>
        </button>
      </div>
    @endif
  </div>
</div>

