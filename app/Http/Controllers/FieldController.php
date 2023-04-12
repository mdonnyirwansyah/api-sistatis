<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Http\Resources\FieldCollection;
use App\Services\FieldService;

class FieldController extends Controller
{
    public function index()
    {
        return new FieldCollection(FieldService::getAll());
    }
}
