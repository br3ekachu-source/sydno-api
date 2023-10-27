<?php

namespace App\Http\Services;

enum AdvertState:int {
    case Draft = 1; //черновик
    case Active = 2; //активное
    case Inactive = 3; //неактивное
    case Deleted = 0; //удаленное
}

