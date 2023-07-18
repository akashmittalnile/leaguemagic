<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramDate extends Model
{
    protected $table = 'program_schedules';
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
