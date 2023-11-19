<?php

namespace App\Http\Services;

enum AdvertState:int {
    case Draft = 1; //черновик
    case Moderation = 2; //на модерации
    case Active = 3; //активное
    case Inactive = 4; //неактивное
    case Deleted = 0; //удаленное
}

enum VesselType:int {
    case FullSizeSelfPropelled = 0; //полноразмерное самоходное
    case FullSizeNonSelfPropelled = 1; //полноразмерное несамоходное
    case SmallSizeSelfPropelled = 2; //маломерное самоходное
    case SmallSizeNonSelfPropelled = 3; //маломерное несамоходное
}

enum ExploitationType:int {
    case Commercial = 0;//коммерческое
    case NonCommercial = 1;//некоммерческое
}


