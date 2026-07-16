<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'page',
        'user_agent',
        'visited_at',
    ];

    /**
     * Relasi ke user (jamaah) yang mengakses, bila sedang login.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
