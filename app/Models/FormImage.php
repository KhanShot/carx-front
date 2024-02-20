<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormImage extends Model
{
    use HasFactory;
    public $timestamps = false;

    public $fillable = [
        'form_id', 'url',
    ];
}
