@extends('layouts.app')

@section('title', 'Contact — FashShipping')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
        <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
            <div>
                <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Contact</h1>
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-slate-600">
                    Send a message and our support team will respond as soon as possible.
                </p>

                @if (session('status'))
                    <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                        {{ session('status') }}
                    </div>
                @endif
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <form action="{{ route('contact.store', [], false) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-sm font-medium text-slate-700" for="name">Name</label>
                        <input id="name" name="name" value="{{ old('name') }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                        @error('name')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700" for="email">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                        @error('email')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700" for="message">Message</label>
                        <textarea id="message" name="message" rows="5" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required>{{ old('message') }}</textarea>
                        @error('message')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-[#0A2540] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-110 focus:outline-none focus:ring-4 focus:ring-slate-200">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
