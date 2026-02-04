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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('vendor')->nullable()->constrained('vendors')->nullOnDelete();
            $table->string('asset_id')->unique();
            $table->string('asset_tag')->unique();
            $table->string('asset_name');
            $table->string('asset_category');
            $table->string('asset_type');
            $table->string('operational_status')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('department')->nullable();
            $table->string('location')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 15, 2)->nullable();
            $table->integer('useful_life_years')->nullable();
            $table->decimal('salvage_value', 15, 2)->nullable();
            $table->string('compliance_status')->nullable();
            $table->date('warranty_start')->nullable();
            $table->date('warranty_end')->nullable();
            $table->date('next_maintenance')->nullable();
            $table->string('status')->default('active');
            $table->text('documents')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
