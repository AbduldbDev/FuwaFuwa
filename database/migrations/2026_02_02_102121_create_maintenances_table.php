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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('maintenance_id')->unique();
            $table->enum('maintenance_type', ['Corrective', 'Preventive', 'Inspection']);
            $table->foreignId('reported_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('description')->nullable();
            $table->text('documents')->nullable();
            $table->string('asset_tag')->nullable();
            $table->string('asset_name')->nullable();
            $table->date('last_maintenance_date')->nullable();
            $table->enum('priority', ['Low', 'Medium', 'High', 'Emergency']);
            $table->date('start_date')->nullable();
            $table->string('frequency')->nullable();
            $table->string('technician')->nullable();
            $table->string('post_description')->nullable();
            $table->string('post_replacements')->nullable();
            $table->string('technician_notes')->nullable();
            $table->string('status')->default("Pending");
            $table->dateTime('completed_at')->nullable();
            $table->text('post_attachments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
