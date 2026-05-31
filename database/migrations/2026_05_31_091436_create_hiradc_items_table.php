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
        Schema::create('hiradc_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hiradc_id')->constrained()->onDelete('cascade');
            $table->string('activity');
            $table->text('hazard_description');
            $table->enum('hazard_type', ['physical', 'chemical', 'biological', 'ergonomic', 'psychosocial', 'mechanical', 'electrical', 'fire', 'environmental']);
            $table->text('potential_incident');
            // Risk Assessment Before Control
            $table->integer('severity_before');
            $table->integer('probability_before');
            $table->integer('risk_score_before');
            $table->enum('risk_level_before', ['very_low', 'low', 'medium', 'high', 'very_high']);
            // Control Measures
            $table->enum('control_hierarchy', ['elimination', 'substitution', 'engineering', 'administrative', 'ppe']);
            $table->text('control_measures');
            $table->string('pic_control');
            $table->date('target_date');
            // Risk Assessment After Control
            $table->integer('severity_after');
            $table->integer('probability_after');
            $table->integer('risk_score_after');
            $table->enum('risk_level_after', ['very_low', 'low', 'medium', 'high', 'very_high']);
            $table->boolean('residual_risk_acceptable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hiradc_items');
    }
};
