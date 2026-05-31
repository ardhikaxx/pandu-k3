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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('training_number')->unique();
            $table->string('title');
            $table->enum('type', ['induction', 'refresher', 'specialist', 'emergency_drill', 'regulatory', 'on_the_job']);
            $table->text('description');
            $table->string('provider');
            $table->string('trainer_name');
            $table->string('trainer_credential')->nullable();
            $table->foreignId('division_id')->nullable()->constrained()->onDelete('set null');
            $table->date('scheduled_date');
            $table->date('end_date');
            $table->string('location');
            $table->integer('max_participants');
            $table->decimal('duration_hours', 5, 2);
            $table->enum('status', ['planned', 'ongoing', 'completed', 'cancelled'])->default('planned');
            $table->string('materials_url')->nullable();
            $table->boolean('certificate_issued')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
