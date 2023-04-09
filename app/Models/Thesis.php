<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
    use HasFactory;

    protected $table = 'theses';

    protected $guarded = [];

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case 3:
                return 'Sidang Tugas Akhir';
                break;

            case 2:
                return 'Seminar Hasil Tugas Akhir';
                break;

            case 1:
                return 'Seminar Proposal Tugas Akhir';
                break;

            default:
                return 'Pendaftaran Tugas Akhir';
                break;
        }
    }

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
        return $this->morphToMany(Lecturer::class, 'lecturerable')->withPivot('status');
    }

    public function seminars()
    {
        return $this->hasMany(Seminar::class);
    }
}
