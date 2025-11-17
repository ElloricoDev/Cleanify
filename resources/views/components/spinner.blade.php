@props(['size' => 'md', 'color' => 'green', 'fullPage' => false])

@php
$sizes = [
    'sm' => 'w-4 h-4',
    'md' => 'w-8 h-8',
    'lg' => 'w-12 h-12',
    'xl' => 'w-16 h-16',
];

$colors = [
    'green' => 'text-green-600',
    'blue' => 'text-blue-600',
    'red' => 'text-red-600',
    'yellow' => 'text-yellow-600',
    'white' => 'text-white',
    'gray' => 'text-gray-600',
];

$sizeClass = $sizes[$size] ?? $sizes['md'];
$colorClass = $colors[$color] ?? $colors['green'];
@endphp

@if($fullPage)
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 flex flex-col items-center">
      <div class="{{ $sizeClass }} {{ $colorClass }} animate-spin mb-2">
        <i class="fas fa-spinner"></i>
      </div>
      <p class="text-gray-600 text-sm">Loading...</p>
    </div>
  </div>
@else
  <div class="inline-block {{ $sizeClass }} {{ $colorClass }} animate-spin">
    <i class="fas fa-spinner"></i>
  </div>
@endif

