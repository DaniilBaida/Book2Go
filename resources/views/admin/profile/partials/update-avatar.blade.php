<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile avatar") }}
        </p>

    </header>
    {{--
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>--}}

    <form method="post" action="{{ route('avatar.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('put')
        <x-upload-avatar/>
    </form>
</section>
