<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeyController extends Controller
{
    public static function getApiKey()
    {
        $key = 'RGAPI-bb25c779-538a-4f4c-88c9-1560e197e9dd';
        return $key;
    }
}