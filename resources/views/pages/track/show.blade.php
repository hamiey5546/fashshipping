@extends('layouts.app')

@section('title', 'Tracking '.$shipment->tracking_id.' — FashShipping')

@push('head')
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
@endpush

@section('content')
    @php
        $statusLabels = [
            'pending' => ['Pending', 'bg-slate-100 text-slate-700 border-slate-200'],
            'in_transit' => ['In Transit', 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            'out_for_delivery' => ['Out for Delivery', 'bg-amber-50 text-amber-700 border-amber-200'],
            'delivered' => ['Delivered', 'bg-sky-50 text-sky-700 border-sky-200'],
            'delayed' => ['Delayed', 'bg-rose-50 text-rose-700 border-rose-200'],
            'on_hold' => ['On Hold', 'bg-rose-50 text-rose-700 border-rose-200'],
        ];
        [$statusText, $statusClasses] = $statusLabels[$shipment->status] ?? [ucfirst(str_replace('_', ' ', $shipment->status)), 'bg-slate-100 text-slate-700 border-slate-200'];

        $shippingMethodLabels = [
            'air' => 'Air',
            'sea' => 'Sea',
            'express' => 'Express',
        ];

        $shippingMethodText = $shipment->shipping_method ? ($shippingMethodLabels[$shipment->shipping_method] ?? ucfirst($shipment->shipping_method)) : '—';
    @endphp

    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <div class="text-xs font-medium text-slate-500">Tracking ID</div>
                <div class="mt-1 flex items-center gap-3">
                    <h1 class="text-2xl font-semibold tracking-tight text-slate-900">{{ $shipment->tracking_id }}</h1>
                    <span class="rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses }}">{{ $statusText }}</span>
                </div>
                <div class="mt-2 text-sm text-slate-600">
                    Estimated delivery:
                    <span class="font-medium text-slate-900">
                        {{ $shipment->estimated_delivery_date?->format('M j, Y') ?? '—' }}
                    </span>
                </div>
            </div>

            <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
                <a href="{{ route('track') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 shadow-sm transition hover:bg-slate-50">
                    Track another package
                </a>
            </div>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-12">
            <div class="lg:col-span-7">
                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-6 py-5">
                        <div class="text-sm font-semibold text-slate-900">World Map Tracking</div>
                        <div class="mt-1 text-xs text-slate-500">Route playback uses shipment checkpoints.</div>
                    </div>
                    <div class="relative">
                        <div
                            id="map"
                            class="h-[420px] w-full"
                            data-fs-mapbox="1"
                            data-mapbox-token="{{ $mapboxToken }}"
                            data-route-points='@json($routePoints)'
                        ></div>
                        @if (! filled($mapboxToken))
                            <div class="absolute inset-0 grid place-items-center bg-white/85 px-6 text-center">
                                <div class="max-w-md">
                                    <div class="text-sm font-semibold text-slate-900">Mapbox token missing</div>
                                    <div class="mt-2 text-sm text-slate-600">
                                        Set <span class="font-semibold">MAPBOX_TOKEN</span> in your environment, or add it via Admin → Settings.
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="text-xs font-semibold text-slate-700">Sender</div>
                        <div class="mt-3 space-y-1 text-sm">
                            <div class="font-semibold text-slate-900">{{ $shipment->sender_name }}</div>
                            @if ($shipment->sender_email)<div class="text-slate-600">{{ $shipment->sender_email }}</div>@endif
                            @if ($shipment->sender_phone)<div class="text-slate-600">{{ $shipment->sender_phone }}</div>@endif
                            @if ($shipment->sender_address)<div class="text-slate-600">{{ $shipment->sender_address }}</div>@endif
                        </div>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="text-xs font-semibold text-slate-700">Receiver</div>
                        <div class="mt-3 space-y-1 text-sm">
                            <div class="font-semibold text-slate-900">{{ $shipment->receiver_name }}</div>
                            @if ($shipment->receiver_email)<div class="text-slate-600">{{ $shipment->receiver_email }}</div>@endif
                            @if ($shipment->receiver_phone)<div class="text-slate-600">{{ $shipment->receiver_phone }}</div>@endif
                            @if ($shipment->receiver_address)<div class="text-slate-600">{{ $shipment->receiver_address }}</div>@endif
                        </div>
                    </div>
                </div>

                <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-xs font-semibold text-slate-700">Parcel Details</div>
                    <div class="mt-4 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="text-xs font-medium text-slate-500">Weight</div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $shipment->parcel_weight ? $shipment->parcel_weight.' kg' : '—' }}</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="text-xs font-medium text-slate-500">Type</div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $shipment->parcel_category ?? '—' }}</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:col-span-1">
                            <div class="text-xs font-medium text-slate-500">Description</div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $shipment->parcel_description ?? '—' }}</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:col-span-3">
                            <div class="text-xs font-medium text-slate-500">Value</div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">
                                {{ $shipment->parcel_value !== null ? number_format((float) $shipment->parcel_value, 2) : '—' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-xs font-semibold text-slate-700">Shipping</div>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="text-xs font-medium text-slate-500">Origin</div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $shipment->origin?->label ?? '—' }}</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="text-xs font-medium text-slate-500">Destination</div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $shipment->destination?->label ?? '—' }}</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="text-xs font-medium text-slate-500">Shipping method</div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $shippingMethodText }}</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="text-xs font-medium text-slate-500">Dispatch date</div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $shipment->dispatch_date?->format('M j, Y') ?? '—' }}</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:col-span-2">
                            <div class="text-xs font-medium text-slate-500">Estimated delivery date</div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $shipment->estimated_delivery_date?->format('M j, Y') ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-6 py-5">
                        <div class="text-sm font-semibold text-slate-900">Shipment Timeline</div>
                        <div class="mt-1 text-xs text-slate-500">Chronological events, most recent at the bottom.</div>
                    </div>
                    <div class="px-6 py-6">
                        <div class="space-y-5">
                            @forelse ($shipment->events as $event)
                                <div class="flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="size-3 rounded-full bg-[#FF7A00]"></div>
                                        <div class="mt-1 w-px flex-1 bg-slate-200"></div>
                                    </div>
                                    <div class="flex-1 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                                        <div class="flex flex-wrap items-center justify-between gap-2">
                                            <div class="text-sm font-semibold text-slate-900">
                                                {{ $event->title ?? ucfirst(str_replace('_', ' ', $event->status)) }}
                                            </div>
                                            <div class="text-xs font-medium text-slate-500">{{ $event->occurred_at?->format('M j, Y • H:i') }}</div>
                                        </div>
                                        <div class="mt-2 flex items-center justify-between gap-4">
                                            <div class="text-sm text-slate-600">{{ $event->location?->label ?? '—' }}</div>
                                            <span class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                                {{ ucfirst(str_replace('_', ' ', $event->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-sm text-slate-600">No tracking events yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
