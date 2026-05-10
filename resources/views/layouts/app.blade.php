<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GlowFly') }}</title>

    <!-- Tailwind CSS with custom colors -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cosmeticBrown: '#654321',
                        cosmeticText: '#F5DEB3',
                        cosmeticHover: '#401d07',
                        cosmeticLight: '#fdf9ef',
                    }
                }
            }
        }

    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
</head>

<script>
    // Apply stored theme on load
    if (localStorage.theme === 'dark') {
        document.documentElement.classList.add('dark');
    }

    document.getElementById('theme-toggle')?.addEventListener('click', () => {
        const html = document.documentElement;

        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.theme = 'light';
        } else {
            html.classList.add('dark');
            localStorage.theme = 'dark';
        }
    });
</script>

<body class="font-sans bg-cosmeticLight text-cosmeticBrown dark:bg-gray-900 dark:text-white">


    {{-- Navbar --}}
    <x-navbar/>

    {{-- Main Content --}}
    <main class="py-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <x-footer />

</body>
</html>
