<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvertStoreRequest;
use App\Http\Services\AdvertState;
use App\Models\Advert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        if($request->hasFile('images'))
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
        $response['phone_numer'] = $advert->phone_number;
        $response['step'] = 'first';
        $imagesUrls = [];
        foreach (json_decode($advert->images) as $key=>$image)
        {
            $imagesUrls[$key] = Storage::url($image);
        }
        $response['pictures_urls'] = $imagesUrls;
        return response()->json($response);
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
