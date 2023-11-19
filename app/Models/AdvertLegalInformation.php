<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvertLegalInformation extends Model
{
    use HasFactory;  
 
    protected $fillable = [
        'advert_id',
        'flag',
        'exploitation_type',
        'class_formula_left',
        'class_formula_right',
        'type',
        'purpose',
        'was_registered',
        'register_valid_until',
        'vessel_status',
        'project_number',
        'building_number',
        'building_year',
        'building_country',
        'port_address',
        'vessel_location',
        'imo_number'
    ];

    public function advert(): BelongsTo
    {
        return $this->belongsTo(Advert::class);
    }
}
