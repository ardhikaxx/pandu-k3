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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->string('inspection_number')->unique();
            $table->string('title');
            $table->enum('inspection_type', ['daily', 'weekly', 'monthly', 'special', 'audit_follow_up']);
            $table->foreignId('work_area_id')->constrained()->onDelete('cascade');
            $table->foreignId('division_id')->constrained()->onDelete('cascade');
            $table->foreignId('inspector_id')->constrained('users')->onDelete('cascade');
            $table->date('scheduled_date');
            $table->date('actual_date')->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'overdue', 'cancelled'])->default('scheduled');
            $table->decimal('completion_percentage', 5, 2)->default(0);
            $table->text('overall_notes')->nullable();
            $table->json('photos')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
