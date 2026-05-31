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
        Schema::create('permit_to_works', function (Blueprint $table) {
            $table->id();
            $table->string('permit_number')->unique();
            $table->enum('work_type', ['hot_work', 'confined_space', 'working_at_height', 'electrical', 'excavation', 'chemical_handling', 'crane_lifting', 'other']);
            $table->string('title');
            $table->text('description');
            $table->foreignId('work_area_id')->constrained()->onDelete('cascade');
            $table->foreignId('division_id')->constrained()->onDelete('cascade');
            $table->foreignId('applicant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('supervisor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->json('required_ppe');
            $table->text('precautions');
            $table->json('emergency_contacts')->nullable();
            $table->text('hazards_identified')->nullable();
            $table->text('control_measures')->nullable();
            $table->enum('status', ['draft', 'submitted', 'approved', 'active', 'completed', 'cancelled', 'expired'])->default('draft');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permit_to_works');
    }
};
