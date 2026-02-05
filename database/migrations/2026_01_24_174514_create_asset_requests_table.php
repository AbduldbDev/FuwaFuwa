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
        Schema::create('asset_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->unique();
            $table->string('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('requested_by');
            $table->string('department');
            $table->string('asset_category');
            $table->string('asset_type');
            $table->integer('quantity');
            $table->string('model')->nullable();
            $table->string('request_reason');
            $table->text('detailed_reason')->nullable();
            // $table->decimal('cost', 10, 2)->nullable();
            // $table->enum('priority', ['low', 'medium', 'high',  'emergency'])->default('low');
            $table->string('status')->default('For Review');
            $table->text('remarks')->nullable();
            $table->string('is_approved')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_requests');
    }
};
