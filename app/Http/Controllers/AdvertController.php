<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvertStoreRequest;
use App\Http\Requests\AdvertUpdateRequest;
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

        if(isset($request->images)) {
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
        $images = [];
        if (isset($request->images)) {
            foreach (json_decode($advert->images) as $key=>$image) {
                $images[$key] = Files::getUrl($image);
            }
        }
        $response['images'] = $images;
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

    public function getMyAdverts(Request $request, $state)
    {
        $thisState = null;
        switch ($state){
            case 'active':
                $thisState = AdvertState::Active;
                break;
            case ('draft'):
                $thisState = AdvertState::Draft;
                break;
            case ('inactive'):
                $thisState = AdvertState::Inactive;
                break;
            case ('moderation'):
                $thisState = AdvertState::Moderation;
                break;   
        }

        if ($thisState == null)
            return response()->json([], 404);
        $adverts = $request->user()->adverts->where('state', '=', $thisState);
        if ($adverts->isEmpty() || $adverts == null) {
            return response()->json([
                'message' => 'Нет записей'
            ]);
        }

        $adverts = $adverts->toQuery()->with('AdvertLegalInformation', 'AdvertTechnicalInformation')->orderBy('created_at', 'desc')->paginate(10);

        foreach ($adverts as $advert) {
            $images = [];
            if ($advert->images == null){
                continue;
            }
            foreach (json_decode($advert->images) as $key=>$image) {
                $images[$key] = Files::getUrl($image);
            }
            $advert->images = $images;              
        }
        return $adverts;
    }


    public function show($id)
    {
        $advert = Advert::with('AdvertLegalInformation')->find($id);
        return $advert;
        if ($advert == null) {
            return response()->json(['message' => 'Объявление с указанным айди не найдено!'], 409);
        }
        $images = [];
        if ($advert->images != null){
            foreach (json_decode($advert->images) as $key=>$image) {
                $images[$key] = Files::getUrl($image);
            }
            $advert->images = $images;
        }
        return $advert;
    }

    public function delete($id)
    {
        $advert = Advert::find($id);
        if ($advert == null) {
            return response()->json(['message' => 'Объявление с указанным айди не найдено!'], 409);
        }
        if ($advert->state == AdvertState::Deleted) {
            return response()->json(['message' => 'Объявление уже было удалено!'], 409);
        }
        $advert->state = AdvertState::Deleted;
        if (!$advert->save()) {
            return response()->json(['message' => 'Ошибка при сохранении'], 409);
        }
        return response()->json(['message' => 'Объявление удалено!'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdvertUpdateRequest $request, $id)
    {
        $advert = Advert::find($id);
        if ($advert == null) {
            return response()->json(['message' => 'Объявление с указанным айди не найдено!'], 409);
        }
        $data = $request->all();

        if(isset($request->images)) {
            $images = $request->file('images');
            $imagesArray = [];
            foreach ($images as $key=>$image) {
                $path = $image->store('advert_images');
                $imagesArray[$key] = $path;
            }
            $data['images'] = json_encode($imagesArray);
        }
        $advert->forceFill($data);
        $advert->save();
        return response()->json(['message' => 'Объявление обновлено успешно!'], 200); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advert $advert)
    {
        //
    }
}
