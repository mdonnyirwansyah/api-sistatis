<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiefOfExaminer extends Model
{
    use HasFactory;

    protected $table = 'chief_of_examiners';

    protected $guarded = [];

    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
}
