<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="h-screen antialiased leading-none">
<div class="container py-4 px-3 mx-auto min-vh-100">
    <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
        <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
            <span class="fs-4">{{ config('app.name') }}</span>
        </a>
    </header>

    <main class="min-vh-100">
        @yield('content')
    </main>

    <footer class="pt-5 my-5 text-muted border-top">
        Created by the Bootstrap team &middot; &copy; 2022
    </footer>
</div>
</body>
</html>
