<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Shipment;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('pages.track.index');
    }

    public function lookup(Request $request)
    {
        $data = $request->validate([
            'tracking_id' => ['required', 'string'],
        ]);

        return redirect()->route('track.show', ['trackingId' => strtoupper(trim($data['tracking_id']))]);
    }

    public function show(string $trackingId)
    {
        $shipment = Shipment::query()
            ->where('tracking_id', strtoupper($trackingId))
            ->with(['origin', 'current', 'destination', 'events.location'])
            ->first();

        if (! $shipment) {
            return view('pages.track.index', [
                'notFoundTrackingId' => strtoupper($trackingId),
            ]);
        }

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

        return view('pages.track.show', [
            'shipment' => $shipment,
            'routePoints' => $routePoints,
            'mapboxToken' => config('services.mapbox.token') ?: Setting::getValue('mapbox_token'),
        ]);
    }
}
