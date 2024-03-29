<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    protected $table = 'lecturers';

    protected $guarded = [];

    public function fields()
    {
        return $this->morphedByMany(Field::class, 'lecturerable')->withPivot('status');
    }

    public function theses()
    {
        return $this->morphedByMany(Thesis::class, 'lecturerable');
    }

    public function supervisors1()
    {
        return $this->morphedByMany(Thesis::class, 'lecturerable')->wherePivot('status', 'Pembimbing 1');
    }

    public function supervisors2()
    {
        return $this->morphedByMany(Thesis::class, 'lecturerable')->wherePivot('status', 'Pembimbing 2');
    }

    public function seminars()
    {
        return $this->morphedByMany(Seminar::class, 'lecturerable')->withPivot('status');
    }

    public function chiefOfExaminers()
    {
        return $this->hasMany(ChiefOfExaminer::class);
    }
}
