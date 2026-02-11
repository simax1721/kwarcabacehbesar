<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_gudep extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gudep_id',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    function user() {
        return $this->belongsTo(User::class);
    }

    function gudep() {
        return $this->belongsTo(Gudep::class);
    }
}
