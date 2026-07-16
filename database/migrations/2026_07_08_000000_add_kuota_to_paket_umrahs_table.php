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
        Schema::table('paket_umrahs', function (Blueprint $table) {
            // Kuota paket (jumlah kursi tersedia). NULL = tidak terbatas.
            $table->integer('kuota')->nullable()->after('durasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paket_umrahs', function (Blueprint $table) {
            $table->dropColumn('kuota');
        });
    }
};
