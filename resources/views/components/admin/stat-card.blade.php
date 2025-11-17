@props([
  'icon',
  'title',
  'value',
  'borderClass' => 'border-l-4 border-green-500',
  'iconWrapperClass' => 'bg-green-100',
  'iconColorClass' => 'text-green-600',
])

<div {{ $attributes->merge(['class' => "bg-white rounded-lg p-4 shadow-sm $borderClass"]) }}>
  <div class="flex items-center">
    <div class="p-3 rounded-lg mr-4 {{ $iconWrapperClass }}">
      <i class="{{ $icon }} text-xl {{ $iconColorClass }}"></i>
    </div>
    <div>
      <p class="text-sm text-gray-600">{{ $title }}</p>
      <h3 class="text-2xl font-bold text-gray-800">{{ $value }}</h3>
    </div>
  </div>
</div>

