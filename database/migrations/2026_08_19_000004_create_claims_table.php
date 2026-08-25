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
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->string('claim_code')->unique();
            $table->foreignId('found_item_id')->constrained('found_items')->onDelete('cascade');
            $table->foreignId('lost_report_id')->nullable()->constrained('lost_reports')->onDelete('set null');
            $table->string('claimant_name');
            $table->string('claimant_phone');
            $table->string('claimant_id_number');
            $table->string('relationship'); // Pemilik, Keluarga, Teman, dll.
            $table->text('reason');
            $table->text('distinctive_features')->nullable();
            $table->string('supporting_document_path')->nullable(); // KTP / Bukti Kepemilikan
            $table->string('status')->default('Menunggu Verifikasi'); // Menunggu Verifikasi, Disetujui, Ditolak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
