<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvertStoreRequest;
use App\Http\Services\AdvertState;
use App\Http\Services\Files;
use App\Models\Advert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class AdvertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'email' => Auth::user()->email ,
            'step' => 'first',
            'phone' => Auth::user()->phone_number
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdvertStoreRequest $request)
    {
        $advert = new Advert();
        $advert->header = $request->post('header');
        $advert->user_id = Auth::user()->id;
        $advert->price = $request->post('price');
        $advert->description = $request->post('description');
        $advert->registration_number = $request->post('registration_number');
        $advert->phone_number = $request->post('phone_number');
        $advert->state = AdvertState::Draft;

        if(isset($request->images))
        {
            $images = $request->file('images');
            $imagesArray = [];
            foreach ($images as $key=>$image) {
                $path = $image->store('advert_images');
                $imagesArray[$key] = $path;
            }
            $advert->images = json_encode($imagesArray);
        }

        $advert->save();

        $response = [];
        $response['id'] = $advert->id;
        $response['header'] = $advert->header;
        $response['price'] = $advert->price;
        $response['user'] = $advert->user_id;
        $response['description'] = $advert->description;
        $response['registration_number'] = $advert->registration_number;
        $response['phone_number'] = $advert->phone_number;
        $response['step'] = 'first';
        $imagesUrls = [];
        if (isset($request->images))
        {
            foreach (json_decode($advert->images) as $key=>$image)
            {
                $imagesUrls[$key] = Files::getUrl($image);
            }
        }
        $response['pictures_urls'] = $imagesUrls;
        return response()->json($response);
    }

    public function getInfo(Request $request)
    {
        $activeCount = $request->user()->adverts->where('state', '=', AdvertState::Active)->count();
        $draftCount = $request->user()->adverts->where('state', '=', AdvertState::Draft)->count();
        $inactiveCount = $request->user()->adverts->where('state', '=', AdvertState::Inactive)->count();
        $moderationCount = $request->user()->adverts->where('state', '=', AdvertState::Moderation)->count();
        return response()->json([
            'active' => $activeCount ,
            'draft' => $draftCount,
            'inactive' => $inactiveCount,
            'moderation' => $moderationCount
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Advert $advert)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advert $advert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advert $advert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advert $advert)
    {
        //
    }
}
