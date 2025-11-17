@extends('layouts.guest')

@push('head')
  <style>
    .otp-input {
      letter-spacing: 8px;
      text-align: center;
    }

    .otp-input::placeholder {
      letter-spacing: 8px;
      color: #9ca3af;
    }
  </style>
@endpush

@section('content')
  <div class="bg-black bg-opacity-30 p-10 rounded-xl w-full max-w-md mx-auto text-left text-white">
    <div class="text-3xl font-extrabold text-green-500 text-center tracking-wide mb-1">CLEANIFY</div>
    <p class="text-gray-300 italic text-center text-sm mb-6">One Click. One Report. One Clean Community.</p>

    <h5 class="text-white text-xl font-semibold text-center mb-3">Verify OTP</h5>
    <p class="text-gray-300 text-center mb-6">We sent a 6-digit OTP to your email. Please enter it below.</p>

    <form method="POST" action="#" class="space-y-6">
      @csrf
      <div>
        <div class="relative">
          <i class="fas fa-key absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
          <input
            type="text"
            maxlength="6"
            pattern="[0-9]*"
            class="w-full bg-transparent border-0 border-b-2 border-green-500 text-white pl-10 pb-2 focus:outline-none focus:border-green-400 otp-input text-2xl font-mono"
            placeholder="••••••"
            required
          >
        </div>
      </div>

      <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2.5 rounded-md transition-colors duration-300">
        VERIFY OTP
      </button>
    </form>

    <div class="mt-4 text-center">
      <a href="{{ route('password.request') }}" class="text-gray-300 hover:text-white transition-colors duration-300">
        Resend OTP
      </a>
    </div>
  </div>
@endsection