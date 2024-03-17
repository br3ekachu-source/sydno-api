<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Services\AdvertState;
use App\Http\Services\Consts;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Http\Services\Files;

class Advert extends Model
{
    use HasFactory;
    protected $casts = [
        'state' => AdvertState::class,
    ];

    protected $appends = [
        'favorites_count',
        'views',
        'viewed'
    ];

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
                $path = $image->store('advert_images');
                $imagesArray[$key] = $path;
            }
            $this->attributes['images'] = json_encode($imagesArray);
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function favoritesUsers()
    {
        return $this->belongsToMany(Advert::class, 'favorites', 'advert_id', 'user_id')->withTimeStamps();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->belongsToMany(Advert::class, 'favorites', 'advert_id', 'user_id')->count();
    }

    public function getViewedAttribute()
    {
        $user = auth()->user();
        if ($user == null) {
            return false;
        }
        return $this->belongsToMany(Advert::class, 'advert_views', 'advert_id', 'user_id')->where('advert_views.user_id', '=', $user->id)->exists();
    }

    public function getViewsAttribute()
    {
        return $this->belongsToMany(Advert::class, 'advert_views', 'advert_id', 'user_id')->count();
    }

    public function viewsUsers()
    {
        return $this->belongsToMany(Advert::class, 'advert_views', 'advert_id', 'user_id')->withTimeStamps();
    }

    public function advertLegalInformation(): HasOne
    {
        return $this->hasOne(AdvertLegalInformation::class);
    }

    public function advertTechnicalInformation(): HasOne
    {
        return $this->hasOne(AdvertTechnicalInformation::class);
    }

    public function getFrachtTypeAttribute($value)
    {
        return Consts::getFrachtTypes()[$value];
    }

    public function getFrachtPriceTypeAttribute($value)
    {
        return Consts::getFrachtPriceTypes()[$value];
    }
}
