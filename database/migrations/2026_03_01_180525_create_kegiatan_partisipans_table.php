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
        Schema::create('kegiatan_partisipans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatans_id')->constrained()->onDelete('cascade');
            $table->foreignId('gudeps_id')->constrained()->onDelete('cascade');
            $table->string('file_pendaftaran')->nullable();
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_partisipans');
    }
};
