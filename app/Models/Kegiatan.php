<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getThumbnailAttribute($value)
    {
        if (!$value) return null;

        $base = rtrim(env('APP_URL'). '/uploads/thumbnails/', '/');
        return $base . '/' . ltrim($value, '/');
    }

    function partisipans() {
        return $this->hasMany(Kegiatan_partisipan::class, 'kegiatans_id');
    }
    
}
