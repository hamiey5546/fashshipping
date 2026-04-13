<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->decimal('parcel_value', 12, 2)->nullable()->after('parcel_description');
            $table->string('shipping_method', 20)->nullable()->after('parcel_value');
            $table->date('dispatch_date')->nullable()->after('shipping_method');
        });
    }

    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn(['parcel_value', 'shipping_method', 'dispatch_date']);
        });
    }
};
