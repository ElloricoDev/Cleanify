@extends('layouts.guest')

@section('content')
  <div class="bg-black bg-opacity-30 p-10 rounded-xl w-full max-w-md mx-auto text-left text-white">
    <div class="text-3xl font-extrabold text-green-500 text-center tracking-wide mb-1">CLEANIFY</div>
    <p class="text-gray-300 italic text-center text-sm mb-6">One Click. One Report. One Clean Community.</p>

    @if(session('status'))
      <x-alert type="success" dismissible class="mb-4">
        {{ session('status') }}
      </x-alert>
    @endif

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
            value="{{ old('email') }}"
            class="w-full bg-transparent border-0 border-b {{ $errors->has('email') ? 'border-red-500' : 'border-gray-400' }} text-white pl-10 pb-2 focus:outline-none focus:border-green-500 transition-colors duration-300"
            required
            autofocus
            autocomplete="email"
          >
        </div>
        @error('email')
          <p class="mt-2 text-sm text-red-400 font-semibold flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
          </p>
        @enderror
      </div>

      <div>
        <label for="password" class="block text-white mb-2">Password</label>
        <div class="relative">
          <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
          <input
            type="password"
            id="password"
            name="password"
            class="w-full bg-transparent border-0 border-b {{ $errors->has('password') ? 'border-red-500' : 'border-gray-400' }} text-white pl-10 pb-2 focus:outline-none focus:border-green-500 transition-colors duration-300"
            required
            autocomplete="current-password"
          >
        </div>
        @error('password')
          <p class="mt-2 text-sm text-red-400 font-semibold flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
          </p>
        @enderror
      </div>

      <div class="flex items-center">
        <input
          type="checkbox"
          id="remember"
          name="remember"
          value="1"
          {{ old('remember') ? 'checked' : '' }}
          class="w-4 h-4 text-green-600 bg-transparent border-gray-400 rounded focus:ring-green-500 focus:ring-2"
        >
        <label for="remember" class="ml-2 text-sm text-gray-300 cursor-pointer">Remember me</label>
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