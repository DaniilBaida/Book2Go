@extends('layouts.app')

@section('content')
    <main class="bg-white">
        <div class="relative flex min-h-screen">
            <!-- Left Column for Content -->
            <div class="w-full md:w-1/2 flex items-center justify-center p-8">
                <div class="max-w-sm w-full">
                    {{ $slot }}
                </div>
            </div>

            <!-- Right Column for Image -->
            <div class="hidden md:block md:w-1/2 bg-cover bg-center" style="background-image: url('{{ asset('images/auth-image.jpg') }}');"></div>
        </div>
    </main>
@endsection
