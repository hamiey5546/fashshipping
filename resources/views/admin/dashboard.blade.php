@extends('admin.layouts.app')

@section('title', 'Dashboard — Admin')

@section('content')
    <div class="grid gap-6">
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Total shipments</div>
                <div class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">{{ $totalShipments }}</div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Active shipments</div>
                <div class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">{{ $activeShipments }}</div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Delivered shipments</div>
                <div class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">{{ $deliveredShipments }}</div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-5">
                    <div class="text-sm font-semibold text-slate-900">Recent shipments</div>
                </div>
                <div class="divide-y divide-slate-200">
                    @forelse ($recentShipments as $shipment)
                        <div class="flex items-center justify-between gap-4 px-6 py-4">
                            <div>
                                <div class="text-sm font-semibold text-slate-900">{{ $shipment->tracking_id }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $shipment->receiver_name }}</div>
                            </div>
                            <a href="{{ route('admin.shipments.edit', $shipment) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-800 shadow-sm transition hover:bg-slate-50">
                                Open
                            </a>
                        </div>
                    @empty
                        <div class="px-6 py-6 text-sm text-slate-600">No shipments yet.</div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-5">
                    <div class="text-sm font-semibold text-slate-900">Recent activity</div>
                </div>
                <div class="divide-y divide-slate-200">
                    @forelse ($recentEvents as $event)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="text-sm font-semibold text-slate-900">{{ $event->shipment?->tracking_id }}</div>
                                <div class="text-xs font-medium text-slate-500">{{ $event->occurred_at?->format('M j, H:i') }}</div>
                            </div>
                            <div class="mt-1 text-sm text-slate-700">{{ $event->title ?? ucfirst(str_replace('_', ' ', $event->status)) }}</div>
                            <div class="mt-1 text-xs text-slate-500">{{ $event->location?->label }}</div>
                        </div>
                    @empty
                        <div class="px-6 py-6 text-sm text-slate-600">No activity yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
