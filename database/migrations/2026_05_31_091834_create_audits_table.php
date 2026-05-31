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
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->string('audit_number')->unique();
            $table->string('title');
            $table->enum('audit_type', ['internal', 'external', 'surveillance', 'certification']);
            $table->foreignId('work_area_id')->constrained()->onDelete('cascade');
            $table->foreignId('division_id')->constrained()->onDelete('cascade');
            $table->foreignId('lead_auditor_id')->constrained('users')->onDelete('cascade');
            $table->json('team_members');
            $table->dateTime('scheduled_start');
            $table->dateTime('scheduled_end');
            $table->dateTime('actual_start')->nullable();
            $table->dateTime('actual_end')->nullable();
            $table->enum('status', ['planned', 'in_progress', 'completed', 'report_issued'])->default('planned');
            $table->text('scope');
            $table->text('criteria');
            $table->text('summary_findings')->nullable();
            $table->integer('total_findings')->default(0);
            $table->integer('major_findings')->default(0);
            $table->integer('minor_findings')->default(0);
            $table->integer('observations')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
