<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    :root{
        --blue-900:#00324e;
        --blue-700:#005b82;
        --blue-500:#00a8e8;
        --muted:#cfe8f5;
    }

    body{
        margin:0;
        font-family:"Inter", sans-serif;
        background:linear-gradient(135deg, var(--blue-900), var(--blue-700));
        color:white;
    }

    .login-container{
        backdrop-filter:blur(8px);
        border:1px solid rgba(255,255,255,0.12);
        background:rgba(255,255,255,0.08);
        padding:32px;
        border-radius:16px;
        margin-top:50px;
    }
</style>

</head>
<body class="font-sans antialiased">
<div class="min-h-screen flex flex-col sm:justify-center items-center">

    <!-- Logo -->
    <div class="mb-4 mt-10">
        <a href="/">
          <!--  <x-application-logo class="w-20 h-20 text-white" />-->
        </a>
    </div>

    <!-- Layout Slot -->
    <div class="w-full sm:max-w-md login-container shadow-xl">
        {{ $slot }}
    </div>

</div>

</body>
</html>
