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
}
