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
        Schema::table('penduduks', function (Blueprint $table) {
            $table->string('no_kk', 16)->after('nik')->nullable()->index();
            $table->enum('shdk', [
                'Kepala Keluarga',
                'Suami',
                'Istri',
                'Anak',
                'Menantu',
                'Orang Tua',
                'Mertua',
                'Pembantu',
                'Famili Lain',
                'Lainnya',
            ])->after('no_kk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduks', function (Blueprint $table) {
            $table->dropColumn(['no_kk', 'shdk']);
        });
    }
};
