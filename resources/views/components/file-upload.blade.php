@props(['name' => null, 'id' => null, 'label' => null, 'accept' => 'image/*', 'multiple' => false, 'error' => null, 'helper' => null, 'required' => false])

@php
$inputId = $id ?? $name ?? 'file-upload-' . uniqid();
$hasError = $error !== null;
$errorClass = $hasError ? 'border-red-500' : 'border-gray-300';
@endphp

<div class="mb-4">
  @if($label)
    <label class="block text-sm font-medium text-gray-700 mb-2">
      {{ $label }}
      @if($required)
        <span class="text-red-500">*</span>
      @endif
    </label>
  @endif
  
  <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed {{ $errorClass }} rounded-lg hover:border-green-500 transition-colors duration-300">
    <div class="space-y-1 text-center">
      <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
      <div class="flex text-sm text-gray-600">
        <label for="{{ $inputId }}" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
          <span>Upload a file</span>
          <input 
            id="{{ $inputId }}" 
            name="{{ $name }}" 
            type="file" 
            class="sr-only" 
            accept="{{ $accept }}"
            @if($multiple) multiple @endif
            @if($required) required @endif
            onchange="handleFileUpload(this)"
          >
        </label>
        <p class="pl-1">or drag and drop</p>
      </div>
      <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
    </div>
  </div>
  
  <div id="{{ $inputId }}-preview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 hidden"></div>
  
  @if($error)
    <p class="mt-1 text-sm text-red-600">
      <i class="fas fa-exclamation-circle mr-1"></i>{{ $error }}
    </p>
  @endif
  
  @if($helper && !$error)
    <p class="mt-1 text-sm text-gray-500">{{ $helper }}</p>
  @endif
</div>

@push('scripts')
<script>
function handleFileUpload(input) {
  const preview = document.getElementById(input.id + '-preview');
  if (!preview) return;
  
  preview.innerHTML = '';
  preview.classList.add('hidden');
  
  if (input.files && input.files.length > 0) {
    preview.classList.remove('hidden');
    
    Array.from(input.files).forEach((file, index) => {
      if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const div = document.createElement('div');
          div.className = 'relative';
          div.innerHTML = `
            <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-24 object-cover rounded-lg">
            <button type="button" onclick="removeFilePreview(this, '${input.id}', ${index})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors duration-300">
              <i class="fas fa-times text-xs"></i>
            </button>
          `;
          preview.appendChild(div);
        };
        reader.readAsDataURL(file);
      } else {
        const div = document.createElement('div');
        div.className = 'relative bg-gray-100 rounded-lg p-4';
        div.innerHTML = `
          <i class="fas fa-file text-2xl text-gray-400 mb-2"></i>
          <p class="text-xs text-gray-600 truncate">${file.name}</p>
          <button type="button" onclick="removeFilePreview(this, '${input.id}', ${index})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors duration-300">
            <i class="fas fa-times text-xs"></i>
          </button>
        `;
        preview.appendChild(div);
      }
    });
  }
}

function removeFilePreview(button, inputId, index) {
  const input = document.getElementById(inputId);
  if (input) {
    const dt = new DataTransfer();
    Array.from(input.files).forEach((file, i) => {
      if (i !== index) {
        dt.items.add(file);
      }
    });
    input.files = dt.files;
    handleFileUpload(input);
  }
  button.closest('.relative').remove();
}
</script>
@endpush

