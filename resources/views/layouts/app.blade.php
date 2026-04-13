<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name'))</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body class="min-h-screen bg-white text-slate-900 antialiased">
        <div class="relative isolate">
            <header class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/70 backdrop-blur">
                <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-4 sm:px-6">
                    <a href="{{ route('home', [], false) }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/fashshipping-mark.svg') }}" alt="{{ config('app.name') }}" class="size-10 rounded-2xl shadow-sm" />
                        <div class="leading-tight">
                            <div class="text-sm font-semibold text-slate-900">FashShipping</div>
                            <div class="text-xs text-slate-500">Courier & Tracking</div>
                        </div>
                    </a>

                    <nav class="hidden items-center gap-1 text-sm font-medium text-slate-700 md:flex">
                        <a class="rounded-lg px-3 py-2 transition hover:bg-slate-100" href="{{ route('home', [], false) }}">Home</a>
                        <a class="rounded-lg px-3 py-2 transition hover:bg-slate-100" href="{{ route('home', [], false) }}#services">Services</a>
                        <a class="rounded-lg px-3 py-2 transition hover:bg-slate-100" href="{{ route('home', [], false) }}#solutions">Solutions</a>
                        <a class="rounded-lg px-3 py-2 transition hover:bg-slate-100" href="{{ route('home', [], false) }}#testimonials">Testimonials</a>
                        <a class="rounded-lg px-3 py-2 transition hover:bg-slate-100" href="{{ route('home', [], false) }}#quote">Get a Quote</a>
                        <a class="rounded-lg px-3 py-2 transition hover:bg-slate-100" href="{{ route('tracking', [], false) }}">Track</a>
                        <a class="rounded-lg px-3 py-2 transition hover:bg-slate-100" href="{{ route('contact', [], false) }}">Contact</a>
                    </nav>

                    <div class="flex items-center gap-2 md:hidden">
                        <a href="{{ route('tracking', [], false) }}" class="rounded-xl bg-[#0A2540] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:brightness-110">
                            Track
                        </a>
                        <button
                            type="button"
                            id="fs-mobile-toggle"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-slate-700 shadow-sm transition hover:bg-slate-50"
                            aria-label="Open menu"
                            aria-expanded="false"
                        >
                            <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 6h16"></path>
                                <path d="M4 12h16"></path>
                                <path d="M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div id="fs-mobile-menu" class="hidden border-t border-slate-200/70 bg-white/90 backdrop-blur md:hidden">
                    <div class="mx-auto max-w-6xl px-4 py-4 sm:px-6">
                        <div class="grid gap-2 text-sm font-medium text-slate-700">
                            <a class="rounded-xl px-4 py-3 transition hover:bg-slate-100" href="{{ route('home', [], false) }}">Home</a>
                            <a class="rounded-xl px-4 py-3 transition hover:bg-slate-100" href="{{ route('home', [], false) }}#services">Services</a>
                            <a class="rounded-xl px-4 py-3 transition hover:bg-slate-100" href="{{ route('home', [], false) }}#solutions">Solutions</a>
                            <a class="rounded-xl px-4 py-3 transition hover:bg-slate-100" href="{{ route('home', [], false) }}#testimonials">Testimonials</a>
                            <a class="rounded-xl px-4 py-3 transition hover:bg-slate-100" href="{{ route('home', [], false) }}#quote">Get a Quote</a>
                            <a class="rounded-xl px-4 py-3 transition hover:bg-slate-100" href="{{ route('tracking', [], false) }}">Track Shipment</a>
                            <a class="rounded-xl px-4 py-3 transition hover:bg-slate-100" href="{{ route('contact', [], false) }}">Contact</a>
                        </div>
                    </div>
                </div>
            </header>

            <main>
                @yield('content')
            </main>

            <footer class="border-t border-slate-200 bg-white">
                <div class="mx-auto flex max-w-6xl flex-col gap-4 px-4 py-10 text-sm text-slate-600 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-slate-900">{{ config('app.name') }}</span>
                        <span class="text-slate-400">•</span>
                        <span>Delivering Efficiency. Driving Growth.</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <a class="transition hover:text-slate-900" href="{{ route('tracking', [], false) }}">Tracking</a>
                        <a class="transition hover:text-slate-900" href="{{ route('contact', [], false) }}">Support</a>
                    </div>
                </div>
            </footer>
        </div>
        @stack('scripts')
    </body>
</html>
