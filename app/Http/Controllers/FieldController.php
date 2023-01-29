<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Http\Resources\FieldCollection;
use App\Http\Resources\FieldResource;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = Field::orderBy('name', 'ASC')->get();

        return new FieldCollection($fields);
    }
}
