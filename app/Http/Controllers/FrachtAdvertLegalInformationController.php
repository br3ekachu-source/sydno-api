<?php

namespace App\Http\Controllers;

use App\Models\FrachtAdvertLegalInformation;
use Illuminate\Http\Request;
use App\Http\Requests\FrachtAdvertLegalInformationStoreRequest;

class FrachtAdvertLegalInformationController extends Controller
{
    public function store(FrachtAdvertLegalInformationStoreRequest $request)
    {
        $frachtAdvert = $request->user()->fracthAdverts->find($request->post('advert_id'));
        if ($frachtAdvert == null) {
            return response()->json(['message' => 'По указанному объявлению ничего не найдено'], 405);
        }
        if ($frachtAdvert->frachtAdvertLegalInformation != null) {
            return response()->json(['message' => 'По указанному объявлению уже существует второй шаг'], 405);
        }

        $data = $request->all();
        !isset($data['was_registered']) ?: $data['was_registered'] = true;
        $data['advert_id'] = $frachtAdvert->id;
        $frachtAdvertLegalInformation = FrachtAdvertLegalInformation::create($data);

        return $frachtAdvertLegalInformation;
    }

    public function update(Request $request, $id)
    {
        $frachtAdvertLegalInformation = FrachtAdvertLegalInformation::find($id);
        if ($frachtAdvertLegalInformation == null) {
            return response()->json(['message' => 'Юридическая информация с указанным айди не найдена!'], 409);
        }
        $data = $request->all();
        $frachtAdvertLegalInformation->forceFill($data);
        $frachtAdvertLegalInformation->save();
        return response()->json(['message' => 'Объявление обновлено успешно!'], 200); 
    }
}
