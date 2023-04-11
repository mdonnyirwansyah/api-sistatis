<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;

    protected $table = 'seminars';

    protected $guarded = [];

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case 2:
                return 'Validasi';
                break;

            case 1:
                return 'Penjadwalan';
                break;

            default:
                return 'Pendaftaran';
                break;
        }
    }

    public function lecturers()
    {
        return $this->morphToMany(Lecturer::class, 'lecturerable')->withPivot('status');
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
