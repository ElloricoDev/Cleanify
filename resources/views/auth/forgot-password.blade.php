@extends('layouts.guest')

@section('content')
  <div class="bg-black bg-opacity-30 p-10 rounded-xl w-full max-w-md mx-auto text-left text-white">
    <div class="text-3xl font-extrabold text-green-500 text-center tracking-wide mb-1">CLEANIFY</div>
    <p class="text-gray-300 italic text-center text-sm mb-6">One Click. One Report. One Clean Community.</p>

    <h5 class="text-white text-xl font-semibold text-center mb-3">Forgot Password</h5>
    <p class="text-gray-300 text-center mb-6">Enter your email address and we'll send you an OTP to reset your password.</p>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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

      <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2.5 rounded-md transition-colors duration-300">
        SEND OTP
      </button>
    </form>

    <div class="mt-4 text-center">
      <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors duration-300 inline-flex items-center gap-2">
        <i class="fas fa-arrow-left"></i>
        Back to Login
      </a>
    </div>
  </div>
@endsection
