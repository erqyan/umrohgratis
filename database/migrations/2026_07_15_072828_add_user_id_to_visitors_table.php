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
        Schema::table('visitors', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            $table->dropUnique(['ip_address', 'visited_at']);
            $table->unique(['user_id', 'ip_address', 'visited_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'ip_address', 'visited_at']);
            $table->unique(['ip_address', 'visited_at']);
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
