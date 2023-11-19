<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvertLegalInformationStoreRequest;
use App\Models\Advert;
use App\Models\AdvertLegalInformation;
use Illuminate\Http\Request;

class AdvertLegalInformationController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */   
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
        $advertLegalInformation = AdvertLegalInformation::create($data);
        return $advertLegalInformation;
    }

    /**
     * Display the specified resource.
     */
    public function show(AdvertLegalInformation $advertLegalInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdvertLegalInformation $advertLegalInformation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdvertLegalInformation $advertLegalInformation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdvertLegalInformation $advertLegalInformation)
    {
        //
    }
}
