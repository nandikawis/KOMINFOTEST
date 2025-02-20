<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'nik',
        'nama',
        'no_hp',
        'email',
        'alamat',
        'judul',
        'deskripsi',
        'bukti_file',
        'status',
        'alasan_penolakan',
        'is_closed',
        'token'
    ];

    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class);
    }
}
