<?php

namespace App\Http\Controllers;

use App\Models\FrachtAdvertTechnicalInformation;
use App\Http\Requests\FrachtAdvertTechnicalInformationStoreRequest;
use Illuminate\Http\Request;
use App\Http\Services\AdvertState;

class FrachtAdvertTechnicalInformationController extends Controller
{
    public function store(FrachtAdvertTechnicalInformationStoreRequest $request)
    {
        $frachtAdvert = $request->user()->frachtAdverts->find($request->post('advert_id'));

        if ($frachtAdvert == null) {
            return response()->json(['message' => 'По указанному объявлению ничего не найдено'], 409);
        }
        if ($frachtAdvert->frachtAdvertLegalInformation == null) {
            return response()->json(['message' => 'По указанному объявлению не найден второй шаг'], 409);
        }
        if ($frachtAdvert->frachtAdvertLegalInformation != null) {
            return response()->json(['message' => 'По указанному объявлению уже существует третий шаг'], 409);
        }
        
        $data = $request->all();
        $data['advert_id'] = $frachtAdvert->id;
        $farachtAdvertTechnicalInformation = FrachtAdvertTechnicalInformation::create($data);
        $frachtAdvert->state = AdvertState::Moderation;
        $frachtAdvert->save();
        return $farachtAdvertTechnicalInformation;
    }

    public function update(Request $request, $id)
    {
        $farachtAdvertTechnicalInformation = FrachtAdvertTechnicalInformation::find($id);
        if ($farachtAdvertTechnicalInformation == null) {
            return response()->json(['message' => 'Техническая информация с указанным айди не найдена!'], 409);
        }
        $data = $request->all();
        $farachtAdvertTechnicalInformation->forceFill($data);
        $farachtAdvertTechnicalInformation->save();
        return response()->json(['message' => 'Объявление обновлено успешно!'], 200); 
    }
}
