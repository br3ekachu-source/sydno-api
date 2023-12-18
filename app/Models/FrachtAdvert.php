<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Services\AdvertState;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Http\Services\Consts;
use App\Http\Services\Files;

class FrachtAdvert extends Model
{
    use HasFactory;
    protected $casts = [
        'state' => AdvertState::class,
    ];

    public function getCoinTypeAttribute($value)
    {
        $types = Consts::getCoinTypes();
        return isset($types[$value]) ? $types[$value] : $types[0];
    }

    public function getImagesAttribute($value)
    {
        $images = [];
        if (isset($value)) {
            foreach (json_decode($value) as $key=>$image) {
                $images[$key] = Files::getUrl($image);
            }
        }
        return $images;
    }

    public function setImagesAttribute($value)
    {
        if($value != null){
            $imagesArray = [];
            foreach ($value as $key=>$image) {
                $path = $image->store('fracht_advert_images');
                $imagesArray[$key] = $path;
            }
            $this->attributes['images'] = json_encode($imagesArray);
        }
    }

    public function getFrachtPriceTypeAttribute($value)
    {
        $types = Consts::getFrachtPriceTypes();
        return isset($types[$value]) ? $types[$value] : $types[0];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function frachtAdvertLegalInformation(): HasOne
    {
        return $this->hasOne(FrachtAdvertLegalInformation::class);
    }

    public function frachtAdvertTechnicalInformation(): HasOne
    {
        return $this->hasOne(FracthAdvertTechnicalInformation::class);
    }
}
