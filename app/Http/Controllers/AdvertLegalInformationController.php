<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvertLegalInformationStoreRequest;
use App\Models\Advert;
use App\Models\AdvertLegalInformation;
use Illuminate\Http\Request;

class AdvertLegalInformationController extends Controller
{
    public function store(AdvertLegalInformationStoreRequest $request)
    {
        $advert = $request->user()->adverts->find($request->post('advert_id'));
        if ($advert == null) {
            return response()->json(['message' => 'По указанному объявлению ничего не найдено'], 405);
        }
        if ($advert->advertLegalInformation != null) {
            return response()->json(['message' => 'По указанному объявлению уже существует второй шаг'], 405);
        }

        $data = $request->all();
        isset($data['was_registered']) ?: $data['was_registered'] = true;
        $data['advert_id'] = $advert->id;
        $advertLegalInformation = AdvertLegalInformation::create($data);

        return $advertLegalInformation;
    }

    public function update(Request $request, $id)
    {
        $advertLegalInformation = AdvertLegalInformation::find($id);
        if ($advertLegalInformation == null) {
            return response()->json(['message' => 'Юридическая информация с указанным айди не найдена!'], 409);
        }
        $data = $request->all();
        $advertLegalInformation->forceFill($data);
        $advertLegalInformation->save();
        return $advertLegalInformation;
    }
}
