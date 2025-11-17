@extends('layouts.guest')

@section('content')
  <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to Cleanify</h1>
  <p class="text-xl mb-8">Empowering communities for a cleaner and greener tomorrow.</p>
  <a href="{{ route('login') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-medium rounded-full px-8 py-3 transition-colors duration-300">
    Get Started
  </a>
@endsection

