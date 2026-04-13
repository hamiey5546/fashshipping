@extends('layouts.app')

@section('title', 'Track Package — FashShipping')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
        <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
            <div>
                <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Track your shipment</h1>
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-slate-600">
                    Enter your tracking ID to view status, checkpoints, and an animated route map.
                </p>

                <form action="{{ route('track.lookup', [], false) }}" method="POST" class="mt-8">
                    @csrf
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <label for="tracking_id" class="text-sm font-medium text-slate-700">Tracking ID</label>
                        <input
                            id="tracking_id"
                            name="tracking_id"
                            value="{{ old('tracking_id', $notFoundTrackingId ?? '') }}"
                            placeholder="FSH-9X82K3"
                            class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100"
                            required
                        />
                        @error('tracking_id')
                            <div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>
                        @enderror

                        @isset($notFoundTrackingId)
                            <div class="mt-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                                No shipment found for <span class="font-semibold">{{ $notFoundTrackingId }}</span>.
                            </div>
                        @endisset

                        <button
                            type="submit"
                            class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-[#0A2540] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-110 focus:outline-none focus:ring-4 focus:ring-slate-200"
                        >
                            Track Package
                        </button>
                    </div>
                </form>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-gradient-to-b from-slate-50 to-white p-6 shadow-sm">
                <div class="text-sm font-semibold text-slate-900">What you’ll see</div>
                <div class="mt-5 space-y-4">
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="text-xs font-semibold text-slate-700">Status</div>
                        <div class="mt-2 text-sm text-slate-600">Pending, In Transit, Out for Delivery, Delivered, Delayed</div>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="text-xs font-semibold text-slate-700">Timeline</div>
                        <div class="mt-2 text-sm text-slate-600">Chronological scan events with timestamps and locations</div>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="text-xs font-semibold text-slate-700">World map</div>
                        <div class="mt-2 text-sm text-slate-600">Animated route line and checkpoint playback</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
