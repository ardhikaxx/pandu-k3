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
        Schema::create('hazard_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique();
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('work_area_id')->constrained()->onDelete('cascade');
            $table->foreignId('division_id')->constrained()->onDelete('cascade');
            $table->enum('hazard_type', ['unsafe_condition', 'unsafe_act', 'near_miss']);
            $table->enum('category', ['electrical', 'mechanical', 'chemical', 'fire', 'ergonomic', 'biological', 'other']);
            $table->string('title', 200);
            $table->text('description');
            $table->string('location_detail', 200);
            $table->string('coordinates')->nullable();
            $table->enum('severity', ['low', 'medium', 'high', 'critical']);
            $table->json('photos');
            $table->enum('status', ['open', 'in_review', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->enum('priority', ['normal', 'urgent', 'emergency'])->default('normal');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->integer('response_time_minutes')->nullable();
            $table->text('supervisor_notes')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->unsignedBigInteger('capa_id')->nullable(); // Will add constraint after capa_actions table is created
            $table->timestamp('reported_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hazard_reports');
    }
};
