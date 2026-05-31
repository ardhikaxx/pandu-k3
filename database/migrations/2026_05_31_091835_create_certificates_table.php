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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('certificate_type', ['k3_umum', 'k3_ahli', 'operator_forklift', 'operator_crane', 'welder', 'first_aid', 'fire_fighting', 'scaffolding', 'confined_space', 'other']);
            $table->string('certificate_number')->unique();
            $table->string('issuing_body');
            $table->date('issued_date');
            $table->date('expiry_date');
            $table->enum('status', ['active', 'expiring_soon', 'expired'])->default('active');
            $table->string('document_path')->nullable();
            $table->timestamp('reminder_sent_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
