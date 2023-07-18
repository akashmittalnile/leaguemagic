<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramSlot extends Model
{
    protected $table = 'program_slots';
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
