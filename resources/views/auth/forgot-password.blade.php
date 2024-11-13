<x-guest-layout>
    <h1 class="text-3xl text-gray-800 font-bold mb-6">{{ __('Forgot your password? ') }}</h1>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <x-button>
                {{ __('Email Password Reset Link') }}
            </x-button>

            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300">
                {{ __('Back') }}
            </a>
        </div>
    </form>
</x-guest-layout>
