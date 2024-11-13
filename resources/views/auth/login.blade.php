<x-guest-layout>
    <!-- Welcome Message -->
    <h1 class="text-3xl text-gray-800 font-bold mb-6">{{ __('Welcome back!') }}</h1>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"/>
        </div>
        
        <!-- Password -->
        <div class="mt-4 relative">
            <x-input-label for="password" :value="__('Password')"/>

            <div class="relative">
                <x-text-input
                    id="password"
                    class="block mt-1 w-full pr-10"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                />

                <button
                    type="button"
                    onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 duration-300"
                >
                    <i id="eye-icon" class="fas fa-eye"></i>
                </button>
            </div>

        </div>
        
        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        <!-- Forgot Password Link / Sign In Button -->
        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <div class="mr-1">
                    <a class="text-gray-600 hover:text-gray-900 text-sm underline hover:no-underline" href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                </div>
            @endif

            <!-- Sign In Button -->
            <x-button class="ml-3">
                {{ __('Sign In') }}
            </x-button>
        </div>

        <!-- Register Link -->
        <div class="mt-4 text-gray-600 border-t border-zinc-200 pt-5 text-sm">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" class="font-medium text-blue-500 hover:text-blue-600">
                {{ __('Register') }}
            </a>
        </div>
    </form>
</x-guest-layout>

<!-- Hide/Show Password Script -->
<script>
    function togglePassword() {
        const passwordField = document.getElementById("password");
        const eyeIcon = document.getElementById("eye-icon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
