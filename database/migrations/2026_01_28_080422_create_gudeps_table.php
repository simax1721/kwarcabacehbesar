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
        Schema::create('gudeps', function (Blueprint $table) {
            $table->id();
            $table->string('npsn')->unique();
            $table->string('nogudeppa')->nullable();
            $table->string('nogudeppi')->nullable();
            $table->string('email')->nullable();
            $table->string('kepsek')->nullable();
            $table->string('name');
            $table->string('grade')->nullable();
            $table->string('status')->nullable();
            $table->string('accreditation')->nullable();
            $table->text('address')->nullable();
            $table->string('province_code')->nullable();
            $table->string('province_name')->nullable();
            $table->string('regency_code')->nullable();
            $table->string('regency_name')->nullable();
            $table->string('district_code')->nullable();
            $table->string('district_name')->nullable();
            $table->string('lang')->nullable();
            $table->string('long')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudeps');
    }
};
