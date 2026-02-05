<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranting extends Model
{
    use HasFactory;

    protected $keyType = 'code';
    public $incrementing = false;
    protected $guarded = [];

    function gudeps()
    {
        return $this->hasMany(Gudep::class, 'district_code', 'code');
    }

}
