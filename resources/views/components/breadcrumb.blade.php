@props(['items' => []])

<nav class="mb-4" aria-label="Breadcrumb">
  <ol class="flex items-center space-x-2 text-sm">
    @foreach($items as $index => $item)
      <li class="flex items-center">
        @if($index > 0)
          <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
        @endif
        @if(isset($item['url']) && $index < count($items) - 1)
          <a href="{{ $item['url'] }}" class="text-gray-600 hover:text-green-600 transition-colors duration-300">
            {{ $item['label'] }}
          </a>
        @else
          <span class="text-gray-900 font-medium">{{ $item['label'] }}</span>
        @endif
      </li>
    @endforeach
  </ol>
</nav>

