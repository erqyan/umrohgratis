<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Supabase Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi koneksi ke Supabase project.
    | Nilai diambil dari environment variables (.env).
    |
    */

    'url' => env('SUPABASE_URL'),

    'publishable_key' => env('SUPABASE_PUBLISHABLE_KEY'),

    'secret_key' => env('SUPABASE_SECRET_KEY'),

    'jwks_url' => env('SUPABASE_JWKS_URL'),

];
