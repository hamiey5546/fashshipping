<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;

class ShipmentController extends Controller
{
    public function show(string $trackingId)
    {
        $shipment = Shipment::query()
            ->where('tracking_id', strtoupper($trackingId))
            ->with(['origin', 'current', 'destination', 'events.location'])
            ->first();

        if (! $shipment) {
            return response()->json(['message' => 'Shipment not found.'], 404);
        }

        $events = $shipment->events->map(function ($event) {
            return [
                'status' => $event->status,
                'title' => $event->title,
                'occurred_at' => $event->occurred_at?->toIso8601String(),
                'sequence' => $event->sequence,
                'location' => $event->location ? [
                    'label' => $event->location->label,
                    'latitude' => $event->location->latitude,
                    'longitude' => $event->location->longitude,
                ] : null,
            ];
        })->values();

        $routePoints = collect([
            $shipment->origin,
            ...$shipment->events->pluck('location')->filter()->all(),
            $shipment->destination,
        ])
            ->filter()
            ->unique(fn ($loc) => $loc->latitude.','.$loc->longitude)
            ->values()
            ->map(fn ($loc) => [
                'label' => $loc->label,
                'latitude' => $loc->latitude,
                'longitude' => $loc->longitude,
            ])
            ->all();

        return response()->json([
            'tracking_id' => $shipment->tracking_id,
            'status' => $shipment->status,
            'sender' => [
                'name' => $shipment->sender_name,
                'email' => $shipment->sender_email,
                'phone' => $shipment->sender_phone,
                'address' => $shipment->sender_address,
            ],
            'receiver' => [
                'name' => $shipment->receiver_name,
                'email' => $shipment->receiver_email,
                'phone' => $shipment->receiver_phone,
                'address' => $shipment->receiver_address,
            ],
            'parcel' => [
                'weight' => $shipment->parcel_weight,
                'category' => $shipment->parcel_category,
                'description' => $shipment->parcel_description,
                'value' => $shipment->parcel_value,
            ],
            'shipping' => [
                'method' => $shipment->shipping_method,
                'dispatch_date' => $shipment->dispatch_date?->toDateString(),
                'estimated_delivery_date' => $shipment->estimated_delivery_date?->toDateString(),
                'origin' => $shipment->origin?->label,
                'destination' => $shipment->destination?->label,
            ],
            'estimated_delivery_date' => $shipment->estimated_delivery_date?->toDateString(),
            'locations' => [
                'origin' => $shipment->origin ? [
                    'label' => $shipment->origin->label,
                    'latitude' => $shipment->origin->latitude,
                    'longitude' => $shipment->origin->longitude,
                ] : null,
                'current' => $shipment->current ? [
                    'label' => $shipment->current->label,
                    'latitude' => $shipment->current->latitude,
                    'longitude' => $shipment->current->longitude,
                ] : null,
                'destination' => $shipment->destination ? [
                    'label' => $shipment->destination->label,
                    'latitude' => $shipment->destination->latitude,
                    'longitude' => $shipment->destination->longitude,
                ] : null,
            ],
            'events' => $events,
            'route_points' => $routePoints,
        ]);
    }
}
