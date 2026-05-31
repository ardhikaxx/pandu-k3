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
        Schema::create('capa_actions', function (Blueprint $table) {
            $table->id();
            $table->string('capa_number')->unique();
            $table->enum('source_type', ['hazard_report', 'incident', 'inspection', 'audit']);
            $table->unsignedBigInteger('source_id');
            $table->string('title');
            $table->text('description');
            $table->enum('action_type', ['corrective', 'preventive', 'improvement']);
            $table->enum('priority', ['low', 'medium', 'high', 'critical']);
            $table->foreignId('assigned_to')->constrained('users')->onDelete('cascade');
            $table->foreignId('assigned_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('division_id')->constrained()->onDelete('cascade');
            $table->date('due_date');
            $table->enum('status', ['open', 'in_progress', 'pending_verification', 'closed', 'overdue'])->default('open');
            $table->text('progress_notes')->nullable();
            $table->json('completion_evidence')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->integer('effectiveness_rating')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capa_actions');
    }
};
