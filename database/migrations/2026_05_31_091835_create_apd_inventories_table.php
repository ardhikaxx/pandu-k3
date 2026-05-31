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
        Schema::create('apd_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique();
            $table->string('name');
            $table->enum('category', ['helmet', 'vest', 'gloves', 'boots', 'goggles', 'mask', 'harness', 'earmuff', 'coverall', 'other']);
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('size')->nullable();
            $table->foreignId('work_area_id')->constrained()->onDelete('cascade');
            $table->foreignId('division_id')->constrained()->onDelete('cascade');
            $table->integer('total_quantity')->default(0);
            $table->integer('available_quantity')->default(0);
            $table->integer('damaged_quantity')->default(0);
            $table->string('standard_reference')->nullable();
            $table->integer('inspection_interval_days')->default(30);
            $table->date('last_inspected_at')->nullable();
            $table->date('next_inspection_date')->nullable();
            $table->enum('condition', ['good', 'fair', 'poor', 'damaged'])->default('good');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apd_inventories');
    }
};
