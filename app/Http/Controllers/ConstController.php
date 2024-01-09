<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Consts;

class ConstController extends Controller
{
    public function getSelectors(Request $request) {
        $consts = [];

        if ($request->has('vesseltypes')){
            $consts['vessel_types'] = Consts::getVesselTypes();
        }
        if ($request->has('exploitationtypes')){
            $consts['exploitation_types'] = Consts::getExploitationType();
        }
        if ($request->has('materials')){
            $consts['materials'] = Consts::getMaterials();
        }
        if ($request->has('vesselstatuses')){
            $consts['vessel_statuses'] = Consts::getVesselStatuses();
        }
        if ($request->has('frachtpricetypes')){
            $consts['fracht_price_types'] = Consts::getFrachtPriceTypes();
        }
        
        return response()->json(['message' => $consts]);
    }
}
