<?php

namespace Database\Seeders;

use App\Models\Jamaah;
use App\Models\PaketUmrah;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ===== Admin account =====
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@smartumrah.test',
            'password' => bcrypt('password'),
            'phone' => '081200000000',
            'role' => 'admin',
        ]);

    }
}
