<?php

use App\Http\Controllers\Api\ShipmentController;
use Illuminate\Support\Facades\Route;

Route::get('/shipments/{trackingId}', [ShipmentController::class, 'show']);
