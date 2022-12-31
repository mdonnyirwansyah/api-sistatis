<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
    use HasFactory;

    protected $table = 'theses';

    protected $guarded = [];

    /**
     * Get the student that owns the thesis.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the field that owns the thesis.
     */
    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    /**
     * The lecturers that belong to the thesis.
     */
    public function lecturers()
    {
        return $this->morphToMany(Lecturer::class, 'lecturerable')->withPivot(['status']);
    }

    /**
     * Get the seminars for the thesis.
     */
    public function seminars()
    {
        return $this->hasMany(Seminar::class);
    }
}
