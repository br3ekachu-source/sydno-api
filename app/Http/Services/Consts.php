<?php

namespace App\Http\Services;

enum AdvertState: int {
    case Draft = 1;
    case Active = 2;
    case Inactive = 3;
    case Deleted = 0;
}