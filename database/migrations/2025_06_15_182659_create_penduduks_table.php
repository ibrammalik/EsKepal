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
        Schema::create('penduduks', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('nama');
            $table->text('alamat');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir')->nullable();
            $table->foreignId('rt_id')->constrained();
            $table->foreignId('rw_id')->constrained();
            $table->foreignId('agama_id')->nullable()->constrained();
            $table->enum('status_kependudukan', ['Tetap', 'Kontrak', 'Pindah', 'Meninggal']);
            $table->foreignId('pekerjaan_id')->nullable()->constrained();
            $table->foreignId('status_perkawinan_id')->nullable()->constrained();
            $table->foreignId('status_kependudukan_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};
