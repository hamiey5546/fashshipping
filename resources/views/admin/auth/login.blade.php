<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Login — {{ config('app.name') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
        <div class="mx-auto flex min-h-screen max-w-md items-center px-4 py-16">
            <div class="w-full rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/fashshipping-mark.svg') }}" alt="{{ config('app.name') }}" class="size-11 rounded-2xl shadow-sm" />
                    <div>
                        <div class="text-sm font-semibold text-slate-900">Admin Login</div>
                        <div class="text-xs text-slate-500">{{ config('app.name') }}</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.login.submit') }}" class="mt-8 space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="text-sm font-medium text-slate-700">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                        @error('email')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="password" class="text-sm font-medium text-slate-700">Password</label>
                        <input id="password" name="password" type="password" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                        @error('password')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-[#0A2540] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-110 focus:outline-none focus:ring-4 focus:ring-slate-200">
                        Sign in
                    </button>
                </form>

                <div class="mt-6 text-center text-xs text-slate-500">
                    Need an admin account? Run the seed command in this project.
                </div>
            </div>
        </div>
    </body>
</html>
