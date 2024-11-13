<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CityController extends Controller
{
    public function getCities($countryCode)
    {
        $cities = config("cities.$countryCode", []);
        return response()->json($cities);
    }
}
