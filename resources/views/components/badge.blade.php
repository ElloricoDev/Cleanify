@props(['variant' => 'default', 'size' => 'md', 'removable' => false, 'icon' => null])

@php
$variants = [
    'default' => 'bg-gray-100 text-gray-800',
    'success' => 'bg-green-100 text-green-800',
    'warning' => 'bg-yellow-100 text-yellow-800',
    'danger' => 'bg-red-100 text-red-800',
    'info' => 'bg-blue-100 text-blue-800',
    'primary' => 'bg-green-600 text-white',
];

$sizes = [
    'sm' => 'text-xs px-2 py-0.5',
    'md' => 'text-sm px-2.5 py-0.5',
    'lg' => 'text-base px-3 py-1',
];

$variantClass = $variants[$variant] ?? $variants['default'];
$sizeClass = $sizes[$size] ?? $sizes['md'];
$baseClass = 'inline-flex items-center font-medium rounded-full';
@endphp

<span {{ $attributes->merge(['class' => $baseClass . ' ' . $variantClass . ' ' . $sizeClass]) }}>
  @if($icon)
    <i class="{{ $icon }} mr-1"></i>
  @endif
  {{ $slot }}
  @if($removable)
    <button type="button" onclick="this.parentElement.remove()" class="ml-1 hover:opacity-75 transition-opacity duration-300">
      <i class="fas fa-times text-xs"></i>
    </button>
  @endif
</span>

