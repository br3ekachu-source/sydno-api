<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Consts;

class ConstController extends Controller
{
    public function getSelectors(Request $request) {
        $consts = [];

        if ($request->has('vesseltypes'))
        {
            $consts['vessel_types'] = Consts::getVesselTypes();
        }
        if ($request->has('exploitationtypes'))
        {
            $consts['exploitation_types'] = Consts::getExploitationType();
        }
        if ($request->has('flags'))
        {
            $consts['flags'] = Consts::getFlags();
        }
        
        return response()->json(['message' => $consts]);
    }
}
