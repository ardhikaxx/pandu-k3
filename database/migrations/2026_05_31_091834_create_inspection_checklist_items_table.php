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
        Schema::create('inspection_checklist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->onDelete('cascade');
            $table->string('category');
            $table->text('item_description');
            $table->string('standard_reference')->nullable();
            $table->enum('status', ['ok', 'not_ok', 'na', 'not_checked'])->default('not_checked');
            $table->text('notes')->nullable();
            $table->string('photo')->nullable();
            $table->enum('finding_severity', ['observation', 'minor', 'major', 'critical'])->nullable();
            $table->boolean('requires_capa')->default(false);
            $table->foreignId('capa_id')->nullable()->constrained('capa_actions')->onDelete('set null');
            $table->foreignId('checked_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('checked_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_checklist_items');
    }
};
