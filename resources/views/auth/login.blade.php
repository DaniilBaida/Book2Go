<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                          autofocus autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
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

        <!-- Remember Me -->
        <div class="block my-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Log in button -->
        <div class="flex">
            <x-primary-button class="mx-auto">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- Useful links -->
        <div class="flex flex-col mt-4 text-sm">
            <!-- Forgot Password -->
            @if (Route::has('password.request'))
                <a class="underline text-gray-600 hover:text-gray-900 mx-auto" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            <!-- Register Button -->
            <div class="text-gray-600 mx-auto">
                Don't have an account?
                <a href="{{ route('register') }}" class="underline text-gray-600 hover:text-gray-900">
                    Register here
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>

<!-- Hide/Show password script -->
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



