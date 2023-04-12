<?php
namespace App\Services;

use App\Models\Location;

class LocationService
{
    public static function getAll()
    {
        return Location::orderBy('name', 'ASC')->get();
    }
}
