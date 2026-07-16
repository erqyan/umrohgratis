<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifikasiJamaah extends Model
{
    protected $table = 'notifikasi_jamaah';

    protected $fillable = [
        'jamaah_id',
        'tipe',
        'judul',
        'pesan',
        'terkait_type',
        'terkait_id',
        'dibaca',
    ];

    protected $casts = [
        'dibaca' => 'boolean',
    ];

    public const TIPE_PENOLAKAN_PEMBAYARAN = 'penolakan_pembayaran';
    public const TIPE_PENOLAKAN_VERIFIKASI = 'penolakan_verifikasi';

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class);
    }

    public function getTipeLabelAttribute(): string
    {
        return match ($this->tipe) {
            self::TIPE_PENOLAKAN_PEMBAYARAN => 'Penolakan Pembayaran',
            self::TIPE_PENOLAKAN_VERIFIKASI => 'Penolakan Verifikasi',
            default => ucfirst(str_replace('_', ' ', $this->tipe)),
        };
    }

    public function getTipeWarnaAttribute(): string
    {
        return match ($this->tipe) {
            self::TIPE_PENOLAKAN_PEMBAYARAN,
            self::TIPE_PENOLAKAN_VERIFIKASI => '#d4483c',
            default => '#b45309',
        };
    }
}
