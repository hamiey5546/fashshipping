<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Shipment;
use App\Models\TrackingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Shipment::query()->with(['origin', 'destination']);

        if ($request->filled('q')) {
            $q = trim($request->string('q'));
            $query->where('tracking_id', 'like', '%'.$q.'%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $shipments = $query->latest()->paginate(15)->withQueryString();

        return view('admin.shipments.index', [
            'shipments' => $shipments,
            'statuses' => $this->statusOptions(),
        ]);
    }

    public function create()
    {
        return view('admin.shipments.create', [
            'shipment' => new Shipment,
            'statuses' => $this->statusOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateShipment($request, isUpdate: false);

        $origin = $this->createLocation($data['origin']);
        $destination = $this->createLocation($data['destination']);
        $current = isset($data['current']) ? $this->createLocation($data['current']) : null;

        $shipment = Shipment::query()->create([
            ...$data['shipment'],
            'origin_location_id' => $origin->id,
            'destination_location_id' => $destination->id,
            'current_location_id' => $current?->id,
            'created_by' => Auth::id(),
        ]);

        TrackingEvent::query()->create([
            'shipment_id' => $shipment->id,
            'location_id' => $origin->id,
            'status' => $shipment->status,
            'title' => 'Shipment Created',
            'occurred_at' => now(),
            'sequence' => 0,
        ]);

        return redirect()->route('admin.shipments.edit', $shipment)->with('status', 'Shipment created.');
    }

    public function edit(Shipment $shipment)
    {
        $shipment->load(['origin', 'current', 'destination', 'events.location']);

        return view('admin.shipments.edit', [
            'shipment' => $shipment,
            'statuses' => $this->statusOptions(),
        ]);
    }

    public function update(Request $request, Shipment $shipment)
    {
        $data = $this->validateShipment($request, isUpdate: true);

        $origin = $this->createLocation($data['origin']);
        $destination = $this->createLocation($data['destination']);
        $current = isset($data['current']) ? $this->createLocation($data['current']) : null;

        $shipment->update([
            ...$data['shipment'],
            'origin_location_id' => $origin->id,
            'destination_location_id' => $destination->id,
            'current_location_id' => $current?->id,
        ]);

        return redirect()->route('admin.shipments.edit', $shipment)->with('status', 'Shipment updated.');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return redirect()->route('admin.shipments.index')->with('status', 'Shipment deleted.');
    }

    private function statusOptions(): array
    {
        return [
            Shipment::STATUS_PENDING => 'Pending',
            Shipment::STATUS_IN_TRANSIT => 'In Transit',
            Shipment::STATUS_OUT_FOR_DELIVERY => 'Out for Delivery',
            Shipment::STATUS_DELIVERED => 'Delivered',
            Shipment::STATUS_DELAYED => 'Delayed',
            Shipment::STATUS_ON_HOLD => 'On Hold',
        ];
    }

    private function validateShipment(Request $request, bool $isUpdate): array
    {
        $rules = [
            'tracking_id' => ['nullable', 'string', 'max:32'],
            'status' => ['required', 'in:'.implode(',', array_keys($this->statusOptions()))],

            'sender_name' => ['required', 'string', 'max:120'],
            'sender_email' => ['nullable', 'email', 'max:190'],
            'sender_phone' => ['nullable', 'string', 'max:50'],
            'sender_address' => ['nullable', 'string', 'max:190'],

            'receiver_name' => ['required', 'string', 'max:120'],
            'receiver_email' => ['nullable', 'email', 'max:190'],
            'receiver_phone' => ['nullable', 'string', 'max:50'],
            'receiver_address' => ['nullable', 'string', 'max:190'],

            'parcel_weight' => ['nullable', 'numeric', 'min:0'],
            'parcel_category' => ['nullable', 'string', 'max:120'],
            'parcel_description' => ['nullable', 'string', 'max:2000'],
            'parcel_value' => ['nullable', 'numeric', 'min:0'],

            'shipping_method' => ['nullable', 'in:'.implode(',', [
                Shipment::SHIPPING_METHOD_AIR,
                Shipment::SHIPPING_METHOD_SEA,
                Shipment::SHIPPING_METHOD_EXPRESS,
            ])],
            'dispatch_date' => ['nullable', 'date'],
            'estimated_delivery_date' => ['nullable', 'date'],

            'origin_label' => ['required', 'string', 'max:120'],
            'origin_latitude' => ['required', 'numeric', 'between:-90,90'],
            'origin_longitude' => ['required', 'numeric', 'between:-180,180'],

            'destination_label' => ['required', 'string', 'max:120'],
            'destination_latitude' => ['required', 'numeric', 'between:-90,90'],
            'destination_longitude' => ['required', 'numeric', 'between:-180,180'],

            'current_label' => ['nullable', 'string', 'max:120', 'required_with:current_latitude,current_longitude'],
            'current_latitude' => ['nullable', 'numeric', 'between:-90,90', 'required_with:current_label,current_longitude'],
            'current_longitude' => ['nullable', 'numeric', 'between:-180,180', 'required_with:current_label,current_latitude'],
        ];

        if ($isUpdate) {
            $rules['tracking_id'][] = 'sometimes';
        }

        $validated = $request->validate($rules);

        $shipment = [
            'tracking_id' => filled($validated['tracking_id'] ?? null) ? strtoupper(trim($validated['tracking_id'])) : null,
            'status' => $validated['status'],
            'sender_name' => $validated['sender_name'],
            'sender_email' => $validated['sender_email'] ?? null,
            'sender_phone' => $validated['sender_phone'] ?? null,
            'sender_address' => $validated['sender_address'] ?? null,
            'receiver_name' => $validated['receiver_name'],
            'receiver_email' => $validated['receiver_email'] ?? null,
            'receiver_phone' => $validated['receiver_phone'] ?? null,
            'receiver_address' => $validated['receiver_address'] ?? null,
            'parcel_weight' => $validated['parcel_weight'] ?? null,
            'parcel_category' => $validated['parcel_category'] ?? null,
            'parcel_description' => $validated['parcel_description'] ?? null,
            'parcel_value' => $validated['parcel_value'] ?? null,
            'shipping_method' => $validated['shipping_method'] ?? null,
            'dispatch_date' => $validated['dispatch_date'] ?? null,
            'estimated_delivery_date' => $validated['estimated_delivery_date'] ?? null,
        ];

        $origin = [
            'label' => $validated['origin_label'],
            'latitude' => $validated['origin_latitude'],
            'longitude' => $validated['origin_longitude'],
        ];

        $destination = [
            'label' => $validated['destination_label'],
            'latitude' => $validated['destination_latitude'],
            'longitude' => $validated['destination_longitude'],
        ];

        $current = null;

        if (filled($validated['current_label'] ?? null)) {
            $current = [
                'label' => $validated['current_label'],
                'latitude' => $validated['current_latitude'],
                'longitude' => $validated['current_longitude'],
            ];
        }

        return [
            'shipment' => array_filter($shipment, fn ($v) => $v !== null),
            'origin' => $origin,
            'destination' => $destination,
            'current' => $current,
        ];
    }

    private function createLocation(array $data): Location
    {
        return Location::query()->create([
            'label' => $data['label'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
        ]);
    }
}
