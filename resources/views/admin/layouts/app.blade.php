<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Admin — '.config('app.name'))</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
        <div class="min-h-screen">
            <header class="border-b border-slate-200 bg-white">
                <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/fashshipping-mark.svg') }}" alt="{{ config('app.name') }}" class="size-10 rounded-2xl shadow-sm" />
                        <div class="leading-tight">
                            <div class="text-sm font-semibold text-slate-900">Admin</div>
                            <div class="text-xs text-slate-500">{{ config('app.name') }}</div>
                        </div>
                    </a>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">User site</a>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button class="rounded-lg bg-slate-900 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:brightness-110">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <div class="mx-auto grid max-w-6xl gap-6 px-4 py-8 sm:px-6 lg:grid-cols-12">
                <aside class="lg:col-span-3">
                    <nav class="space-y-2 rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                        <a href="{{ route('admin.dashboard') }}" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 transition hover:bg-slate-50">Dashboard</a>
                        <a href="{{ route('admin.settings.edit') }}" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 transition hover:bg-slate-50">Settings</a>
                        <a href="{{ route('admin.shipments.index') }}" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 transition hover:bg-slate-50">Shipments</a>
                        <a href="{{ route('admin.shipments.create') }}" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 transition hover:bg-slate-50">Create Shipment</a>
                    </nav>
                </aside>
                <main class="lg:col-span-9">
                    @if (session('status'))
                        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                            {{ session('status') }}
                        </div>
                    @endif
                    @yield('content')
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
