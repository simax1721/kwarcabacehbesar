<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan_partisipan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kegiatans_id',
        'gudeps_id',
        'file_pendaftaran'
    ];

    function kegiatan() {
        return $this->belongsTo(Kegiatan::class, 'kegiatans_id');
    }

    function gudep() {
        return $this->belongsTo(Gudep::class, 'gudeps_id');
    }

    
}
