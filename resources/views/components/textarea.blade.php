@props(['label' => null, 'name' => null, 'id' => null, 'error' => null, 'helper' => null, 'rows' => 4, 'required' => false, 'maxlength' => null])

@php
$inputId = $id ?? $name;
$hasError = $error !== null;
$errorClass = $hasError ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-green-500 focus:border-green-500';
@endphp

<div class="mb-4">
  @if($label)
    <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700 mb-2">
      {{ $label }}
      @if($required)
        <span class="text-red-500">*</span>
      @endif
    </label>
  @endif
  
  <textarea
    name="{{ $name }}"
    id="{{ $inputId }}"
    rows="{{ $rows }}"
    {{ $attributes->merge(['class' => 'w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 resize-none ' . $errorClass]) }}
    @if($required) required @endif
    @if($maxlength) maxlength="{{ $maxlength }}" @endif
  >{{ $slot }}</textarea>
  
  @if($maxlength)
    <div class="mt-1 flex justify-between items-center">
      @if($error)
        <p class="text-sm text-red-600">
          <i class="fas fa-exclamation-circle mr-1"></i>{{ $error }}
        </p>
      @elseif($helper)
        <p class="text-sm text-gray-500">{{ $helper }}</p>
      @else
        <span></span>
      @endif
      <span class="text-xs text-gray-500" id="{{ $inputId }}-counter">0 / {{ $maxlength }}</span>
    </div>
  @else
    @if($error)
      <p class="mt-1 text-sm text-red-600">
        <i class="fas fa-exclamation-circle mr-1"></i>{{ $error }}
      </p>
    @endif
    
    @if($helper && !$error)
      <p class="mt-1 text-sm text-gray-500">{{ $helper }}</p>
    @endif
  @endif
</div>

@if($maxlength)
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const textarea = document.getElementById('{{ $inputId }}');
  const counter = document.getElementById('{{ $inputId }}-counter');
  if (textarea && counter) {
    textarea.addEventListener('input', function() {
      counter.textContent = this.value.length + ' / {{ $maxlength }}';
    });
  }
});
</script>
@endpush
@endif

