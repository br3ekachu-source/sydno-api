<?php

namespace App\Http\Services;

class Files 
{
    public static function getUrl($path)
    {
        return env('APP_URL').'/api/files/'.$path;
    }

}