@extends('layouts.guest')

@section('content')
  <div class="bg-black bg-opacity-30 p-10 rounded-xl w-full max-w-md mx-auto text-left text-white">
    <div class="text-3xl font-extrabold text-green-500 text-center tracking-wide mb-1">CLEANIFY</div>
    <p class="text-gray-300 italic text-center text-sm mb-6">One Click. One Report. One Clean Community.</p>

    <h5 class="text-white text-xl font-semibold text-center mb-3">Verify Your Email</h5>
    <p class="text-gray-300 text-center mb-6">
      Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we'll gladly send you another.
    </p>

    @if(session('status') == 'verification-link-sent')
      <x-alert type="success" dismissible class="mb-4">
        A new verification link has been sent to the email address you provided during registration.
      </x-alert>
    @endif

    <div class="space-y-4">
      <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2.5 rounded-md transition-colors duration-300 inline-flex items-center justify-center gap-2">
          <i class="fas fa-envelope"></i>
          Resend Verification Email
        </button>
      </form>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-2.5 rounded-md transition-colors duration-300 inline-flex items-center justify-center gap-2">
          <i class="fas fa-sign-out-alt"></i>
          Log Out
        </button>
      </form>
    </div>
  </div>
@endsection