<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asset_settings', function (Blueprint $table) {
            $table->id();
            $table->string('asset_tag_prefix', 20);
            $table->string('depreciation_method');
            $table->boolean('auto_generate_asset_tag')->default(true);
            $table->boolean('warranty_expiry_alerts')->default(true);
            $table->boolean('maintenance_reminders')->default(true);
            $table->boolean('expiration_of_license')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_settings');
    }
};
