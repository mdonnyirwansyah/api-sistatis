<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $guarded = [];

    /**
     * Get the phone associated with the user.
     */
    public function thesis()
    {
        return $this->hasOne(Thesis::class);
    }
}
