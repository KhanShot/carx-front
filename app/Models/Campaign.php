<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Campaign extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'bin', 'address', 'website', 'phone', 'telegram', 'min_year', 'telegram_user_id',
        'pledged', 'arrested', 'crashed', 'right_hand', 'in_kz', 'user_id', 'lead_point'
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
