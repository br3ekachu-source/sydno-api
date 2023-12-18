<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FrachtAdvertLegalInformation extends Model
{
    protected $fillable = [
        'advert_id',
        'flag',
        'exploitation_type',
        'class_formula',
        'wave_limit',
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
        'imo_number',
        'ice_strengthening'
    ];

    public function frachtAdvert(): BelongsTo
    {
        return $this->belongsTo(FrachtAdvert::class);
    }

    public function getPortAddressAttribute($value)
    {
        return json_decode($value);
    }

    public function setPortAddressAttribute($value)
    {
        $this->attributes['port_address'] = json_encode($value);
    }

    public function getVesselLocationAttribute($value)
    {
        return json_decode($value);
    }

    public function setVesselLocationAttribute($value)
    {
        $this->attributes['vessel_location'] = json_encode($value);
    }
}
