<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ShipmentController as AdminShipmentController;
use App\Http\Controllers\Admin\TrackingEventController as AdminTrackingEventController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/track', [TrackingController::class, 'index'])->name('track');
Route::post('/track', [TrackingController::class, 'lookup'])->name('track.lookup');
Route::get('/track/{trackingId}', [TrackingController::class, 'show'])->name('track.show');

Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking');
Route::post('/tracking', [TrackingController::class, 'lookup'])->name('tracking.lookup');
Route::get('/tracking/{trackingId}', [TrackingController::class, 'show'])->name('tracking.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/fashshipping-admin', function () {
    return redirect()->route('admin.login');
})->name('admin.secret');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

        Route::get('/shipments', [AdminShipmentController::class, 'index'])->name('shipments.index');
        Route::get('/shipments/create', [AdminShipmentController::class, 'create'])->name('shipments.create');
        Route::post('/shipments', [AdminShipmentController::class, 'store'])->name('shipments.store');
        Route::get('/shipments/{shipment}/edit', [AdminShipmentController::class, 'edit'])->name('shipments.edit');
        Route::put('/shipments/{shipment}', [AdminShipmentController::class, 'update'])->name('shipments.update');
        Route::delete('/shipments/{shipment}', [AdminShipmentController::class, 'destroy'])->name('shipments.destroy');

        Route::post('/shipments/{shipment}/events', [AdminTrackingEventController::class, 'store'])->name('shipments.events.store');
        Route::delete('/shipments/{shipment}/events/{event}', [AdminTrackingEventController::class, 'destroy'])->name('shipments.events.destroy');
    });
});
