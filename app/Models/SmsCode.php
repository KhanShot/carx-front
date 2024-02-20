<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone', 'code', 'status', 'verified', 'user_id',
    ];
}
