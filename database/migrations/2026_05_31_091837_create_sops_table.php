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
        Schema::create('sops', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')->unique();
            $table->string('title');
            $table->enum('category', ['work_procedure', 'emergency_response', 'chemical_handling', 'equipment_operation', 'housekeeping', 'fire_safety', 'first_aid', 'evacuation', 'other']);
            $table->longText('content')->nullable();
            $table->foreignId('work_area_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('division_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('version')->default('1.0');
            $table->enum('status', ['draft', 'active', 'under_review', 'obsolete'])->default('draft');
            $table->date('effective_date')->nullable();
            $table->date('review_date')->nullable();
            $table->string('document_path')->nullable();
            $table->integer('view_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sops');
    }
};
