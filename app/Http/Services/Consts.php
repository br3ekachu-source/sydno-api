<?php

namespace App\Http\Services;

enum AdvertState:int {
    case Draft = 1; //черновик
    case Active = 2; //активное
    case Inactive = 3; //неактивное
    case Deleted = 0; //удаленное
}

enum VesselType:int {
    case FullSizeSelfPropelled = 0; //полноразмерное самоходное
    case FullSizeNonSelfPropelled = 1; //полноразмерное несамоходное
    case SmallSizeSelfPropelled = 2; //маломерное самоходное
    case SmallSizeNonSelfPropelled = 3; //маломерное несамоходное
}

