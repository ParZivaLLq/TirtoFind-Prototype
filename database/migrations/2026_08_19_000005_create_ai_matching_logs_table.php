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
        Schema::create('ai_matching_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lost_report_id')->constrained('lost_reports')->onDelete('cascade');
            $table->foreignId('found_item_id')->constrained('found_items')->onDelete('cascade');
            $table->integer('score'); // Total confidence score (0-100)
            $table->text('reason')->nullable();
            $table->integer('color_match')->nullable();
            $table->integer('brand_match')->nullable();
            $table->integer('location_match')->nullable();
            $table->integer('time_match')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_matching_logs');
    }
};
