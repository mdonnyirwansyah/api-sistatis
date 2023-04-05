<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $guarded = [];

    public function thesis()
    {
        return $this->hasOne(Thesis::class);
    }
}
