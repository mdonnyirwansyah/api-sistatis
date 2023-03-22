<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterOfLetter extends Model
{
    use HasFactory;

    protected $table = 'counter_of_letters';

    protected $guarded = [];
}
