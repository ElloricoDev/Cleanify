<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cleanify | Eco-Friendly Living</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('head')
</head>
<body class="min-h-screen bg-gray-900">
  <section class="relative h-screen bg-cover bg-center" style="background-image: url('/assets/background.jpg')">
    <div class="absolute inset-0 bg-black opacity-60"></div>
    @hasSection('top-actions')
      <div class="absolute top-5 right-8 z-20">
        @yield('top-actions')
      </div>
    @endif
    <div class="relative z-10 h-full flex items-center justify-center text-center text-white px-4">
      <div class="w-full max-w-2xl">
        <img src="/assets/icons/cleanifyicon.png" alt="Cleanify Logo" class="w-32 h-auto mx-auto mb-4">
        @yield('content')
      </div>
    </div>
  </section>
</body>
</html>

