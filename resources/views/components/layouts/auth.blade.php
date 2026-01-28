<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'SHesap') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white font-sans antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12">
        <!-- Logo -->
        <div class="mb-8">
            <a href="/" class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-purple-400">
                    {{ config('app.name', 'SHesap') }}
                </span>
            </a>
        </div>

        <!-- Auth Card -->
        <div class="w-full max-w-md">
            <div class="bg-slate-800/50 backdrop-blur-xl rounded-2xl shadow-2xl shadow-black/20 border border-slate-700/50 p-8">
                {{ $slot }}
            </div>
        </div>

        <!-- Footer -->
        <p class="mt-8 text-sm text-slate-500">
            &copy; {{ date('Y') }} {{ config('app.name', 'SHesap') }}. Tüm hakları saklıdır.
        </p>
    </div>
</body>
</html>
