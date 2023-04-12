<?php
namespace App\Services;

use App\Models\Field;

class FieldService
{
    public static function getAll()
    {
        return Field::orderBy('name', 'ASC')->get();
    }
}
