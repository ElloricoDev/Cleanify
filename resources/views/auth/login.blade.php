@extends('layouts.guest')

@section('content')
  <div class="bg-black bg-opacity-30 p-10 rounded-xl w-full max-w-md mx-auto text-left text-white">
    <div class="text-3xl font-extrabold text-green-500 text-center tracking-wide mb-1">CLEANIFY</div>
    <p class="text-gray-300 italic text-center text-sm mb-6">One Click. One Report. One Clean Community.</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
      @csrf
      <div>
        <label for="email" class="block text-white mb-2">Email Address</label>
        <div class="relative">
          <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
          <input
            type="email"
            id="email"
            name="email"
            class="w-full bg-transparent border-0 border-b border-gray-400 text-white pl-10 pb-2 focus:outline-none focus:border-green-500"
            required
          >
        </div>
      </div>

      <div>
        <label for="password" class="block text-white mb-2">Password</label>
        <div class="relative">
          <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
          <input
            type="password"
            id="password"
            name="password"
            class="w-full bg-transparent border-0 border-b border-gray-400 text-white pl-10 pb-2 focus:outline-none focus:border-green-500"
            required
          >
        </div>
      </div>

      <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2.5 rounded-md transition-colors duration-300 inline-flex items-center justify-center gap-2">
        <i class="fas fa-sign-in-alt"></i>
        LOGIN
      </button>
    </form>

    <div class="mt-6 text-sm text-center space-y-2">
      <a href="{{ route('password.request') }}" class="text-green-500 hover:underline inline-flex items-center justify-center gap-1">
        <i class="fas fa-key mr-1"></i>Forgot Password?
      </a>
      <span class="text-gray-300 block">
        Didn't have an account?
        <a href="{{ route('register') }}" class="text-green-500 hover:underline inline-flex items-center gap-1">
          <i class="fas fa-user-plus"></i>
          Sign Up
        </a>
      </span>
    </div>
  </div>
@endsection