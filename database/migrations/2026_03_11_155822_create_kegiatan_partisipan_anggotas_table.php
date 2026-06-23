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
        Schema::create('kegiatan_partisipan_anggotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatans_id')->constrained()->onDelete('cascade');
            $table->foreignId('kegiatan_partisipans_id')->constrained()->onDelete('cascade');

            $table->boolean('is_pembina')->nullable();
            $table->boolean('is_pa')->nullable();
            $table->boolean('is_pi')->nullable();
            $table->string('name');
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_partisipan_anggotas');
    }
};
