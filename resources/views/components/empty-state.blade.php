@props(['icon' => 'fa-inbox', 'title' => 'No items found', 'description' => 'There are no items to display at this time.', 'action' => null, 'actionLabel' => null])

<div class="text-center py-12 px-4">
  <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
    <i class="fas {{ $icon }} text-4xl text-gray-400"></i>
  </div>
  <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $title }}</h3>
  <p class="text-gray-600 mb-6 max-w-md mx-auto">{{ $description }}</p>
  @if($action && $actionLabel)
    <a href="{{ $action }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
      <i class="fas fa-plus mr-2"></i>
      {{ $actionLabel }}
    </a>
  @endif
  {{ $slot }}
</div>

