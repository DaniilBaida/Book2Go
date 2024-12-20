<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts and CSS -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Toastify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/ajax-navigation.js', 'resources/js/active-links.js', 'resources/js/ajax-content.js'])
</head>
<body
    class="bg-gray-100"
    x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') === 'true' }"
    x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))"
    x-cloak
>
    <div class="flex h-[100dvh] overflow-hidden">
        @yield('sidebar')
        <div class="flex flex-col flex-1 overflow-y-auto">
            @yield('header')
            <main id="main-content" class="grow">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Toast Notifications -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @if (session('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 5000, // Display for 5 seconds
                    close: true,
                    gravity: "bottom", // Display at the top
                    position: "right", // Align to the right
                    backgroundColor: "#4caf50", // Green for success
                    stopOnFocus: true // Pause on hover
                }).showToast();
            @endif

            @if (session('error'))
                Toastify({
                    text: "{{ session('error') }}",
                    duration: 5000, // Display for 5 seconds
                    close: true,
                    gravity: "bottom", // Display at the top
                    position: "right", // Align to the right
                    backgroundColor: "#f44336", // Red for error
                    stopOnFocus: true // Pause on hover
                }).showToast();
            @endif
        });
    </script>
</body>
</html>
