<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Cleanify') | Cleanify</title>
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Custom CSS -->
  @vite(['resources/css/app.css'])
  
  @stack('styles')
</head>
<body class="bg-gray-50 overflow-hidden" style="font-family: 'Poppins', sans-serif;">
  <div class="flex h-screen">
    <!-- Sidebar -->
    <x-sidebar :active="$activePage ?? 'home'" />
    
    <!-- Main Content -->
    <div class="ml-64 flex-1 overflow-y-auto">
      <div class="p-6">
        @yield('content')
      </div>
    </div>
  </div>
  
  <!-- Modals -->
  @stack('modals')
  
  <!-- Scripts -->
  @stack('scripts')
  @vite(['resources/js/app.js'])
</body>
</html>
