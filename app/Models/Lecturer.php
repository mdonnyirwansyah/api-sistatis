<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    protected $table = 'lecturers';

    protected $guarded = [];

    /**
     * The fields that belong to the lecturer.
     */
    public function fields()
    {
        return $this->morphedByMany(Field::class, 'lecturerable')->withPivot(['status'])->orderBy('status', 'ASC');
    }

    /**
     * The theses that belong to the lecturer.
     */
    public function theses()
    {
        return $this->morphedByMany(Thesis::class, 'lecturerable');
    }

    /**
     * The seminars that belong to the lecturer.
     */
    public function seminars()
    {
        return $this->morphedByMany(Lecturer::class, 'lecturerable');
    }
}
