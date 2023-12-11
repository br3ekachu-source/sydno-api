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
        $data['advert_id'] = $advert->id;
        $data['port_address'] = json_encode($data['port_address']);
        $data['vessel_location'] = json_encode($data['vessel_location']);
        $advertLegalInformation = AdvertLegalInformation::create($data);
        return $advertLegalInformation;
    }

    public function update(Request $request, $id)
    {
        //return json_encode($request->post());
        $advertLegalInformation = AdvertLegalInformation::find($id);
        if ($advertLegalInformation == null) {
            return response()->json(['message' => 'Юридическая информация с указанным айди не найдена!'], 409);
        }
        $data = $request->all();
        $data['port_address'] = json_encode($data['port_address']);
        $data['vessel_location'] = json_encode($data['vessel_location']);
        $advertLegalInformation->forceFill($data);
        $advertLegalInformation->save();
        return response()->json(['message' => 'Объявление обновлено успешно!'], 200); 
    }
}
