<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin') | Cleanify Admin</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('styles')
</head>
<body class="bg-gray-50 overflow-x-hidden" style="font-family: 'Poppins', sans-serif;">
  <!-- Mobile Menu -->
  <x-admin.mobile-menu :active="$activePage ?? 'dashboard'" />
  
  <div class="flex h-screen">
    <x-admin.sidebar :active="$activePage ?? 'dashboard'" />

    <div class="lg:ml-64 flex-1 overflow-y-auto">
      <div class="p-4 lg:p-8">
        @yield('content')
      </div>
    </div>
  </div>

  @stack('modals')
  @stack('scripts')
  @vite(['resources/js/app.js'])
</body>
</html>

