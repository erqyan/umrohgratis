<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketUmrah extends Model
{
    protected $fillable = [
        'nama',
        'tipe',
        'deskripsi',
        'harga',
        'durasi',
        'kuota',
        'hotel',
        'maskapai',
        'tanggal_berangkat',
        'lokasi_keberangkatan',
        'fasilitas',
        'itinerary',
        'image',
        'status',
    ];

    /**
     * Status pendaftaran yang mengisi kuota (bukan draft/batal).
     */
    public const STATUS_KUOTA = ['pending', 'aktif', 'selesai'];

    /**
     * Appends: ekspos accessor kuota ke array/JSON.
     */
    protected $appends = ['kuota_terpakai', 'sisa_kuota', 'kuota_penuh'];

    protected $casts = [
        'harga' => 'decimal:2',
        'fasilitas' => 'array',
        'itinerary' => 'array',
    ];

    /**
     * Pendaftaran yang mengisi kuota (pending/aktif/selesai).
     */
    public function pendaftaranKuota()
    {
        return $this->hasMany(Pendaftaran::class)->whereIn('status', self::STATUS_KUOTA);
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function getDurasiTextAttribute(): string
    {
        $malam = max($this->durasi - 1, 0);

        return "{$this->durasi} hari / {$malam} malam";
    }

    /**
     * Jumlah kursi terpakai. Mendukung withCount('pendaftaranKuota').
     */
    public function getKuotaTerpakaiAttribute(): int
    {
        // Jika di-load via withCount('pendaftaranKuota'), gunakan nilai itu.
        if (array_key_exists('pendaftaran_kuota_count', $this->attributes)) {
            return (int) $this->attributes['pendaftaran_kuota_count'];
        }

        return $this->pendaftaranKuota()->count();
    }

    /**
     * Sisa kuota. NULL bila kuota tidak terbatas.
     */
    public function getSisaKuotaAttribute(): ?int
    {
        if ($this->kuota === null) {
            return null;
        }

        return max($this->kuota - $this->kuota_terpakai, 0);
    }

    /**
     * Apakah kuota sudah penuh? Selalu false bila tidak terbatas.
     */
    public function getKuotaPenuhAttribute(): bool
    {
        return $this->kuota !== null && $this->sisa_kuota <= 0;
    }

    public function getTipeLabelAttribute(): string
    {
        return match ($this->tipe) {
            'vip' => 'VIP',
            'plus' => 'Plus',
            default => 'Reguler',
        };
    }
}
