<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GangguanLog extends Model
{
    protected $table = 'gangguan_logs';

    protected $fillable = [
        'gangguan_id',
        'tanggal',
        'tahapan',
        'deskripsi',
    ];

    public function gangguan()
    {
        return $this->belongsTo(Gangguan::class, 'gangguan_id');
    }
}