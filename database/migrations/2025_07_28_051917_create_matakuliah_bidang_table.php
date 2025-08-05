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
        Schema::create('matakuliah_bidang', function (Blueprint $table) {
            $table->id();
            $table->string('matakuliah');
            $table->enum('bidang', ['AI', 'Sistem Cerdas', 'Jaringan']);
            $table->double('bobot')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matakuliah_bidang');
    }
};