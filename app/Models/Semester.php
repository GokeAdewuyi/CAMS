<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function getSessionAttribute(): string
    {
        return ((int) $this->attributes['session'] - 1).'/'.$this->attributes['session'];
    }
}
