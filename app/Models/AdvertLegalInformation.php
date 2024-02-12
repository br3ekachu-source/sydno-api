<?php

namespace App\Models;

use App\Http\Services\Consts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvertLegalInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'advert_id',
        'name',
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
        'building_place',
        'port_address',
        'vessel_location',
        'imo_number',
        'technical_documentation'
    ];

    public function advert(): BelongsTo
    {
        return $this->belongsTo(Advert::class);
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

    public function getVesselStatusAttribute($value)
    {
        return Consts::getVesselStatuses()[$value];
    }

    public function getTypeAttribute($value)
    {
        return Consts::getVesselTypes()[$value];
    }

    public function getExploitationTypeAttribute($value)
    {
        return Consts::getExploitationType()[$value];
    }
}
