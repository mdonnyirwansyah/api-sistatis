<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;

    protected $table = 'seminars';

    protected $guarded = [];

    public function lecturers()
    {
        return $this->morphToMany(Lecturer::class, 'lecturerable')->withPivot(['status'])->orderBy('status', 'ASC');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function thesis()
    {
        return $this->belongsTo(Thesis::class);
    }

    public function chiefOfExaminer()
    {
        return $this->hasOne(ChiefOfExaminer::class);
    }
}
