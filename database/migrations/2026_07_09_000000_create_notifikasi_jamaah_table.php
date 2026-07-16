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
        Schema::create('notifikasi_jamaah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jamaah_id')->constrained()->cascadeOnDelete();
            $table->string('tipe'); // penolakan_pembayaran, penolakan_verifikasi
            $table->string('judul');
            $table->text('pesan')->nullable(); // alasan dari admin
            $table->string('terkait_type')->nullable(); // model terkait, mis. App\Models\Pembayaran
            $table->unsignedBigInteger('terkait_id')->nullable(); // id model terkait
            $table->boolean('dibaca')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi_jamaah');
    }
};
