<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GangguanLog extends Model
{
    protected $table = 'gangguan_logs';

    protected $guarded = ['id'];

    public function gangguan()
    {
        return $this->belongsTo(Gangguan::class, 'gangguan_id');
    }
}