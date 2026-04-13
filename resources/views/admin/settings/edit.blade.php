@extends('admin.layouts.app')

@section('title', 'Settings — Admin')

@section('content')
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="text-sm font-semibold text-slate-900">Settings</div>
        <div class="mt-1 text-xs text-slate-500">Configure integrations used on the tracking experience.</div>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <label class="text-sm font-medium text-slate-700" for="mapbox_token">Mapbox public token</label>
                <input
                    id="mapbox_token"
                    name="mapbox_token"
                    value="{{ old('mapbox_token', $mapboxToken) }}"
                    class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100"
                    placeholder="pk.eyJ1Ijoi..."
                />
                @error('mapbox_token')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                <div class="mt-2 text-xs text-slate-500">This token is used on the public tracking map.</div>
            </div>

            <div class="flex justify-end">
                <button class="rounded-xl bg-[#0A2540] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-110">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
@endsection
