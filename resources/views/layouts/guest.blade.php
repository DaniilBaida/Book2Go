<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet"/>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-inter antialiased bg-gray-100 text-gray-600">

    <main class="bg-white">
        <div class="relative flex min-h-screen">
            
            <!-- Left Column for Content -->
            <div class="w-full md:w-1/2 flex items-center justify-center p-8">
                <div class="max-w-sm w-full">
                    <!-- Slot for Dynamic Content -->
                    {{ $slot }}
                </div>
            </div>

            <!-- Right Column for Image (Only on Medium and Above Screens) -->
            <div class="hidden md:block md:w-1/2 bg-cover bg-center" style="background-image: url('{{ asset('images/auth-image.jpg') }}');">
                <!-- Optional overlay or styling can go here -->
            </div>
        </div>
    </main>
    
</body>
</html>
