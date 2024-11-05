<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="font-sans antialiased dark:bg-white dark:text-white/50">
    @include('partials.navbar')

    <div class="max-w-7xl container mx-auto mt-8 text-black px-4 sm:px-6 lg:px-8">
        <h1>Bem-vindo à Landing Page</h1>
        <p>Conteúdo da página inicial</p>
    </div>
</body>
</html>
