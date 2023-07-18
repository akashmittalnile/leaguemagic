<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramLocation extends Model
{
    protected $table = 'program_locations';
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
