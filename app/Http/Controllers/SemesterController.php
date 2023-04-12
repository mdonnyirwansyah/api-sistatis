<?php

namespace App\Http\Controllers;

use App\Http\Resources\SemesterCollection;
use App\Services\SemesterService;

class SemesterController extends Controller
{
    public function index() {
        return new SemesterCollection(SemesterService::getAll());
    }
}
