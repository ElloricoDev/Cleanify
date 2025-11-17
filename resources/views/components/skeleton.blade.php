@props(['type' => 'text', 'lines' => 1, 'width' => 'full'])

@php
$widths = [
    'full' => 'w-full',
    '3/4' => 'w-3/4',
    '1/2' => 'w-1/2',
    '1/4' => 'w-1/4',
];

$widthClass = $widths[$width] ?? 'w-full';
@endphp

@if($type === 'text')
  <div class="space-y-2">
    @for($i = 0; $i < $lines; $i++)
      <div class="h-4 bg-gray-200 rounded animate-pulse {{ $i === $lines - 1 ? $widthClass : 'w-full' }}"></div>
    @endfor
  </div>
@elseif($type === 'image')
  <div class="bg-gray-200 rounded-lg animate-pulse aspect-video {{ $widthClass }}"></div>
@elseif($type === 'avatar')
  <div class="bg-gray-200 rounded-full animate-pulse w-12 h-12"></div>
@elseif($type === 'card')
  <div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex items-center mb-4">
      <div class="bg-gray-200 rounded-full animate-pulse w-12 h-12 mr-4"></div>
      <div class="flex-1">
        <div class="h-4 bg-gray-200 rounded animate-pulse w-1/3 mb-2"></div>
        <div class="h-3 bg-gray-200 rounded animate-pulse w-1/4"></div>
      </div>
    </div>
    <div class="space-y-2 mb-4">
      <div class="h-4 bg-gray-200 rounded animate-pulse w-full"></div>
      <div class="h-4 bg-gray-200 rounded animate-pulse w-5/6"></div>
    </div>
    <div class="bg-gray-200 rounded-lg animate-pulse aspect-video w-full"></div>
  </div>
@elseif($type === 'table')
  <div class="space-y-3">
    @for($i = 0; $i < $lines; $i++)
      <div class="flex space-x-4">
        <div class="h-4 bg-gray-200 rounded animate-pulse w-12"></div>
        <div class="h-4 bg-gray-200 rounded animate-pulse flex-1"></div>
        <div class="h-4 bg-gray-200 rounded animate-pulse w-24"></div>
        <div class="h-4 bg-gray-200 rounded animate-pulse w-20"></div>
      </div>
    @endfor
  </div>
@else
  <div class="h-4 bg-gray-200 rounded animate-pulse {{ $widthClass }}"></div>
@endif

