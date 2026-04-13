@extends('admin.layouts.app')

@section('title', 'Edit '.$shipment->tracking_id.' — Admin')

@section('content')
    <div class="mb-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="text-xs font-semibold text-slate-500">Tracking ID</div>
                <div class="mt-1 text-xl font-semibold tracking-tight text-slate-900">{{ $shipment->tracking_id }}</div>
                <div class="mt-2 text-sm text-slate-600">Status: <span class="font-semibold text-slate-900">{{ ucfirst(str_replace('_', ' ', $shipment->status)) }}</span></div>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                <a href="{{ route('track.show', $shipment->tracking_id) }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 shadow-sm transition hover:bg-slate-50">
                    View on user site
                </a>
                <form method="POST" action="{{ route('admin.shipments.destroy', $shipment) }}" onsubmit="return confirm('Delete this shipment?')">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm font-semibold text-rose-700 shadow-sm transition hover:bg-rose-100">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.shipments.update', $shipment) }}" class="space-y-6">
        @csrf
        @method('PUT')

        @include('admin.shipments._form', ['shipment' => $shipment, 'statuses' => $statuses])

        <div class="flex justify-end">
            <button class="rounded-xl bg-[#0A2540] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-110">
                Save Changes
            </button>
        </div>
    </form>

    <div class="mt-10 grid gap-6 lg:grid-cols-2">
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-5">
                <div class="text-sm font-semibold text-slate-900">Tracking updates</div>
                <div class="mt-1 text-xs text-slate-500">These events power the user timeline and map route.</div>
            </div>
            <div class="divide-y divide-slate-200">
                @forelse ($shipment->events as $event)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="text-sm font-semibold text-slate-900">{{ $event->title ?? ucfirst(str_replace('_', ' ', $event->status)) }}</div>
                            <div class="text-xs font-medium text-slate-500">{{ $event->occurred_at?->format('M j, Y • H:i') }}</div>
                        </div>
                        <div class="mt-1 text-sm text-slate-600">{{ $event->location?->label }}</div>
                        <div class="mt-3 flex justify-end">
                            <form method="POST" action="{{ route('admin.shipments.events.destroy', [$shipment, $event]) }}" onsubmit="return confirm('Remove this update?')">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-800 shadow-sm transition hover:bg-slate-50">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-6 text-sm text-slate-600">No tracking events yet.</div>
                @endforelse
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="text-sm font-semibold text-slate-900">Add checkpoint</div>
            <div class="mt-1 text-xs text-slate-500">Creates a new event and optionally sets it as the current location.</div>

            <form method="POST" action="{{ route('admin.shipments.events.store', $shipment) }}" class="mt-6 space-y-4">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-700" for="event_status">Status</label>
                        <input id="event_status" name="status" value="{{ old('status', 'in_transit') }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                        @error('status')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700" for="event_occurred_at">Timestamp</label>
                        <input id="event_occurred_at" name="occurred_at" type="datetime-local" value="{{ old('occurred_at', now()->format('Y-m-d\\TH:i')) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                        @error('occurred_at')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700" for="event_title">Title (optional)</label>
                    <input id="event_title" name="title" value="{{ old('title') }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" placeholder="Arrived at Hub" />
                    @error('title')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="text-xs font-semibold text-slate-700">Location</div>
                    <div class="mt-4 grid gap-4 sm:grid-cols-3">
                        <div class="sm:col-span-3">
                            <label class="text-xs font-semibold text-slate-600" for="location_label">Label</label>
                            <input id="location_label" name="location_label" value="{{ old('location_label') }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" placeholder="Dubai, AE" required />
                            @error('location_label')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-600" for="location_latitude">Lat</label>
                            <input id="location_latitude" name="location_latitude" type="number" step="0.0000001" value="{{ old('location_latitude') }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                            @error('location_latitude')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-600" for="location_longitude">Lng</label>
                            <input id="location_longitude" name="location_longitude" type="number" step="0.0000001" value="{{ old('location_longitude') }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                            @error('location_longitude')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                        </div>
                        <div class="sm:col-span-3">
                            <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                                <input type="checkbox" name="set_as_current" value="1" checked class="size-4 rounded border-slate-300 text-[#0A2540]" />
                                Set as shipment current location + status
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-110">
                        Add Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
