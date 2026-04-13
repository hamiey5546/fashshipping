<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Shipment;
use App\Models\TrackingEvent;
use Illuminate\Http\Request;

class TrackingEventController extends Controller
{
    public function store(Request $request, Shipment $shipment)
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'max:60'],
            'title' => ['nullable', 'string', 'max:140'],
            'occurred_at' => ['required', 'date'],
            'sequence' => ['nullable', 'integer', 'min:0'],
            'location_label' => ['required', 'string', 'max:120'],
            'location_latitude' => ['required', 'numeric', 'between:-90,90'],
            'location_longitude' => ['required', 'numeric', 'between:-180,180'],
            'set_as_current' => ['nullable', 'boolean'],
        ]);

        $location = Location::query()->create([
            'label' => $data['location_label'],
            'latitude' => $data['location_latitude'],
            'longitude' => $data['location_longitude'],
        ]);

        $event = TrackingEvent::query()->create([
            'shipment_id' => $shipment->id,
            'location_id' => $location->id,
            'status' => $data['status'],
            'title' => $data['title'] ?? null,
            'occurred_at' => $data['occurred_at'],
            'sequence' => $data['sequence'] ?? 0,
        ]);

        if ($request->boolean('set_as_current', true)) {
            $shipment->update([
                'current_location_id' => $location->id,
                'status' => $event->status,
            ]);
        }

        return redirect()->route('admin.shipments.edit', $shipment)->with('status', 'Tracking update added.');
    }

    public function destroy(Shipment $shipment, TrackingEvent $event)
    {
        if ($event->shipment_id !== $shipment->id) {
            abort(404);
        }

        $event->delete();

        return redirect()->route('admin.shipments.edit', $shipment)->with('status', 'Tracking update removed.');
    }
}
