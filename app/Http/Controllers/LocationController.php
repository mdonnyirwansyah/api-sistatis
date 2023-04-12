<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationCollection;
use App\Services\LocationService;

class LocationController extends Controller
{
    public function index()
    {
        return new LocationCollection(LocationService::getAll());
    }
}
