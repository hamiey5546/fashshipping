<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracking_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments')->cascadeOnDelete();
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->string('status');
            $table->string('title')->nullable();
            $table->timestamp('occurred_at')->index();
            $table->unsignedInteger('sequence')->default(0);
            $table->timestamps();

            $table->index(['shipment_id', 'occurred_at', 'sequence']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracking_events');
    }
};
