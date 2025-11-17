@props(['label' => null, 'name' => null, 'id' => null, 'error' => null, 'helper' => null, 'required' => false, 'placeholder' => 'Select an option'])

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
  
  <select
    name="{{ $name }}"
    id="{{ $inputId }}"
    {{ $attributes->merge(['class' => 'w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 ' . $errorClass]) }}
    @if($required) required @endif
  >
    <option value="">{{ $placeholder }}</option>
    {{ $slot }}
  </select>
  
  @if($error)
    <p class="mt-1 text-sm text-red-600">
      <i class="fas fa-exclamation-circle mr-1"></i>{{ $error }}
    </p>
  @endif
  
  @if($helper && !$error)
    <p class="mt-1 text-sm text-gray-500">{{ $helper }}</p>
  @endif
</div>

