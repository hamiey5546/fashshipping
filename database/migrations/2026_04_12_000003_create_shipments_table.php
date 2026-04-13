<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id')->unique();
            $table->string('status')->index();

            $table->string('sender_name');
            $table->string('sender_email')->nullable();
            $table->string('sender_phone')->nullable();
            $table->string('sender_address')->nullable();

            $table->string('receiver_name');
            $table->string('receiver_email')->nullable();
            $table->string('receiver_phone')->nullable();
            $table->string('receiver_address')->nullable();

            $table->decimal('parcel_weight', 8, 2)->nullable();
            $table->string('parcel_category')->nullable();
            $table->text('parcel_description')->nullable();

            $table->date('estimated_delivery_date')->nullable();

            $table->foreignId('origin_location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('current_location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('destination_location_id')->nullable()->constrained('locations')->nullOnDelete();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
