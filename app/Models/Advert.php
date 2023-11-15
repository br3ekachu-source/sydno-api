<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Services\AdvertState;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Advert extends Model
{
    use HasFactory;
    protected $casts = [
        'state' => AdvertState::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
