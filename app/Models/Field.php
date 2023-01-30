<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $table = 'fields';

    protected $guarded = [];

    public function lecturers()
    {
        return $this->morphToMany(Lecturer::class, 'lecturerable');
    }
}
