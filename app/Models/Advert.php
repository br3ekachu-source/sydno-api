<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Services\AdvertState;

class Advert extends Model
{
    use HasFactory;
    protected $casts = [
        'state' => AdvertState::class,
    ];
}
