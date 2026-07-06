<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gangguan extends Model
{
    protected $fillable = [
        'id_laporan',
        'no_tiket',
        'ip_address',
        'gardu_induk',
        'waktu_kejadian',
        'status',
        'status_jaringan',
        'tahapan',
        'jenis_gangguan',
        'catatan_perbaikan',
        'foto_lokasi',
        'foto_petugas',
    ];

    public function logs()
    {
        return $this->hasMany(GangguanLog::class, 'gangguan_id')->orderBy('tanggal', 'asc');
    }
}