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
        Schema::create('incident_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique();
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->string('victim_name')->nullable();
            $table->string('victim_employee_id')->nullable();
            $table->foreignId('work_area_id')->constrained()->onDelete('cascade');
            $table->foreignId('division_id')->constrained()->onDelete('cascade');
            $table->enum('incident_type', ['accident', 'near_miss', 'first_aid', 'medical_treatment', 'lost_time', 'fatality']);
            $table->date('incident_date');
            $table->time('incident_time');
            $table->string('title', 200);
            $table->text('description');
            $table->text('immediate_cause')->nullable();
            $table->text('root_cause')->nullable();
            $table->text('injuries_description')->nullable();
            $table->string('body_part_affected')->nullable();
            $table->text('property_damage_description')->nullable();
            $table->decimal('estimated_loss', 15, 2)->nullable();
            $table->json('witnesses')->nullable();
            $table->json('photos');
            $table->enum('status', ['draft', 'submitted', 'under_investigation', 'action_required', 'closed'])->default('draft');
            $table->enum('severity_classification', ['minor', 'moderate', 'serious', 'major', 'catastrophic']);
            $table->foreignId('investigated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('investigation_report')->nullable();
            $table->integer('lost_time_days')->default(0);
            $table->text('corrective_actions')->nullable();
            $table->text('preventive_actions')->nullable();
            $table->unsignedBigInteger('capa_id')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_reports');
    }
};
