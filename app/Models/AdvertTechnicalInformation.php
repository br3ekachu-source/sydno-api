<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Http\Services\Consts;

class AdvertTechnicalInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'advert_id',
        'overall_length',
        'overall_width',
        'board_height',
        'draft_in_cargo',
        'material',
        'deadweight',
        'dock_weight',
        'full_displacement',
        'gross_tonnage',
        'num_engines',
        'num_additional_engines',
        'power',
        'maximum_speed',
        'cargo_tanks',
        'total_capacity_cargo_tanks',
        'second_bottom',
        'second_sides',
        'carrying',
        'deckhouses',
        'liquid_tanks',
        'total_capacity_liquid_tanks',
        'passangers_avialable',
        'num_passangers',
    ];

    public function advert(): BelongsTo
    {
        return $this->belongsTo(Advert::class);
    }

    public function getMaterialAttribute($value)
    {
        return Consts::getMaterials()[$value];
    }
}
