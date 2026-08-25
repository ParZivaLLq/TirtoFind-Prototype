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
        Schema::create('lost_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_code')->unique();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('reporter_name');
            $table->string('reporter_phone');
            $table->string('reporter_id_type')->nullable(); // KTP, SIM, Paspor, dll.
            $table->string('reporter_id_number')->nullable();
            $table->string('item_name');
            $table->string('color')->nullable();
            $table->string('brand')->nullable();
            $table->string('location_lost');
            $table->dateTime('date_lost');
            $table->text('distinctive_features')->nullable();
            $table->string('image_path')->nullable();
            $table->string('status')->default('Menunggu Verifikasi'); // Menunggu Verifikasi, Terverifikasi, Selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lost_reports');
    }
};
