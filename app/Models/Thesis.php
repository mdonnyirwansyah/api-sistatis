<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
    use HasFactory;

    protected $table = 'theses';

    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function lecturers()
    {
        return $this->morphToMany(Lecturer::class, 'lecturerable')->withPivot(['status'])->orderBy('status', 'ASC');
    }

    public function seminars()
    {
        return $this->hasMany(Seminar::class);
    }
}
