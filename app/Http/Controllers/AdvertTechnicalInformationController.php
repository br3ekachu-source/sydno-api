<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvertTechnicalInformationStoreRequest;
use App\Http\Services\AdvertState;
use App\Models\AdvertTechnicalInformation;
use Illuminate\Http\Request;

class AdvertTechnicalInformationController extends Controller
{
    public function store(AdvertTechnicalInformationStoreRequest $request)
    {
        $advert = $request->user()->adverts->find($request->post('advert_id'));

        if ($advert == null) {
            return response()->json(['message' => 'По указанному объявлению ничего не найдено'], 409);
        }
        if ($advert->advertLegalInformation == null) {
            return response()->json(['message' => 'По указанному объявлению не найден второй шаг'], 409);
        }
        if ($advert->advertTechnicalInformation != null) {
            return response()->json(['message' => 'По указанному объявлению уже существует третий шаг'], 409);
        }

        $data = $request->all();
        $data['advert_id'] = $advert->id;
        $advertTechnicalInformation = AdvertTechnicalInformation::create($data);
        $advert->state = AdvertState::Moderation;
        $advert->save();
        return $advertTechnicalInformation;
    }

    public function update(Request $request, $id)
    {
        $advertTechnicalInformation = AdvertTechnicalInformation::find($id);
        if ($advertTechnicalInformation == null) {
            return response()->json(['message' => 'Техническая информация с указанным айди не найдена!'], 409);
        }
        $data = $request->all();
        $advertTechnicalInformation->forceFill($data);
        $advertTechnicalInformation->save();
        return $advertTechnicalInformation;
    }
}
