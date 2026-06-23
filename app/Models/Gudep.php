<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gudep extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function getDistrictNameAttribute()
    {
        return $this->hasOne(Ranting::class, 'code', 'district_code')->first()?->name;
    }

    function ranting()
    {
        return $this->belongsTo(Ranting::class, 'district_code', 'code');
    }

    function kegiatan_partisipan() {
        return $this->hasMany(Kegiatan_partisipan::class, 'gudeps_id');
    }

    function user() {
        return $this->belongsToMany(User::class, 'user_gudeps', 'gudep_id', 'user_id')->withPivot('id');
    }
}
