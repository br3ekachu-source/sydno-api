<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvertStoreRequest;
use App\Http\Requests\AdvertUpdateRequest;
use App\Http\Services\AdvertState;
use App\Http\Services\AdvertType;
use App\Models\Advert;
use App\Models\AdvertView;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class AdvertController extends Controller
{
    /**
     * Создание новой записи объявления
     */
    public function store(AdvertStoreRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['state'] = AdvertState::Draft;
        $advert = new Advert();
        $advert->forceFill($data);
        $advert->save();
        return $advert;
    }

    /**
     * Получение количества всех объявлений пользователя
     */
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
     * Получить все объявления текущего пользователя по состоянию
     */
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

        $adverts = Advert::where('state', '=', $thisState)
            ->where('user_id', '=', $request->user()->id)
            ->with('AdvertLegalInformation', 'AdvertTechnicalInformation')
            ->orderBy('created_at', 'desc')->paginate(12);
        return $adverts;
    }

    /**
     * Получить активные объявления пользователя по пользователю
     */
    public function getUserAdverts($userId)
    {
        $adverts = Advert::where('state', '=', AdvertState::Active)
            ->where('user_id', '=', $userId)
            ->with('AdvertLegalInformation', 'AdvertTechnicalInformation')
            ->orderBy('created_at', 'desc')->paginate(12);
        return $adverts;
    }

    /**
     * Получить объявления пользователя, кроме текущего
     */
    public function getOtherUserAdverts(Request $request)
    {
        $userId = $request->user_id;
        $currentAdvertId = $request->current_advert;
        $adverts = Advert::where('state', '=', AdvertState::Active)
            ->where('user_id', '=', $userId)
            ->where('id', '<>', $currentAdvertId)
            ->with('AdvertLegalInformation', 'AdvertTechnicalInformation')
            ->orderBy('created_at', 'desc')->paginate(4);
        return $adverts;
    }

    /**
     * Все объявления о продаже, с фильтром
     */
    public function getAdverts(Request $request) {
        $adverts = Advert::where(function (Builder $query) use($request) {
            $query->where('state', '=', AdvertState::Active);
            $request->get('advert_type')           == null ?: $query->where('advert_type', '=', $request->get('advert_type'));
            $request->get('min_price')           == null ?: $query->where('price', '>=', $request->get('min_price'));
            $request->get('max_price')           == null ?: $query->where('price', '<=', $request->get('max_price'));
        });

        $adverts = $adverts->whereHas('AdvertLegalInformation', function (Builder $query) use($request) {
            $request->get('flag')                    == null ?: $query->where('flag', '=', $request->get('flag'));
            $request->get('class_formula')           == null ?: $query->where('class_formula', 'ilike', '%'.$request->get('class_formula').'%');
            $request->get('name')           == null ?: $query->where('name', 'ilike', '%'.$request->get('name').'%');
            $request->get('type')                    == null ?: $query->where('type', '=', $request->get('type'));
            $request->get('purpose')                 == null ?: $query->where('purpose', 'ilike', '%'.$request->get('purpose').'%');
            $request->get('was_registered')          == null ?: $query->where('was_registered', '=', $request->get('was_registered'));
            $request->get('register_valid_until')    == null ?: $query->whereYear('register_valid_until', '>=', $request->get('register_valid_until'));
            $request->get('vessel_status')           == null ?: $query->where('vessel_status', '=', $request->get('vessel_status'));
            $request->get('project_number')          == null ?: $query->where('project_number', '=', $request->get('project_number'));
            $request->get('exploitation_type')       == null ?: $query->where('exploitation_type', '=', $request->get('exploitation_type'));
            $request->get('building_number')         == null ?: $query->where('building_number', 'ilike', '%'.$request->get('building_number').'%');
            $request->get('min_building_year')           == null ?: $query->where('building_year', '>=', $request->get('min_building_year'));
            $request->get('max_building_year')           == null ?: $query->where('building_year', '<=', $request->get('max_building_year'));
            $request->get('building_country')        == null ?: $query->where('building_country', '=', $request->get('building_country'));
            $request->get('port_adress_country')     == null ?: $query->whereJsonContains('port_address->country', $request->get('port_adress_country'));
            $request->get('port_adress_city')        == null ?: $query->whereJsonContains('port_address->city', $request->get('port_adress_city'));
            $request->get('vessel_location_city')    == null ?: $query->whereJsonContains('vessel_location->city', $request->get('vessel_location_city'));
            $request->get('imo_number')              == null ?: $query->where('imo_number', 'ilike', '%'.$request->get('imo_number').'%');
            $request->get('technical_documentation') == null ?: $query->where('technical_documentation', '=', $request->get('technical_documentation'));
        });

        $adverts->whereHas('AdvertTechnicalInformation', function (Builder $query) use($request) {
            $request->get('min_overall_length')     == null ?: $query->where('overall_length', '>=', $request->get('min_overall_length'));
            $request->get('max_overall_length')     == null ?: $query->where('overall_length', '<=', $request->get('max_overall_length'));
            $request->get('min_overall_width')      == null ?: $query->where('overall_width', '>=', $request->get('min_overall_width'));
            $request->get('max_overall_width')      == null ?: $query->where('overall_width', '<=', $request->get('max_overall_width'));
            $request->get('min_board_height')       == null ?: $query->where('board_height', '>=', $request->get('min_board_height'));
            $request->get('max_board_height')       == null ?: $query->where('board_height', '<=', $request->get('max_board_height'));
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
            $request->get('min_num_engines')      == null ?: $query->where('num_engines', '>=', $request->get('min_num_engines'));
            $request->get('max_num_engines')      == null ?: $query->where('num_engines', '<=', $request->get('max_num_engines'));
            $request->get('min_num_additional_engines')      == null ?: $query->where('num_additional_engines', '>=', $request->get('min_num_additional_engines'));
            $request->get('max_num_additional_engines')      == null ?: $query->where('num_additional_engines', '<=', $request->get('max_num_additional_engines'));
            $request->get('num_engines')            == null ?: $query->where('num_engines', '=', $request->get('num_engines'));
            $request->get('min_power')              == null ?: $query->where('power', '>=', $request->get('min_power'));
            $request->get('max_power')              == null ?: $query->where('power', '<=', $request->get('max_power'));
            $request->get('min_maximum_speed')   == null ?: $query->where('maximum_speed', '>=', $request->get('min_maximum_speed'));
            $request->get('max_maximum_speed')   == null ?: $query->where('maximum_speed', '<=', $request->get('max_maximum_speed'));
            $request->get('cargo_tanks')            == null ?: $query->where('cargo_tanks', '=', $request->get('cargo_tanks'));
            $request->get('min_total_capacity_cargo_tanks') == null ?: $query->where('total_capacity_cargo_tanks', '>=', $request->get('min_total_capacity_cargo_tanks'));
            $request->get('max_total_capacity_cargo_tanks') == null ?: $query->where('total_capacity_cargo_tanks', '<=', $request->get('max_total_capacity_cargo_tanks'));
            $request->get('filling_tanks')          == null ?: $query->where('liquid_tanks', '=', $request->get('filling_tanks'));
            $request->get('min_total_capacity_filling_tanks')  == null ?: $query->where('total_capacity_liquid_tanks', '>=', $request->get('min_total_capacity_filling_tanks'));
            $request->get('max_total_capacity_filling_tanks')  == null ?: $query->where('total_capacity_liquid_tanks', '<=', $request->get('max_total_capacity_filling_tanks'));
            $request->get('second_bottom')         == null ?: $query->where('second_bottom', '=', $request->get('second_bottom'));
            $request->get('second_sides')           == null ?: $query->where('second_sides', '=', $request->get('second_sides'));
            $request->get('min_carrying')           == null ?: $query->where('carrying', '>=', $request->get('min_carrying'));
            $request->get('max_carrying')           == null ?: $query->where('carrying', '<=', $request->get('max_carrying'));
            $request->get('superstructures')        == null ?: $query->where('superstructures', '=', $request->get('superstructures'));
            $request->get('min_passangers_avialable') == null ?: $query->where('num_passangers', '>=', $request->get('min_passangers_avialable'));
            $request->get('max_passangers_avialable') == null ?: $query->where('num_passangers', '<=', $request->get('max_passangers_avialable'));
        });

        $orderBy = 'created_at';
        $sort = 'desc';

        if ($request->get('sort') != null)
        {
            switch ($request->get('sort')) {
                case 'price_asc':
                    $orderBy = 'price';
                    $sort = 'asc';
                    break;
                case 'price_desc':
                    $orderBy = 'price';
                    $sort = 'desc';
                    break;
                case 'date':
                    $orderBy = 'created_at';
                    $sort = 'desc';
                    break;
                case 'views':
                    $orderBy = 'views';
                    $sort = 'desc';
                    break;
                default:
                    $orderBy = 'created_at';
                    $sort = 'desc';
                    break;
            }
        }
        $adverts = $adverts->with('AdvertLegalInformation', 'AdvertTechnicalInformation', 'user:id,name,avatar', 'user.adverts')->orderBy($orderBy, $sort)->paginate(12);

        foreach ($adverts as $advert) {
            $advert->user['adverts_count'] = $advert->user->adverts->count();
            unset($advert->user->adverts);
        }

        if ($request->user() != null){
            $myFavorites = Favorite::where('user_id', '=', $request->user()->id)->select('advert_id')->get();
            foreach ($adverts as $advert) {
                $advert['in_favorites'] = $myFavorites->contains('advert_id', $advert->id) ? true : false;
            }
        }
        else {
            foreach ($adverts as $advert) {
                $advert['in_favorites'] = false;
            }
        }


        return $adverts;
    }

    /**
     * Получить объявление по айди
     */
    public function show(Request $request, $id)
    {
        $advert = Advert::with('AdvertLegalInformation', 'AdvertTechnicalInformation', 'user:id,name,avatar,email', 'user.adverts')->find($id);
        if ($advert == null) {
            return response()->json(['message' => 'Объявление с указанным айди не найдено!'], 409);
        }
        $advert->user['adverts_count'] = $advert->user->adverts->count();
        unset($advert->user->adverts);
        if ($request->user() != null) {
            $advert['in_favorites'] = Favorite::where('user_id', '=', $request->user()->id)->where('advert_id', '=', $advert->id)->first() != null;
        } else {
            $advert['in_favorites'] = false;
        }
        if ($request->user() != null && $advert->user->id != $request->user()->id && !$request->user()->advertViews()->where('advert_id', $id)->exists()) {
            $request->user()->advertViews()->attach($id);
        }
        return $advert;
    }

    /**
     * Получить метадату по айди
     */
    public function metadata($id)
    {
        $advert = Advert::select('header', 'description')->find($id);
        if ($advert == null) {
            return response()->json(['message' => 'Объявление с указанным айди не найдено!'], 409);
        }
        return $advert;
    }

    /**
     * Получить объявление по айди для редактирования
     */
    public function showForEdit(Request $request, $id)
    {
        $advert = Advert::with('AdvertLegalInformation', 'AdvertTechnicalInformation')->find($id);
        if ($advert->user->id != $request->user()->id) {
            return response()->json(['message' => 'Нет прав'], 409);
        }
        if ($advert == null) {
            return response()->json(['message' => 'Объявление с указанным айди не найдено!'], 409);
        }

        $response = $advert->toArray();

        $advert->AdvertLegalInformation == null ?: $response['advert']['fracht_price_type'] = $advert->AdvertLegalInformation->getRawOriginal('fracht_price_type');
        $advert->AdvertLegalInformation == null ?: $response['advert']['fracht_type'] = $advert->AdvertLegalInformation->getRawOriginal('fracht_type');
        $advert->AdvertLegalInformation == null ?: $response['advert_legal_information']['exploitation_type'] = $advert->AdvertLegalInformation->getRawOriginal('exploitation_type');
        $advert->AdvertLegalInformation == null ?: $response['advert_legal_information']['type'] = $advert->AdvertLegalInformation->getRawOriginal('type');
        $advert->AdvertLegalInformation == null ?: $response['advert_legal_information']['vessel_status'] = $advert->AdvertLegalInformation->getRawOriginal('vessel_status');
        $advert->AdvertLegalInformation == null ?: $response['advert_technical_information']['material'] = $advert->AdvertLegalInformation->getRawOriginal('material');

        return $response;
    }

    /**
     * Перевести объявление в удаленное
     */
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
     * Обновить первый шаг объявления
     */
    public function update(AdvertUpdateRequest $request, $id) {
        $advert = Advert::find($id);
        if ($advert == null) {
            return response()->json(['message' => 'Объявление с указанным айди не найдено!'], 409);
        }
        $data = $request->all();
        $advert->forceFill($data);
        $advert->save();
        return $advert;
    }

    public function setInFavorite(Request $request, $id) {
        $advert = Advert::find($id);
        if ($advert == null) {
            return response()->json(['message' => 'Объявление с указанным айди не найдено!'], 409);
        }
        if (!$request->user()->favorites()->where('advert_id', $id)->exists()) {
            $request->user()->favorites()->attach($id);
        }
        return response()->json(['in_favorite' => true], 200);
    }

    public function unsetInFavorite(Request $request, $id) {
        $advert = Advert::find($id);
        if ($advert == null) {
            return response()->json(['message' => 'Объявление с указанным айди не найдено!'], 409);
        }
        if ($request->user()->favorites()->where('advert_id', $id)->exists()) {
            $request->user()->favorites()->detach($id);
        }
        return response()->json(['in_favorite' => false], 200);
    }

    public function getFavorites(Request $request) {
        $adverts = Advert::whereHas('favoritesUsers', function ($query) use ($request) {
            $query->where('favorites.user_id', '=', $request->user()->id);
        })
        ->with('AdvertLegalInformation', 'AdvertTechnicalInformation', 'user:id,name,avatar')->paginate(12);
        if ($request->user() != null){
            $myFavorites = Favorite::where('user_id', '=', $request->user()->id)->select('advert_id')->get();
            foreach ($adverts as $advert) {
                $advert['in_favorites'] = $myFavorites->contains('advert_id', $advert->id) ? true : false;
            }
        }
        else {
            foreach ($adverts as $advert) {
                $advert['in_favorites'] = false;
            }
        }
        return $adverts;
    }

    public function getRecentlyViews(Request $request) {
        $adverts = Advert::whereHas('viewsUsers', function ($query) use ($request) {
            $query->where('advert_views.user_id', '=', $request->user()->id);
        })
        ->with('AdvertLegalInformation', 'AdvertTechnicalInformation', 'user:id,name,avatar')->paginate(12);
        return $adverts;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advert $advert) {
        //
    }
}
