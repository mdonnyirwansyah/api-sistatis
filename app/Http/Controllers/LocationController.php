<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Http\Resources\LocationCollection;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('name', 'ASC')->get();

        return new LocationCollection($locations);
    }
}
