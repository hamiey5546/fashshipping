@extends('admin.layouts.app')

@section('title', 'Shipments — Admin')

@section('content')
    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-5">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="text-sm font-semibold text-slate-900">Shipments</div>
                    <div class="mt-1 text-xs text-slate-500">Search by tracking ID and filter by status.</div>
                </div>
                <a href="{{ route('admin.shipments.create') }}" class="inline-flex items-center justify-center rounded-xl bg-[#0A2540] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:brightness-110">
                    Create Shipment
                </a>
            </div>
        </div>

        <div class="px-6 py-5">
            <form method="GET" action="{{ route('admin.shipments.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label class="text-xs font-semibold text-slate-600" for="q">Tracking ID</label>
                    <input id="q" name="q" value="{{ request('q') }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" placeholder="FSH-" />
                </div>
                <div class="sm:w-56">
                    <label class="text-xs font-semibold text-slate-600" for="status">Status</label>
                    <select id="status" name="status" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100">
                        <option value="">All</option>
                        @foreach ($statuses as $key => $label)
                            <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-110">
                    Apply
                </button>
            </form>
        </div>

        <div class="overflow-x-auto border-t border-slate-200">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-slate-600">Tracking</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-slate-600">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-slate-600">Origin</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-slate-600">Destination</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold tracking-wide text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($shipments as $shipment)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-slate-900">{{ $shipment->tracking_id }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $shipment->receiver_name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ ucfirst(str_replace('_', ' ', $shipment->status)) }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $shipment->origin?->label }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $shipment->destination?->label }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.shipments.edit', $shipment) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-800 shadow-sm transition hover:bg-slate-50">Edit</a>
                                    <form method="POST" action="{{ route('admin.shipments.destroy', $shipment) }}" onsubmit="return confirm('Delete this shipment?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 shadow-sm transition hover:bg-rose-100">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-600">No shipments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-5">
            {{ $shipments->links() }}
        </div>
    </div>
@endsection
