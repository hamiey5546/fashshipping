<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\TrackingEvent;

class DashboardController extends Controller
{
    public function index()
    {
        $totalShipments = Shipment::query()->count();
        $activeShipments = Shipment::query()->whereIn('status', [
            Shipment::STATUS_PENDING,
            Shipment::STATUS_IN_TRANSIT,
            Shipment::STATUS_OUT_FOR_DELIVERY,
            Shipment::STATUS_ON_HOLD,
        ])->count();
        $deliveredShipments = Shipment::query()->where('status', Shipment::STATUS_DELIVERED)->count();

        $recentShipments = Shipment::query()->latest()->limit(6)->get();
        $recentEvents = TrackingEvent::query()->with(['shipment', 'location'])->latest('occurred_at')->limit(10)->get();

        return view('admin.dashboard', [
            'totalShipments' => $totalShipments,
            'activeShipments' => $activeShipments,
            'deliveredShipments' => $deliveredShipments,
            'recentShipments' => $recentShipments,
            'recentEvents' => $recentEvents,
        ]);
    }
}
