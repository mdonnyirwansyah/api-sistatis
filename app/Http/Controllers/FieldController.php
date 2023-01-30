<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Http\Resources\FieldCollection;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::orderBy('name', 'ASC')->get();

        return new FieldCollection($fields);
    }
}
