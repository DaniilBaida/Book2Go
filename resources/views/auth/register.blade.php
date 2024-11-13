<x-guest-layout>
    <!-- Welcome Message -->
    <h1 class="text-3xl text-gray-800 font-bold mb-6">{{ __('Create your Account!') }}</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="items-center gap-6 grid grid-cols-1 sm:grid-cols-2">
            <div>
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Dropdown for Account Type -->
        <div class="mt-4">
            <x-input-label for="account_type">{{ __('Select Account Type:') }}</x-input-label>
            <select id="account_type" name="is_business" class="block w-full p-2.5 bg-gray-50 border text-gray-900 text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                <option value="0" selected>{{ __('User') }}</option>
                <option value="1">{{ __('Business') }}</option>
            </select>
        </div>

        <!-- Password -->
        <div class="mt-4 relative">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <x-text-input
                    id="password"
                    class="block mt-1 w-full pr-10"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                />
                <button
                    type="button"
                    onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 duration-300"
                >
                    <i id="eye-icon" class="fas fa-eye"></i>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="my-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Button Register -->
        <div class="flex items-center justify-between mt-6">
            
            <!-- Register Button -->
            <div class="text-sm">
                {{ __('Have an account?') }} <a class="font-medium text-blue-500 hover:text-blue-600" href="{{ route('login') }}">{{ __('Sign In') }}</a>
            </div>

            <div class="flex">
                <x-button class="mx-auto">
                    {{ __('Register') }}
                </x-button>
            </div>
        </div>
    </form>
</x-guest-layout>

<!-- Hide/Show password script -->
<script>
    function togglePassword() {
        const passwordField = document.getElementById("password");
        const confirmPasswordField = document.getElementById("password_confirmation");
        const eyeIcon = document.getElementById("eye-icon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            confirmPasswordField.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            confirmPasswordField.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
