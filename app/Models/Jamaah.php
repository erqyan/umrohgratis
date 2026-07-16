<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jamaah extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'telepon',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'pasport',
        'tanggal_paspor',
        'alamat',
        'foto_ktp',
        'foto_paspor',
        'foto',
        'status_verifikasi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_paspor' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function pendaftaranTerakhir()
    {
        return $this->hasOne(Pendaftaran::class)->latestOfMany();
    }

    public function notifikasi()
    {
        return $this->hasMany(NotifikasiJamaah::class)->latest();
    }

    public function notifikasiBelumDibaca()
    {
        return $this->hasMany(NotifikasiJamaah::class)->where('dibaca', false)->latest();
    }

    public function getInisialAttribute(): string
    {
        return strtoupper(mb_substr(trim($this->nama), 0, 1));
    }

    /**
     * Jumlah dokumen yang sudah diunggah (KTP, Paspor, Foto).
     */
    public function getJumlahDokumenAttribute(): int
    {
        return collect(['foto_ktp', 'foto_paspor', 'foto'])
            ->filter(fn ($field) => ! empty($this->{$field}))
            ->count();
    }

    /**
     * Apakah semua dokumen wajib sudah lengkap?
     */
    public function getDokumenLengkapAttribute(): bool
    {
        return $this->jumlah_dokumen === 3;
    }
}
