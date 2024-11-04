<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Avatar') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update $user->first_name $user->last_name's profile avatar") }}
        </p>
    </header>
    <form action="{{ route('admin.users.update-avatar', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data"  class="mt-6 space-y-6">
        @csrf
        @method('PATCH')
        <x-upload-avatar />
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-500"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
