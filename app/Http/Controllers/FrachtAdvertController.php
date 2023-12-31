<?php

namespace App\Http\Controllers;

use App\Http\Requests\FrachtAdvertUpdateRequest;
use App\Http\Services\AdvertState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\FrachtAdvertStoreRequest;
use App\Models\FrachtAdvert;

class FrachtAdvertController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(FrachtAdvertStoreRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['state'] = AdvertState::Draft;
        $frachtAdvert = new FrachtAdvert();
        $frachtAdvert->forceFill($data);
        $frachtAdvert->save();
        return $frachtAdvert;
    }

    public function getInfo(Request $request)
    {
        $activeCount = $request->user()->frachtAdverts->where('state', '=', AdvertState::Active)->count();
        $draftCount = $request->user()->frachtAdverts->where('state', '=', AdvertState::Draft)->count();
        $inactiveCount = $request->user()->frachtAdverts->where('state', '=', AdvertState::Inactive)->count();
        $moderationCount = $request->user()->frachtAdverts->where('state', '=', AdvertState::Moderation)->count();
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
        
        $frachtAdverts = FrachtAdvert::where('state', '=', $thisState)
            ->where('user_id', '=', $request->user()->id)
            ->with('FrachtAdvertLegalInformation', 'FrachtAdvertTechnicalInformation')
            ->orderBy('created_at', 'desc')->paginate(10);
        
        return $frachtAdverts;
    }

    public function getAdverts(Request $request) {
        $state = AdvertState::Active;
        
        $frachtAdverts = FrachtAdvert::whereHas('FrachtAdvertLegalInformation', function (Builder $query) use($request) {
            $request->get('flag')                    == null ?: $query->where('flag', '=', $request->get('flag'));
            $request->get('class_formula')           == null ?: $query->where('class_formula', 'ilike', '%'.$request->get('class_formula').'%');
            $request->get('ice_power')               == null ?: $query->where('ice_strengthening', '=', $request->get('ice_power'));
            $request->get('type')                    == null ?: $query->where('type', '=', $request->get('type'));
            $request->get('purpose')                 == null ?: $query->where('purpose', 'ilike', '%'.$request->get('purpose').'%');
            $request->get('was_registered')          == null ?: $query->where('was_registered', '=', $request->get('was_registered'));
            $request->get('register_valid_until')    == null ?: $query->where('register_valid_until', '>=', $request->get('register_valid_until'));
            $request->get('vessel_status')           == null ?: $query->where('vessel_status', '=', $request->get('vessel_status'));
            $request->get('project_number')          == null ?: $query->where('project_number', '=', $request->get('project_number'));
            $request->get('building_number')         == null ?: $query->where('building_number', 'ilike', '%'.$request->get('building_number').'%');
            $request->get('building_year')           == null ?: $query->where('building_year', '=', $request->get('building_year'));
            $request->get('building_country')        == null ?: $query->where('building_country', '=', $request->get('building_country'));
            $request->get('port_adress_country')     == null ?: $query->whereJsonContains('port_address->country', $request->get('port_adress_country'));
            $request->get('port_adress_city')        == null ?: $query->whereJsonContains('port_address->city', $request->get('port_adress_city'));
            $request->get('vessel_location_country') == null ?: $query->whereJsonContains('vessel_location->country', $request->get('vessel_location_country'));
            $request->get('vessel_location_city')    == null ?: $query->whereJsonContains('vessel_location->city', $request->get('vessel_location_city'));
            $request->get('imo_number')              == null ?: $query->where('imo_number', 'ilike', '%'.$request->get('imo_number').'%');
        });

        $frachtAdverts->whereHas('FrachtAdvertTechnicalInformation', function (Builder $query) use($request) {
            $request->get('min_overall_length')     == null ?: $query->where('overall_length', '>=', $request->get('min_overall_length'));
            $request->get('max_overall_length')     == null ?: $query->where('overall_length', '<=', $request->get('max_overall_length'));
            $request->get('min_overall_width')      == null ?: $query->where('overall_width', '>=', $request->get('min_overall_width'));
            $request->get('max_overall_width')      == null ?: $query->where('overall_width', '<=', $request->get('max_overall_width'));
            $request->get('min_board_height')       == null ?: $query->where('overall_width', '>=', $request->get('min_board_height'));
            $request->get('max_board_height')       == null ?: $query->where('overall_width', '<=', $request->get('max_board_height'));
            $request->get('min_maximum_freeboard')  == null ?: $query->where('maximum_freeboard', '>=', $request->get('min_maximum_freeboard'));
            $request->get('max_maximum_freeboard')  == null ?: $query->where('maximum_freeboard', '<=', $request->get('max_maximum_freeboard'));
            $request->get('material')               == null ?: $query->where('material', '=', $request->get('material'));
            $request->get('min_deadweight')         == null ?: $query->where('deadweight', '>=', $request->get('min_deadweight'));
            $request->get('max_deadweight')         == null ?: $query->where('deadweight', '<=', $request->get('max_deadweight'));
            $request->get('min_dock_weight')        == null ?: $query->where('deadweight', '>=', $request->get('min_dock_weight'));
            $request->get('max_dock_weight')        == null ?: $query->where('dock_weight', '<=', $request->get('max_dock_weight'));
            $request->get('min_full_displacement')  == null ?: $query->where('full_displacement', '>=', $request->get('min_full_displacement'));
            $request->get('max_full_displacement')  == null ?: $query->where('full_displacement', '<=', $request->get('max_full_displacement'));
            $request->get('min_gross_tonnage')      == null ?: $query->where('gross_tonnage', '>=', $request->get('min_gross_tonnage'));
            $request->get('max_gross_tonnage')      == null ?: $query->where('gross_tonnage', '<=', $request->get('max_gross_tonnage'));
            $request->get('num_engines')            == null ?: $query->where('num_engines', '=', $request->get('num_engines'));
            $request->get('min_power')              == null ?: $query->where('power', '>=', $request->get('min_power'));
            $request->get('max_power')              == null ?: $query->where('power', '<=', $request->get('max_power'));
            $request->get('min_maximum_speed_in_ballast')   == null ?: $query->where('maximum_speed_in_ballast', '>=', $request->get('min_maximum_speed_in_ballast'));
            $request->get('max_maximum_speed_in_ballast')   == null ?: $query->where('maximum_speed_in_ballast', '<=', $request->get('max_maximum_speed_in_ballast'));
            $request->get('min_maximum_speed_when_loaded')  == null ?: $query->where('maximum_speed_when_loaded', '>=', $request->get('min_maximum_speed_when_loaded'));
            $request->get('max_maximum_speed_when_loaded')  == null ?: $query->where('maximum_speed_when_loaded', '<=', $request->get('max_maximum_speed_when_loaded'));
            $request->get('cargo_tanks')            == null ?: $query->where('cargo_tanks', '=', $request->get('cargo_tanks'));
            $request->get('min_total_capacity_cargo_tanks') == null ?: $query->where('total_capacity_cargo_tanks', '>=', $request->get('min_total_capacity_cargo_tanks'));
            $request->get('max_total_capacity_cargo_tanks') == null ?: $query->where('total_capacity_cargo_tanks', '<=', $request->get('max_total_capacity_cargo_tanks'));
            $request->get('filling_tanks')          == null ?: $query->where('liquid_tanks', '=', $request->get('filling_tanks'));
            $request->get('min_total_capacity_filling_tanks')  == null ?: $query->where('total_capacity_liquid_tanks', '>=', $request->get('min_total_capacity_filling_tanks'));
            $request->get('max_total_capacity_filling_tanks')  == null ?: $query->where('total_capacity_liquid_tanks', '<=', $request->get('max_total_capacity_filling_tanks'));
            $request->get('seccond_bottom')         == null ?: $query->where('seccond_bottom', '=', $request->get('seccond_bottom'));
            $request->get('second_sides')           == null ?: $query->where('second_sides', '=', $request->get('second_sides'));
            $request->get('min_carrying')           == null ?: $query->where('carrying', '>=', $request->get('min_carrying'));
            $request->get('max_carrying')           == null ?: $query->where('carrying', '<=', $request->get('max_carrying'));
            $request->get('superstructures')        == null ?: $query->where('superstructures', '=', $request->get('superstructures'));
            $request->get('deckhouses')             == null ?: $query->where('deckhouses', '=', $request->get('deckhouses'));
            $request->get('min_passangers_avialable') == null ?: $query->where('num_passangers', '>=', $request->get('min_passangers_avialable'));
            $request->get('max_passangers_avialable') == null ?: $query->where('num_passangers', '<=', $request->get('max_passangers_avialable'));
        });

        $frachtAdverts = $frachtAdverts->with('FrachtAdvertLegalInformation', 'FrachtAdvertTechnicalInformation')->orderBy('created_at', 'desc')->paginate(10);

        return $frachtAdverts;
    }


    public function show($id)
    {
        $frachtAdvert = FrachtAdvert::with('FrachtAdvertLegalInformation')->find($id);
        return $frachtAdvert;
        if ($frachtAdvert == null) {
            return response()->json(['message' => 'Объявление с указанным айди не найдено!'], 409);
        }
        return $frachtAdvert;
    }

    public function delete($id)
    {
        $frachtAdvert = FrachtAdvert::find($id);
        if ($frachtAdvert == null) {
            return response()->json(['message' => 'Объявление с указанным айди не найдено!'], 409);
        }
        if ($frachtAdvert->state == AdvertState::Deleted) {
            return response()->json(['message' => 'Объявление уже было удалено!'], 409);
        }
        $frachtAdvert->state = AdvertState::Deleted;
        if (!$frachtAdvert->save()) {
            return response()->json(['message' => 'Ошибка при сохранении'], 409);
        }
        return response()->json(['message' => 'Объявление удалено!'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FrachtAdvertUpdateRequest $request, $id)
    {
        $frachtAdvert = FrachtAdvert::find($id);
        if ($frachtAdvert == null) {
            return response()->json(['message' => 'Объявление с указанным айди не найдено!'], 409);
        }
        $data = $request->all();
        $frachtAdvert->forceFill($data);
        $frachtAdvert->save();
        return response()->json(['message' => 'Объявление обновлено успешно!'], 200); 
    }
}
