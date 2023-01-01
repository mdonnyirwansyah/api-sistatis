<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;

    protected $table = 'seminars';

    protected $guarded = [];

    /**
     * The lecturers that belong to the seminar.
     */
    public function lecturers()
    {
        return $this->morphToMany(Lecturer::class, 'lecturerable')->withPivot(['status']);
    }

    /**
     * Get the location that owns the seminar.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the thesis that owns the seminar.
     */
    public function thesis()
    {
        return $this->belongsTo(Thesis::class);
    }
}
