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

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case 1:
                return 'Lulus';
                break;

            default:
                return 'Belum Lulus';
                break;
        }
    }

    public function thesis()
    {
        return $this->hasOne(Thesis::class);
    }
}
