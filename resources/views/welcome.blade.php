@extends('layouts.guest')

@section('content')
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
    <!-- Left Side - Text Content -->
    <div class="text-center md:text-left">
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 text-white">Welcome to Cleanify</h1>
      <p class="text-lg md:text-xl mb-8 text-gray-200">Empowering communities for a cleaner and greener tomorrow.</p>
      <a href="{{ route('login') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-medium rounded-full px-8 py-3 transition-colors duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
        Get Started
      </a>
    </div>

    <!-- Right Side - Visual Elements -->
    <div class="relative flex items-center justify-center md:justify-end">
      <!-- Logo -->
      <div class="absolute top-0 right-0 md:top-8 md:right-8 z-20">
        <img src="/assets/icons/cleanifyicon.png" alt="Cleanify Logo" class="w-24 h-24 md:w-32 md:h-32 opacity-90">
      </div>
      
      <!-- Seedling Illustration -->
      <div class="relative z-10 mt-16 md:mt-0">
        <div class="relative">
          <!-- Seedling SVG -->
          <svg class="w-48 h-64 md:w-64 md:h-80" viewBox="0 0 200 300" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Pot -->
            <rect x="70" y="220" width="60" height="50" rx="5" fill="#8B4513" opacity="0.8"/>
            <ellipse cx="100" cy="220" rx="35" ry="8" fill="#A0522D" opacity="0.8"/>
            
            <!-- Stem -->
            <line x1="100" y1="220" x2="100" y2="120" stroke="#4CAF50" stroke-width="8" stroke-linecap="round"/>
            
            <!-- Left Leaf -->
            <g transform="translate(100,100) rotate(-20) translate(-100,-100)">
              <ellipse cx="100" cy="100" rx="50" ry="60" fill="#66BB6A" opacity="0.9"/>
            </g>
            
            <!-- Right Leaf -->
            <g transform="translate(100,100) rotate(20) translate(-100,-100)">
              <ellipse cx="100" cy="100" rx="50" ry="60" fill="#4CAF50" opacity="0.9"/>
            </g>
            
            <!-- Water Droplets -->
            <circle cx="80" cy="90" r="4" fill="#E3F2FD" opacity="0.9"/>
            <circle cx="120" cy="85" r="3" fill="#E3F2FD" opacity="0.9"/>
            <circle cx="75" cy="110" r="3.5" fill="#E3F2FD" opacity="0.9"/>
            <circle cx="125" cy="105" r="4" fill="#E3F2FD" opacity="0.9"/>
            <circle cx="90" cy="115" r="3" fill="#E3F2FD" opacity="0.9"/>
            <circle cx="110" cy="120" r="3.5" fill="#E3F2FD" opacity="0.9"/>
            <circle cx="85" cy="100" r="2.5" fill="#E3F2FD" opacity="0.9"/>
            <circle cx="115" cy="95" r="3" fill="#E3F2FD" opacity="0.9"/>
          </svg>
        </div>
      </div>
    </div>
  </div>
@endsection

