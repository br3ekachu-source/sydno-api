<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Consts;

class ConstController extends Controller
{
    public function getSelectors(Request $request) {
        $consts = [];

        if ($request->has('vesseltypes')){
            $consts['vesseltypes'] = Consts::getVesselTypes();
        }
        if ($request->has('exploitationtypes')){
            $consts['exploitationtypes'] = Consts::getExploitationType();
        }
        if ($request->has('materials')){
            $consts['materials'] = Consts::getMaterials();
        }
        if ($request->has('vesselstatuses')){
            $consts['vesselstatuses'] = Consts::getVesselStatuses();
        }
        if ($request->has('frachtpricetypes')){
            $consts['frachtpricetypes'] = Consts::getFrachtPriceTypes();
        }
        
        return response()->json(['message' => $consts]);
    }
}
