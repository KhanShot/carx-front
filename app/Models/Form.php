<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'mark', 'model', 'year', 'mileage', 'capacity', 'engine_type','transmission_type',
        'drive_unit', 'color', 'arrested', 'pledged', 'in_kz', 'crashed', 'right_hand', 'vin', 'comment','verified', 'city'
    ];

    public function images()
    {
        return $this->hasMany(FormImage::class, 'form_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
